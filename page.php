<?php
require 'functions.php';

try {
    if (!empty($_GET['id'])) {
        $book = getBookById($_GET['id']);
    } elseif (!empty($_GET['url'])) {
        $book = getBookByUrl($_GET['url']);
    }else{
        throw new \Exception('');
    }
} catch (\Throwable $err) {
    header("HTTP/1.0 404 Not Found");
    exit();
}

$comments = getComments($book['id']);

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Shop Item - Start Bootstrap Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/shop-item.css" rel="stylesheet">

</head>

<body>

<!-- Navigation -->
<?php require_once './templates/header.php' ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <div class="col-lg-3">
            <h1 class="my-4">Shop Name</h1>
            <div class="list-group">
                <?php foreach (getGenres() as $genre): ?>
                    <a href="#"
                       class="list-group-item <?= ($genre['genre_id'] == $book['genre_id']) ? 'active' : '' ?>"><?= $genre['genre_name'] ?></a>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- /.col-lg-3 -->

        <div class="col-lg-9">

            <div class="card mt-4">
                <img class="card-img-top img-fluid" src="http://placehold.it/900x400" alt="">
                <div class="card-body">
                    <h3 class="card-title"><?= $book['title'] ?></h3>
                    <h4><?= $book['cost'] ?> UAH</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente dicta fugit
                        fugiat hic aliquam itaque facere, soluta. Totam id dolores, sint aperiam sequi pariatur
                        praesentium animi perspiciatis molestias iure, ducimus!</p>
                    <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
                    4.0 stars
                </div>
                <form class="form-inline" method="post" action="/add_to_cart.php">
                    <div class="form-group">
                        <input type="hidden" name="id" value="<?= $book['id'] ?>">
                        <label for="count">Количество: </label>
                        <input type="number" class="form-control" min="1" value="1" id="count" name="count"/>
                    </div>
                    <button type="submit" class="btn btn-success">Добавить в Корзину</button>
                </form>
            </div>

            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Product Reviews
                </div>

                <div class="card-body">
                    <?php foreach ($comments as $comment): ?>
                        <p><?= htmlspecialchars($comment['message']) ?></p>
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <?php $star = $comment['rating'] < $i ? '&#9734;' : '&#9733;' ?>
                            <span class="text-warning"><?= $star ?></span>
                        <?php endfor; ?>
                        <?php $starAmount = $comment['rating'] > 1 ? $comment['rating'] . ".0 stars" : $comment['rating'] . ".0 star" ?>
                        <span><?= $starAmount ?></span>
                        <br/>
                        <small class="text-muted">Posted by Anonymous on <?= formatCommentDate($comment['added_at']) ?></small>
                        <hr>
                    <?php endforeach; ?>
                    <!--                    -->
                    <form method="post" action="/add_comment.php">
                        <div class="form-group">
                            <input name="id" type="hidden" value="<?= htmlspecialchars($book['id']) ?>">
                            <label for="exampleFormControlTextarea1"></label>
                            <textarea class="form-control" name="comment" id="exampleFormControlTextarea1"
                                      rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success">Добавить</button>
                    </form>
                    <br/>
                    <!--                    <a href="#" class="btn btn-success">Leave a Review</a>-->
                </div>
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col-lg-9 -->

    </div>

</div>
<!-- /.container -->

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

</body>

</html>
