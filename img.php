<?php
// Suppress deprecation notices — they would corrupt binary image output
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

/**
 * img.php — on-the-fly image processor
 *
 * Usage: img.php?src=assets/img/projects/some.png&w=720
 *
 * Params:
 *   src    – path to source image (relative to document root)
 *   w      – output width in px (default: original)
 *   h      – output height in px (default: proportional)
 *   q      – JPEG/WebP quality 1–100 (default: 82)
 *   fit    – how to fit into w×h:
 *              scale   – proportional scale, no crop (default)
 *              cover   – crop to fill w×h exactly (like CSS cover)
 *              contain – letterbox into w×h (transparent/bg fill)
 *   crop   – named crop region (used with fit=cover or standalone):
 *              center (default) | top | bottom | left | right
 *              top-left | top-right | bottom-left | bottom-right
 *   half   – take only half the image before any resize:
 *              l | r | t | b
 *   bg     – background hex colour for contain letterbox (default: 000000)
 *   format – force output format: jpeg | png | webp | gif
 */

// ── Helpers ──────────────────────────────────────────────────────────────────

function send_image(string $data, string $mime): void
{
    header('Content-Type: ' . $mime);
    header('Cache-Control: public, max-age=2592000'); // 30 days
    header('Content-Length: ' . strlen($data));
    echo $data;
    exit;
}

function hex_to_rgb(string $hex): array
{
    $hex = ltrim($hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    }
    return [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))];
}

function create_canvas(int $w, int $h, bool $alpha = false)
{
    $img = imagecreatetruecolor($w, $h);
    if ($alpha) {
        imagealphablending($img, false);
        imagesavealpha($img, true);
        $t = imagecolorallocatealpha($img, 0, 0, 0, 127);
        imagefilledrectangle($img, 0, 0, $w, $h, $t);
    }
    return $img;
}

function load_image(string $path, int $type)
{
    switch ($type) {
        case IMAGETYPE_JPEG: return imagecreatefromjpeg($path);
        case IMAGETYPE_PNG:  return imagecreatefrompng($path);
        case IMAGETYPE_GIF:  return imagecreatefromgif($path);
        case IMAGETYPE_WEBP: return imagecreatefromwebp($path);
        default: return false;
    }
}

function encode_image($img, int $type, int $quality, ?string $forceFormat): array
{
    $fmt = $forceFormat;
    if (!$fmt) {
        $fmt = [IMAGETYPE_JPEG=>'jpeg',IMAGETYPE_PNG=>'png',IMAGETYPE_GIF=>'gif',IMAGETYPE_WEBP=>'webp'][$type] ?? 'jpeg';
    }
    ob_start();
    switch ($fmt) {
        case 'jpeg': imagejpeg($img, null, $quality);                              $mime = 'image/jpeg'; break;
        case 'png':  imagepng($img, null, (int) round((100 - $quality) / 10));     $mime = 'image/png';  break;
        case 'gif':  imagegif($img);                                               $mime = 'image/gif';  break;
        case 'webp': imagewebp($img, null, $quality);                              $mime = 'image/webp'; break;
        default:     imagejpeg($img, null, $quality);                              $mime = 'image/jpeg';
    }
    return [ob_get_clean(), $mime];
}

// ── Parse & validate params ───────────────────────────────────────────────────

// ROOT may be defined by bootstrap.php (when called via router),
// or we derive it ourselves (when called directly).
if (!defined('ROOT')) {
    define('ROOT', dirname(__DIR__));
}

$projectRoot = ROOT;
$src      = isset($_GET['src'])    ? $_GET['src']           : '';
$reqW     = isset($_GET['w'])      ? (int)  $_GET['w']      : 0;
$reqH     = isset($_GET['h'])      ? (int)  $_GET['h']      : 0;
$quality  = isset($_GET['q'])      ? (int)  $_GET['q']      : 82;
$fit      = isset($_GET['fit'])    ? $_GET['fit']           : 'scale';
$crop     = isset($_GET['crop'])   ? $_GET['crop']          : 'center';
$half     = isset($_GET['half'])   ? strtolower($_GET['half']) : '';
$bgHex    = isset($_GET['bg'])     ? $_GET['bg']            : '000000';
$format   = isset($_GET['format']) ? strtolower($_GET['format']) : null;

$quality = max(1, min(100, $quality));
$reqW    = max(0, min(4096, $reqW));
$reqH    = max(0, min(4096, $reqH));

$validFits  = ['scale', 'cover', 'contain'];
$validCrops = ['center','top','bottom','left','right','top-left','top-right','bottom-left','bottom-right'];
$validHalfs = ['l','r','t','b'];
$validFmts  = ['jpeg','png','webp','gif',null];

if (!in_array($fit,   $validFits,  true)) $fit   = 'scale';
if (!in_array($crop,  $validCrops, true)) $crop  = 'center';
if (!in_array($half,  array_merge($validHalfs, ['']), true)) $half = '';
if (!in_array($format,$validFmts,  true)) $format = null;

// ── Resolve & secure path ─────────────────────────────────────────────────────

$src = ltrim($src, '/');
$src = str_replace(['../', '..\\', "\0"], '', $src);
$absPath = $projectRoot . '/' . $src;

if (!$src || !file_exists($absPath) || !is_file($absPath)) {
    http_response_code(404); exit('Image not found.');
}
if (strpos(realpath($absPath), realpath($projectRoot)) !== 0) {
    http_response_code(403); exit('Forbidden.');
}

// ── Cache ─────────────────────────────────────────────────────────────────────

