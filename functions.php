<?php
//require 'autoload.php';
require 'vendor/autoload.php';
define('ITEMS_PER_PAGE', 8);
define('PUB_KEY', 'sandbox_i96445077653');
define('PRIVATE_KEY', 'sandbox_th2Vhc533WCmoAWPnlpcblegCT9JWX9UG3tbFUXe');
function getPDO()
{
    $pdo = new PDO("mysql:dbname=bookstore;host=127.0.0.1;charset=utf8mb4", 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    return $pdo;
}

function getBooks(array $ids = []): array
{

    $class = new ProductService();
    return $class->getProductsList($ids);
}

function getBookById($bookId): array
{

    $class = new ProductService();
    return $class->getBookById($bookId);
}

function getGenres(): array
{
    $query = 'select genre_id, genre_name from genre';
    $pdo = getPDO();
    $result = $pdo->query($query);
    return $result->fetchAll(PDO:: FETCH_ASSOC);
}

function getComments($bookId): array
{
    $query = 'select * from Comment WHERE book_id = ?';
    $pdo = getPDO();
    $result = $pdo->prepare($query);
    $result->execute([$bookId]);
    return $result->fetchAll(PDO:: FETCH_ASSOC);
}

//  мишина функция получения рейтинга вызов ее на странице page : getStars($comment['rating'])
//function getStars(int $rating = 3)
//{
//$stars = '';
//for ($i = 1; $i <= 5; $i++)
//    $stars .= ($rating >= $i) ? '&#9733;' : '&#9734;';
//$html="<span class=\"text-warning\">$stars</span>$rating.0 star";
//if ($rating>1){
//    $html .='s';
//}
//return $html;
//}
//function getComments(): array
//{
//    $query = 'select * from Comment ';
//    $pdo = getPDO();
//    $result = $pdo->query($query);
//    return $result->fetchAll(PDO:: FETCH_ASSOC);
//}

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
        $active = $page === $i ? 'active' : '';
        $buttons .= "
<li class=\"page-item $active\"><a class=\"page-link\" href=\"?page=$i\">$i</a></li>";
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

function addToCart($bookId, int $count = 1)
{
//    $cookie =[
//        $bookId =>$count
//        $bookId => count2
//    ]
    $cart = [];
    if (isset($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
    }
    if (!isset($cart[$bookId])) {
        $cart[$bookId] = 0;
    }
    //$cart[$bookId]= $cart[$bookId]+$count;
    $cart[$bookId] += $count;
    setcookie('cart', json_encode($cart), time() + 60 * 60 * 24 * 365);
}

function getItemsCount()
{
    $total = 0;
    if (!empty($_COOKIE['cart'])) {
        $cart = json_decode($_COOKIE['cart'], true);
        //$total = array_sum($cart);
        foreach ($cart as $count) {
            $total += $count;
        }
    }
    return $total;
}

function getCartItems(): array
{
    $books = [];

    if (!empty ($_POST['upt'])) {
        $cart = deleteFromCart();
    } else {
        $cart = json_decode($_COOKIE['cart'] ?? '', true);
    }
    //id => count

    if ($cart) {
        $ids = array_keys($cart);
        $books = getBooks($ids);
        foreach ($books as &$book) {
            $book['count'] = $cart[$book['id']] ?? 0;
        }
    }
    return $books;
}


function deleteFromCart()
{

    $itemId = $_POST['id'];

    if ($cart = json_decode($_COOKIE['cart'], true)) {
        foreach ($cart as $key => $value) {
            if ($key == $itemId) {
                unset($cart[$key]);
                setcookie('cart', json_encode($cart), time() + 60);
            } else {
                setcookie('cart', '', time() + 60);
            }

            return json_decode($_COOKIE['cart'] ?? '', true);
        }
    }
}

// https://habr.com/ru/post/419625/

//    $items = getCartItems();
//    $itemsId = array_column($items,'id');
//
//    foreach ($itemsId as $key=>$value){
//        if ($value == $itemId) {
//            unset($itemsId[$key]);
//        }
//
//    }

/**
 * create order with books
 * @return int
 */
function createOrder(): int
{
    $items = getCartItems();
    $sql = 'INSERT INTO `order` VALUES()';
    $pdo = getPDO();
    $pdo->query($sql);
    $orderId = $pdo->lastInsertId();

    $sql = 'INSERT INTO `order_book` (order_id,book_id,`count`) VALUES (?,?,?)';
    $stmt = $pdo->prepare($sql);
    foreach ($items as $item) {
        $stmt->execute([
            $orderId,
            $item['id'],
            $item['count']
        ]);
    }

    return $orderId;
}

function getOrderTotal(): float

{
    $total = 0.0;
    $items = getCartItems();
    foreach ($items as $item) {
        $total += $item['cost'] * $item['count'];
    }
    return $total;
}

function getData($orderId)
{
    $data = sprintf(
        '{"result_url":"http://localhost:8091/callback.php","public_key":"%s","version":"3","action":"pay","amount":"%.2f","currency":"UAH",
            "description":"test","order_id":"%s"}',
        PUB_KEY,
        getOrderTotal(),
        $orderId
    );
    return base64_encode($data);
}

function getSignature($orderId)
{
    return base64_encode(sha1(PRIVATE_KEY . getData($orderId) . PRIVATE_KEY, true));
}

function updateOrder(string $data)
{
    $paymentData = json_decode(base64_decode($data), true);
    $orderId = $paymentData['order_id'];
    $amount = $paymentData['amount'];
    $status = $paymentData['status'];
    if ($status == 'failure') {
        $status = 'failed';
    }
    $sql = "UPDATE `order` SET `status`= :status, amount= :amount where order_id= :order_id ";
    $pdo = getPDO();
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        'status' => $status,
        'order_id' => $orderId,
        'amount' => $amount
    ]);
    //require_once '/path/to/vendor/autoload.php';
    $mailer = new Mailer();
    $mailer->notifyOrder();
    $mailer->notifyFeedback();
    return [$orderId, $status];
//// Create the Transport
//    $transport = (new Swift_SmtpTransport('smtp.gmail.com', 465,'ssl'))
//        ->setUsername('anastasia.beetroot@gmail.com')
//        ->setPassword('a7n7a7s7t7asiya')
//    ;
//
//// Create the Mailer using your created Transport
//    $mailer = new Swift_Mailer($transport);
//
//// Create a message
//    ob_start();
//    require 'my-email-template.php';
//    $email = ob_get_clean();
//    $message = (new Swift_Message('Wonderful Subject'))
//        ->setFrom(['anastasia.beetroot@gmail.com' => 'Магазин'])
//        ->setTo(['Nactaciya@gmail.com'])
//        ->setBody($email,'text/html')
//    ;
//
//// Send the message
//    $result = $mailer->send($message);

}

function getPaymentStatusMessage()
{
    if (!empty($_SESSION['order_id'])) {
        $sql = "select * from `order` where order_id=?";
        $pdo = getPDO();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['order_id']]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($order['status'] == 'failed') {
            $message = sprintf("Заказ не оплачен.Заказ на сумму %s не оплачен", $order['amount']);
        } else {
            $message = sprintf("Заказ на сумму %s оплачен", $order['amount']);
        }
        $message .= "
            <script>
            $('#exampleModalCenter').modal('show')
            </script>
            ";
        unset($_SESSION['order_id']);
        return $message;
    }

}

function getBookUrl(array $book)// должен быть тип array $book, переделать ордерс
{

    return "/page/{$book['url']}.html";

}

function getBookByUrl($url): array
{
    $class = new ProductService();
    return $class->getBookByUrl($url);
}