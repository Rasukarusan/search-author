<?php
require_once './Function.php';
$request = json_decode(file_get_contents('php://input'), true);
$titles = $request['titles'];
if(empty($titles)) exit;

$result = [];
foreach ($titles as $title) {
    if(empty($title)) continue;
    $curl_result = fetch($title);
    $json = json_decode($curl_result);
    $authors = getAuthors($json);
    $result[] = [
        'title' => $title,
        'authors' => $authors
    ];
}
echo json_encode($result);

return;

/**
 * curlでGETリクエストを実行
 */
function fetch(string $title) : string {
    $ch = curl_init();
    $endpoint = 'https://www.googleapis.com/books/v1/volumes?q=';
    $options = [
        CURLOPT_URL => $endpoint.$title,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_CUSTOMREQUEST => 'GET',
    ];
    curl_setopt_array($ch, $options);
    $resp = curl_exec($ch);
    curl_close($ch);
    return $resp;
}

/**
 * 著者を取得
 * 著者が複数人いる場合はカンマ区切りで取得する
 * 
 * @return string 取得できない場合空文字を返す
 */
function getAuthors($json) : string {
    if(is_null($json->items[0]->volumeInfo->authors)) {
        return '取得できませんでした';
    }
    $authors = $json->items[0]->volumeInfo->authors;
    return implode(',', $authors);
}