$cacheDir = __DIR__ . '/assets/img/_cache';
if (!is_dir($cacheDir)) mkdir($cacheDir, 0755, true);

$cacheKey  = md5($src . $reqW . $reqH . $quality . $fit . $crop . $half . $bgHex . $format);
$cachePath = $cacheDir . '/' . $cacheKey;

if (file_exists($cachePath) && filemtime($cachePath) >= filemtime($absPath)) {
    send_image(file_get_contents($cachePath), mime_content_type($cachePath));
}

// ── Load ──────────────────────────────────────────────────────────────────────

$info = getimagesize($absPath);
if (!$info) { http_response_code(415); exit('Unsupported image type.'); }

[$origW, $origH, $type] = $info;
$hasAlpha = in_array($type, [IMAGETYPE_PNG, IMAGETYPE_GIF, IMAGETYPE_WEBP]);

$img = load_image($absPath, $type);
if (!$img) { http_response_code(415); exit('Could not load image.'); }

// ── Half crop ─────────────────────────────────────────────────────────────────

if ($half !== '') {
    $hw = $origW; $hh = $origH; $hx = 0; $hy = 0;
    switch ($half) {
        case 'l': $hw = (int)($origW / 2); break;
        case 'r': $hw = (int)($origW / 2); $hx = $origW - $hw; break;
        case 't': $hh = (int)($origH / 2); break;
        case 'b': $hh = (int)($origH / 2); $hy = $origH - $hh; break;
    }
    $halved = create_canvas($hw, $hh, $hasAlpha);
    imagecopy($halved, $img, 0, 0, $hx, $hy, $hw, $hh);
    // imagedestroy (no-op in PHP 8+)
    $img   = $halved;
    $origW = $hw;
    $origH = $hh;
}

// ── If no resize requested, serve as-is ──────────────────────────────────────

if ($reqW === 0 && $reqH === 0) {
    [$data, $mime] = encode_image($img, $type, $quality, $format);
    // imagedestroy (no-op in PHP 8+)
    file_put_contents($cachePath, $data);
    send_image($data, $mime);
}

// ── Calculate target dimensions ───────────────────────────────────────────────

if ($reqW && !$reqH) {
    $outW = min($reqW, $origW);
    $outH = (int) round($origH * ($outW / $origW));
} elseif ($reqH && !$reqW) {
    $outH = min($reqH, $origH);
    $outW = (int) round($origW * ($outH / $origH));
} else {
    $outW = min($reqW, $origW);
    $outH = min($reqH, $origH);
}

// ── Apply fit ─────────────────────────────────────────────────────────────────

$dst = create_canvas($outW, $outH, $hasAlpha);

if ($fit === 'scale') {
    // Proportional — recalculate height from width
    $outH = (int) round($origH * ($outW / $origW));
    // imagedestroy (no-op in PHP 8+)
    $dst = create_canvas($outW, $outH, $hasAlpha);
    imagecopyresampled($dst, $img, 0, 0, 0, 0, $outW, $outH, $origW, $origH);

} elseif ($fit === 'cover') {
    // Scale to cover, then crop
    $scaleW = $outW / $origW;
    $scaleH = $outH / $origH;
    $scale  = max($scaleW, $scaleH);
    $scaledW = (int) round($origW * $scale);
    $scaledH = (int) round($origH * $scale);

    // Crop anchor
    switch ($crop) {
        case 'top':          $cx = ($scaledW - $outW) / 2; $cy = 0; break;
        case 'bottom':       $cx = ($scaledW - $outW) / 2; $cy = $scaledH - $outH; break;
        case 'left':         $cx = 0;                       $cy = ($scaledH - $outH) / 2; break;
        case 'right':        $cx = $scaledW - $outW;        $cy = ($scaledH - $outH) / 2; break;
        case 'top-left':     $cx = 0;                       $cy = 0; break;
        case 'top-right':    $cx = $scaledW - $outW;        $cy = 0; break;
        case 'bottom-left':  $cx = 0;                       $cy = $scaledH - $outH; break;
        case 'bottom-right': $cx = $scaledW - $outW;        $cy = $scaledH - $outH; break;
        default:             $cx = ($scaledW - $outW) / 2;  $cy = ($scaledH - $outH) / 2;
    }

    // src coords map back to original
    $srcX = (int) round($cx / $scale);
    $srcY = (int) round($cy / $scale);
    $srcW = (int) round($outW / $scale);
    $srcH = (int) round($outH / $scale);

    imagecopyresampled($dst, $img, 0, 0, $srcX, $srcY, $outW, $outH, $srcW, $srcH);

} elseif ($fit === 'contain') {
    // Scale to fit inside, letterbox remainder
    $scale  = min($outW / $origW, $outH / $origH);
    $fitW   = (int) round($origW * $scale);
    $fitH   = (int) round($origH * $scale);
    $offX   = (int) round(($outW - $fitW) / 2);
    $offY   = (int) round(($outH - $fitH) / 2);

    if (!$hasAlpha) {
        [$r, $g, $b] = hex_to_rgb($bgHex);
        $bg = imagecolorallocate($dst, $r, $g, $b);
        imagefilledrectangle($dst, 0, 0, $outW, $outH, $bg);
    }
    imagecopyresampled($dst, $img, $offX, $offY, 0, 0, $fitW, $fitH, $origW, $origH);
}

// imagedestroy (no-op in PHP 8+)

[$data, $mime] = encode_image($dst, $type, $quality, $format);
// imagedestroy (no-op in PHP 8+)

file_put_contents($cachePath, $data);
send_image($data, $mime);
