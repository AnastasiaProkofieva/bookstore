#!/usr/bin/env php
<?php
// получить все книги которые есть
// транслитерировать название книги
// апдейт в базе
require '../functions.php';
//echo transliterator_transliterate('Russian-Latin/BGN', 'Привет медвед').PHP_EOL;
//exit();
$pdo = getPDO();

$sql= 'SELECT * FROM book ';
$stmt = $pdo->query($sql);
$books= $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql= 'UPDATE book set url = ? where id =?';
$stmt= $pdo->prepare($sql);
foreach ($books as $book){
    $url= transliterator_transliterate('Russian-Latin/BGN', $book['title']);
    //запись с нижний регистр, trim удаляет пробелы сначала и с конца строки
    $url=trim(strtolower($url));
    $url= str_replace(
        [' ', ',', 'ʹ', '--','—', '!','.' ],
        ['_'],
        $url
    );
    $stmt->execute([
        $url,
        $book['id']
    ]);
}
