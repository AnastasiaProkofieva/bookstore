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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
<div class="container">
    <table class="table table-sm">
        <thead>
        <tr class="table-active" >
            <th>#</th>
            <th>Book title</th>
            <th>Book author</th>
            <th>Book genre</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($books as $book):?>
            <tr class="table-info">
                <td><?=$book['id']?></td>
                <td><a href="/page.php?id=<?=$book['id']?>"><?=htmlspecialchars($book['title'])?></a></td>
                <td><?=$book['authorName']?></td>
                <td><?=$book['genre_name']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <br/>
    <a href="page.php">Link</a>
</div>
</body>
</html>
