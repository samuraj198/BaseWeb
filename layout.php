<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
          crossorigin="anonymous">
    <title>{{ title }}</title>
</head>
<body>
<nav class="navbar navbar-expand bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/">Practice 1</a>
        <div class="navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="/">Home</a>
                </li>
                <?php
                if (empty($_SESSION['auth'])) { ?>
                <li class="nav-item d-flex">
                    <a class="nav-link" href="/auth">Auth</a>
                    <a class="nav-link" href="/register">Register</a>
                </li>
                <?php
                } else { ?>
                    <li class="nav-item d-flex">
                        <a class="nav-link text-danger" href="/logout">Log out</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>
<main class="d-flex flex-column align-items-center">
    {{ content }}
</main>
</body>
</html>