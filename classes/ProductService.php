<?php


class ProductService
{
    private $isPaginationEnabled;

    public function __construct(bool $isPaginationEnabled = true)
    {
        $this->isPaginationEnabled = $isPaginationEnabled;
    }

    public function getProductsList(array $ids = []): array
    {
        $page = getPageNumber();
        $offset = ($page - 1) * ITEMS_PER_PAGE;
        $query = "SELECT book.id, book.title, book.url, author.name as authorName, genre.genre_name, book.cost FROM book 
left join bookstore.author  on book.author_id = author.id 
left join bookstore.genre  using(genre_id)
WHERE visability = 1 
%s
ORDER BY id 
";
        if ($this->isPaginationEnabled) {
            $query .= " LIMIT $offset,8";
        }
//left join bookstore.author  on book.author_id = author.id
//left join bookstore.genre  using(genre_id)
//WHERE book.id IN (2,3,4)
//order by book.id asc LIMIT $offset,8
        $where = '';
        if (!empty($ids)) {
            $where = sprintf(' AND book.id IN (%s) ', implode(',', $ids));
        }
        $query = sprintf($query, $where);
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

    public function getBookById($bookId): array
    {
        $query = "SELECT book.id, book.title, author.name as authorName, genre.genre_name, genre.genre_id, book.genre_id, book.url,
Comment.message, Comment.book_id, Comment.comment_id, Comment.rating, book.cost, book.visability FROM book 
left join bookstore.author  on book.author_id = author.id
left join bookstore.Comment  on book.id = Comment.book_id 
left join bookstore.genre  using(genre_id)  
where  book.id = ?
";
        $pdo = getPDO();
        $result = $pdo->prepare($query);
        $result->execute([$bookId]);
        $result->setFetchMode(PDO:: FETCH_ASSOC);
        return $result->fetch();
    }

    public function update($bookId, array $data)
    {
        try {
            $pdo = getPDO();
            $pdo->beginTransaction();
            // update bbok set val=1, cost=1
            $authorId = $this->upsertAuthor($data['author']);
            $genreId = $this->getGenre($data['genre']);
            $sql = "UPDATE book SET author_id= :author, genre_id = :genre, cost = :cost, title = :title
where id = :id
";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'author' => $authorId,
                'genre' => $genreId,
                'cost' => $data['cost'],
                'title' => $data['title'],
                'id' => $bookId
            ]);
            //TODO : update book
            $pdo->commit();
        } catch (\Exception $e) {
            echo"<h1>{$e->getMessage()}</h1>";
            $pdo->rollBack();
        }
    }

    private function upsertAuthor($name): int
    {
        $authorSql = 'SELECT id from author where name like ?';
        $pdo = getPDO();
        $stmt = $pdo->prepare($authorSql);
        $stmt->execute([$name]);
        $authorId = (int)$stmt->fetchColumn();
        if ($authorId) {
            return $authorId;
        }
        $sql = 'insert into author (name) VALUES (?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute($name);
        return (int)$pdo->lastInsertId();
    }

    private function getGenre($name): int
    {

        $genreSql = 'SELECT genre_id from genre where genre_name like ?';
        $pdo = getPDO();
        $stmt = $pdo->prepare($genreSql);
        $stmt->execute([$name]);
        $genreId = (int)$stmt->fetchColumn();
        if (!empty($genreId)) {
            return $genreId;
        }
        throw  new Exception('something wrong with product edit');

    }
    public function deleteBook($bookId)
    {
        try {
            $pdo = getPDO();
            $pdo->beginTransaction();
            $visability = $this->upsertVisability($bookId);
            $sql = "UPDATE book SET visability = :visability where id = :id
";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'visability' => $visability,
                'id' => $bookId
            ]);
            //TODO : delete book
            $pdo->commit();
        } catch (\Exception $e) {
            echo"<h1>{$e->getMessage()}</h1>";
            $pdo->rollBack();
        }
    }
    private function upsertVisability($bookId): int
    {
        $visabilitySql = 'SELECT visability from book where id like ? ';
        $pdo = getPDO();
        $stmt=$pdo->prepare($visabilitySql);
        $stmt->execute([$bookId]);
        $visability = (int)$stmt->fetchColumn();
        if ($visability) {
            $sql = 'insert into book (visability) VALUES (0)';
            $stmt = $pdo->prepare($sql);
            $stmt->execute($sql);
        }

        return (int)$pdo->lastInsertId();
    }
    public function getBookByUrl($url): array
    {
        $query = "SELECT book.id, book.title, author.name as authorName, genre.genre_name, genre.genre_id, book.genre_id, book.url,
Comment.message, Comment.book_id, Comment.comment_id, Comment.rating, book.cost, book.visability FROM book 
left join bookstore.author  on book.author_id = author.id
left join bookstore.Comment  on book.id = Comment.book_id 
left join bookstore.genre  using(genre_id)  
where book.url = ?
";
        $pdo = getPDO();
        $result = $pdo->prepare($query);
        $result->execute([$url]);
        $result->setFetchMode(PDO:: FETCH_ASSOC);
        return $result->fetch();
    }
}
