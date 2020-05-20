<?php

$pdo = new PDO("mysql:dbname=bookstore;host=127.0.0.1;charset=utf8mb4", 'root', '',[
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$query = 'SELECT book.id, book.title, author.name as authorName, genre.genre_name as genreName FROM book 
 join bookstore.author  on book.author_id = author.id 
 join bookstore.genre  using(genre_id);';
$result = $pdo->query($query);

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
        <?php foreach ($result as $row):?>
            <tr class="table-info">
                <td><?=$row['id']?></td>
                <td><?=$row['title']?></td>
                <td><?=$row['authorName']?></td>
                <td><?=$row['genreName']?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
