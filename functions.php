<?php
function getPDO()
{
    $pdo = new PDO("mysql:dbname=bookstore;host=127.0.0.1;charset=utf8mb4", 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    return $pdo;
}
function getBooks(): array
{
    $query = "SELECT book.id, book.title, author.name as authorName, genre.genre_name FROM book 
left join bookstore.author  on book.author_id = author.id 
left join bookstore.genre  using(genre_id)

order by book.id asc";
    $pdo = getPDO();
    $result = $pdo->query($query);
    $result-> setFetchMode(PDO:: FETCH_ASSOC);
    return $result->fetchAll();
//    $books= [];
//    foreach ($result as $row){
//        $books[]=$row;
//    }
//    return $books;
}
function getBookById($bookId):array
{
    $query = "SELECT book.id, book.title, author.name as authorName, genre.genre_name, genre.genre_id, book.genre_id, 
Comment.message, Comment.book_id, Comment.comment_id, Comment.rating FROM book 
left join bookstore.author  on book.author_id = author.id
left join bookstore.Comment  on book.id = Comment.book_id 
left join bookstore.genre  using(genre_id)  
where book.id=?
";
    $pdo = getPDO();
    $result = $pdo->prepare($query);
    $result->execute([$bookId]);
    $result-> setFetchMode(PDO:: FETCH_ASSOC);
    return $result->fetch();
}
function getGenres(): array
{
    $query = 'select genre_id, genre_name from genre';
    $pdo = getPDO();
    $result = $pdo->query($query);
    return $result->fetchAll(PDO:: FETCH_ASSOC);
}
function getComments(): array
{
    $query = 'select book_id, message,comment_id, rating from Comment';
    $pdo = getPDO();
    $result = $pdo->query($query);
    return $result->fetchAll(PDO:: FETCH_ASSOC);
}
