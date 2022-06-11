<?php
error_reporting(E_ERROR | E_PARSE);

include 'database.php';
$link = $_POST['link'];
if($link == "") {
    die ("Lütfen tüm alanları doldurunuz.");
} else {
    $hash = checkLinkIsRecorded($link, $db);
    if(!is_null($hash)){
        echo getUrlWithBaseUrl($hash);
        exit;
    }

    $hash = generateRandomString(5);
    $isUnique = checkHashIsUnique($hash, $db);
    while(!$isUnique){
        $hash = generateRandomString(5);
        $isUnique = checkHashIsUnique($hash, $db);
    }

    $query = $db->prepare("INSERT INTO link SET
    link = ?,
    hash = ?
    ");

    $insert = $query->execute(array(
        $link,$hash,
    ));

    if ( $insert ){
        $last_id = $db->lastInsertId();
        echo getUrlWithBaseUrl($hash);
    } else {
        echo "Teknik Hata";
    }
}
function checkLinkIsRecorded($link,$db){
    $controller = $db->query("SELECT * FROM link WHERE link = '$link'")->fetch(PDO::FETCH_OBJ);

    return ($controller->id > 0) ? $controller->hash : null; 
}

function checkHashIsUnique($hash,$db){
    $controller = $db->query("SELECT id FROM link WHERE hash = '$hash'")->fetch(PDO::FETCH_OBJ);

    //return !$controller->id > 0;  en kısa if else (true,false için geçerli!)
    return ($controller->id > 0) ? false : true; 
}

function generateRandomString($length = 25) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function getUrlWithBaseUrl($hash) {
    return getenv('BASE_URL') . "/" . $hash;
}
?>