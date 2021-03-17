<!DOCTYPE html>
<html lang="fr" class="h-100">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlentities($title) ?? 'Mon site' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
</head>

<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary ps-4">
        <a href="" class="navbar-brand">Mon site</a>
    </nav>

    <div class="container mt-4">
        <?= $content ?>
    </div>

    <footer class="bg-light py4 footer mt-auto">
        <div class="container">
            <?php if(defined('DEBUG_TIME')) : ?>
            Page générée en <?= round(1000 * (microtime(true) - DEBUG_TIME)) ?> ms
            <?php endif ?></div>
    </footer>
</body>
</html>