<?php

require 'functions.php';

session_start();
$books = getBooks();


//foreach ($result as $row) {
//    $books[] = $row;
//}
//print_r($books);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Heroic Features - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/heroic-features.css" rel="stylesheet">
</head>

<body>
<!-- Navigation -->
<?php require_once './templates/header.php' ?>

<!-- Page Content -->

<div class="container">

    <!-- Jumbotron Header -->

    <header class="jumbotron my-4">
        <h1 class="display-3">A Warm Welcome!</h1>
        <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsa, ipsam, eligendi, in quo sunt
            possimus non incidunt odit vero aliquid similique quaerat nam nobis illo aspernatur vitae fugiat numquam
            repellat.</p>
        <a href="#" class="btn btn-primary btn-lg">Call to action!</a>
    </header>
    <!-- Page Features -->
    <div class="row text-center">
        <?php foreach ($books as $book): ?>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="card h-100">
                    <img class="card-img-top" src="http://placehold.it/500x325" alt="">
                    <div class="card-body">
                        <h4 class="card-title"><?= $book['title'] ?></h4>
                        <p class="card-text">Автор: <?= $book['authorName'] ?>, Жанр: <?= $book['genre_name'] ?></p>
                    </div>
                    <div class="card-footer">
                        <a href="<?= getBookUrl($book) ?>" class="btn btn-primary">Подробнее</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <!--    <table class="table table-sm">-->
    <!--        <thead>-->
    <!--        <tr class="table-active" >-->
    <!--            <th>#</th>-->
    <!--            <th>Book title</th>-->
    <!--            <th>Book author</th>-->
    <!--            <th>Book genre</th>-->
    <!--        </tr>-->
    <!--        </thead>-->
    <!--        <tbody>-->
    <!--        --><?php //foreach ($books as $book):?>
    <!--            <tr class="table-info">-->
    <!--                <td>--><? //=$book['id']?><!--</td>-->
    <!--                <td><a href="/page.php?id=--><? //=$book['id']?><!--">-->
    <? //=htmlspecialchars($book['title'])?><!--</a></td>-->
    <!--                <td>--><? //=$book['authorName']?><!--</td>-->
    <!--                <td>--><? //=$book['genre_name']?><!--</td>-->
    <!--            </tr>-->
    <!--        --><?php //endforeach; ?>
    <!--        </tbody>-->
    <!--    </table>-->
    <!--    <br/>-->
    <!--    -->

    <?= paginate() ?>
    <!-- /.container -->
</div>
<!-- Footer -->
<footer class="py-5 bg-dark">
    <div class="container">
        <p class="m-0 text-center text-white">Copyright &copy; Your Website <?= date('Y') ?></p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary"  style="display: none" data-toggle="modal" data-target="#exampleModalCenter">
    Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Статус заказа</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?=getPaymentStatusMessage()?>
            </div>

        </div>
    </div>
</div>
</body>
</html>
