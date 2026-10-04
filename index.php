<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nick'])) {
    $nick = htmlspecialchars(trim($_POST['nick']));
    $email = htmlspecialchars(trim($_POST['email']));
    $comment = htmlspecialchars(trim($_POST['comment']));
    $date = date('d.m.Y H:i');
    $row = [$nick, $email, $comment, 'Czeka na weryfikację', $date];
    $fp = fopen('comments.csv', 'a');
    fputcsv($fp, $row, ';');
    fclose($fp);
    header('Location: index.php?sent=1');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Pan Tadeusz</title>
    <style>
        #reading-progress{position:fixed;top:0;left:0;width:0%;height:4px;background:#dc3545;z-index:9999;transition:width .1s}
        #js-content{line-height:1.7;min-height:400px}
        .reader-toolbar{position:sticky;top:10px;z-index:10}
        .spinner-border{width:3rem;height:3rem;border:0.25em solid currentColor;border-right-color:transparent;border-radius:50%;animation:spin .75s linear infinite}
        @keyframes spin{to{transform:rotate(360deg)}}
    </style>
</head>
<body>
<div id="reading-progress"></div>
<header class="bg-danger text-white text-center py-4 mb-4">
    <h1>Pan Tadeusz, czyli ostatni zajazd na Litwie: historia szlachecka z roku 1811 i 1812 we dwunastu księgach wierszem</h1>
    <p>Adam Mickiewicz</p>
</header>

<section class="container-fluid">
    <div class="row">
        <div class="col-3">
            <div class="mb-3">
                <input type="text" id="search-books" class="form-control" placeholder="Szukaj księgi...">
            </div>
            <div class="list-group" id="js-navigation">
                <a href="home.html" class="list-group-item list-group-item-action bg-danger text-white active">Strona główna</a>
                <a href="k1.html" class="list-group-item list-group-item-action">Księga 1</a>
                <a href="k2.html" class="list-group-item list-group-item-action">Księga 2</a>
                <a href="k3.html" class="list-group-item list-group-item-action">Księga 3</a>
                <a href="k4.html" class="list-group-item list-group-item-action">Księga 4</a>
                <a href="k5.html" class="list-group-item list-group-item-action">Księga 5</a>
                <a href="k6.html" class="list-group-item list-group-item-action">Księga 6</a>
                <a href="k7.html" class="list-group-item list-group-item-action">Księga 7</a>
                <a href="k8.html" class="list-group-item list-group-item-action">Księga 8</a>
                <a href="k9.html" class="list-group-item list-group-item-action">Księga 9</a>
                <a href="k10.html" class="list-group-item list-group-item-action">Księga 10</a>
                <a href="k11.html" class="list-group-item list-group-item-action">Księga 11</a>
                <a href="k12.html" class="list-group-item list-group-item-action">Księga 12</a>
            </div>
        </div>

        <div class="col-6">
            <div class="reader-toolbar d-flex justify-content-between align-items-center mb-3 p-2 border rounded bg-light">
                <div>
                    <button id="font-minus" class="btn btn-sm btn-outline-secondary">A-</button>
                    <button id="font-plus" class="btn btn-sm btn-outline-secondary">A+</button>
                </div>
                <button id="dark-toggle" class="btn btn-sm btn-outline-dark"> Tryb nocny</button>
            </div>
            <div id="js-content">
                <div class="text-center p-5"><div class="spinner-border text-danger"></div><p class="mt-2">Ładowanie...</p></div>
            </div>
        </div>

        <div class="col-3">
            <img src="pan-tadeusz.png" alt="Pan Tadeusz" class="img-fluid rounded mb-4">
            <form action="" method="post">
                <div class="mb-3"><label class="form-label">Pseudonim</label><input name="nick" type="text" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Adres e-mail</label><input name="email" type="email" class="form-control" required></div>
                <div class="mb-3"><label class="form-label">Komentarz</label><textarea name="comment" class="form-control" rows="4" required></textarea></div>
                <button type="submit" class="btn btn-danger w-100">Wyślij</button>
            </form>
        </div>
    </div>
</section>

<footer class="bg-danger text-white text-center py-4 mt-4">
    <h5 class="mb-0">Agnieszka Bochnak, Akademia Nauk Stosowanych w Nowym Targu</h5>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<script src="js/main.js"></script>
</body>
</html>
