<?php
$code = http_response_code();

$messages = [
    400 => ['Bad Request',           'The server could not understand your request.'],
    403 => ['Forbidden',             'You don\'t have permission to access this page.'],
    404 => ['Not Found',             'The page you\'re looking for doesn\'t exist.'],
    405 => ['Method Not Allowed',    'This request method is not supported here.'],
    500 => ['Internal Server Error', 'Something went wrong on our end. Try again later.'],
    503 => ['Service Unavailable',   'The service is temporarily unavailable.'],
];

[$title, $desc] = $messages[$code] ?? ['Error', 'An unexpected error occurred.'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $code ?> – <?= htmlspecialchars($title) ?></title>
    <link rel="stylesheet" href="/assets/css/app.css">
</head>
<body>
    <section class="section__error">
        <span class="section-indicator">#error</span>
        <h1 class="error__code"><?= $code ?></h1>
        <h2 class="error__title"><?= htmlspecialchars($title) ?></h2>
        <p class="error__desc"><?= htmlspecialchars($desc) ?></p>
        <a href="/" class="error__back">← Back to home</a>
    </section>
</body>
</html>
