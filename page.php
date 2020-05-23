<?php
require 'functions.php';
$book = getBookById($_GET['id']);
$comments = getComments($_GET['id']);

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
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container">
        <a class="navbar-brand" href="#">Start Bootstrap</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home
                        <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Services</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

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
                    <h4>$24.99</h4>
                    <p class="card-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sapiente dicta fugit
                        fugiat hic aliquam itaque facere, soluta. Totam id dolores, sint aperiam sequi pariatur
                        praesentium animi perspiciatis molestias iure, ducimus!</p>
                    <span class="text-warning">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
                    4.0 stars
                </div>
            </div>
            <!-- /.card -->

            <div class="card card-outline-secondary my-4">
                <div class="card-header">
                    Product Reviews
                </div>

                <div class="card-body">
                    <?php foreach (getComments() as $comment): ?>
                        <?php if ($comment['book_id'] == $book['id']): ?>
                            <p><?= $comment['message'] ?></p>
                            <?php for ($i = 1; $i <= $comment['rating']; $i++): ?>
                                <span class="text-warning">&#9733;</span>
                            <?php endfor; ?>
                            <span><?= $comment['rating'] ?>.0 stars</span>
                            <br/>
                            <small class="text-muted">Posted by Anonymous on <?=formatCommentDate($comment['added_at'])?></small>
                            <hr>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <!--                    --><?php //foreach ($comments as $comment): ?>
                    <!--                        <p>--><? //= $comment['message'] ?><!--</p>-->
                    <!--                        --><?php //for ($i = 1; $i <= $comment['rating']; $i++): ?>
                    <!--                            <span class="text-warning">&#9733;</span>-->
                    <!--                        --><?php //endfor; ?>
                    <!--                        <span>--><? //= $comment['rating'] ?><!--.0 stars</span>-->
                    <!--                        <br/>-->
                    <!--                        <small class="text-muted">Posted by Anonymous on 3/1/17</small>-->
                    <!--                        <hr>-->
                    <!--                    --><?php //endforeach; ?>
                    <form method="post" action="add_comment.php">
                        <div class="form-group">
                            <input name="id" type="hidden" value="<?=htmlspecialchars($_GET['id'])?>">
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
        <p class="m-0 text-center text-white">Copyright &copy; Your Website <?=date('Y')?>></p>
    </div>
    <!-- /.container -->
</footer>

<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
