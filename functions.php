<?php
define('ITEMS_PER_PAGE', 8);
function getPDO()
{
    $pdo = new PDO("mysql:dbname=bookstore;host=127.0.0.1;charset=utf8mb4", 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    return $pdo;
}

function getBooks(): array
{
    $page = getPageNumber();
    $offset = ($page - 1) * ITEMS_PER_PAGE;
    $query = "SELECT book.id, book.title, author.name as authorName, genre.genre_name FROM book 
left join bookstore.author  on book.author_id = author.id 
left join bookstore.genre  using(genre_id)

order by book.id asc LIMIT $offset,8
";
    $pdo = getPDO();
    $result = $pdo->query($query);
    $result->setFetchMode(PDO:: FETCH_ASSOC);
    return $result->fetchAll();
//    $books= [];
//    foreach ($result as $row){
//        $books[]=$row;
//    }
//    return $books;
}

function getBookById($bookId): array
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
    $result->setFetchMode(PDO:: FETCH_ASSOC);
    return $result->fetch();
}

function getGenres(): array
{
    $query = 'select genre_id, genre_name from genre';
    $pdo = getPDO();
    $result = $pdo->query($query);
    return $result->fetchAll(PDO:: FETCH_ASSOC);
}

//function getComments($bookId): array
//{
//    $query = 'select * from Comment WHERE book.id = ?';
//    $pdo = getPDO();
//    $result = $pdo->prepare($query);
//    $result->execute([$bookId]);
//    return $result->fetchAll(PDO:: FETCH_ASSOC);
//}
function getComments(): array
{
    $query = 'select * from Comment ';
    $pdo = getPDO();
    $result = $pdo->query($query);
    return $result->fetchAll(PDO:: FETCH_ASSOC);
}

function addComment($comment, $bookId)
{
    $sql = "INSERT INTO `Comment`(message, book_id) VALUES (:comment,:book)";
    $pdo = getPDO();
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'comment' => $comment,
        'book' => $bookId
    ]);
}

function formatCommentDate(string $date): string
{
    $time = strtotime($date);
    return date('n/j/y', $time);
}

function getPageNumber(): int
{
    $page = $_GET['page'] ?? 1;
    $total = getTotal();
    if ($page < 1) {
        $page = 1;
    } elseif ($page > $total) {
        $page = $total;
    }
    return $page;
}

function paginate()
{
    $page = getPageNumber();
    $pageCount = getTotal();
    $startPos = getPageNumber();
    for ($i = 0; $i < 2; $i++) {
        if ($startPos === 1) {
            break;
        }
        $startPos--;
    }
    $endPos = $page;
    for ($i = 0; $i < 2; $i++) {
        if ($endPos === $pageCount) {
            break;
        }
        $endPos++;
    }
    $buttons = "";
    for ($i = $startPos; $i <= $endPos; $i++) {
        $active =$page === $i ? 'active' : '';
        $buttons .= "<li class=\"page-item $active\"><a class=\"page-link\" href=\"?page=$i\">$i</a></li>";
    }
    return <<<PAGE
<nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="?page=1" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                </a>
            </li>
            $buttons
            <li class="page-item">
                <a class="page-link" href="?page=$pageCount" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                </a>
            </li>
        </ul>
    </nav>
PAGE;

}

function getTotal(): int
{
    static $count;
    if ($count == null) {
        $sql = 'SELECT COUNT(1) FROM book';
        $pdo = getPDO();
        $stmt = $pdo->query($sql);
        $total = $stmt->fetch(PDO::FETCH_COLUMN);
        $count = ceil($total / ITEMS_PER_PAGE);
        return $count;
    }
    return $count;
}