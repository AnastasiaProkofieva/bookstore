<?php

require 'functions.php';
$books = getBooks();

//foreach ($result as $row) {
//    $books[] = $row;
//}
//print_r($books);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<div class="container">
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
                        <a href="/page.php?id=<?= $book['id'] ?>">Подробнее</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

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
    </div>
<?=paginate()?>
</body>
</html>
