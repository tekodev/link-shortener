<?php
error_reporting(E_ERROR | E_PARSE);

try {
    $db = new PDO("mysql:host=localhost;dbname=shot_link;charset=utf8", "root", "");
} catch ( PDOException $e ){
    print $e->getMessage();
}



$link = $_POST['link'];
if($link == "") {
    die ("Lütfen tüm alanları doldurunuz.");
} else {
    $hash = checkLinkIsRecorded($link,$db);
    if(!is_null($hash)){
        echo "http://localhost:5000/".$hash;
        exit;
    }
    $hash = generateRandomString(5);
    $isUnique = checkHashIsUnique($hash,$db);

    while(!$isUnique){
        $hash = generateRandomString(5);
        $isUnique = checkHashIsUnique($hash,$db);
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
        echo "http://localhost:5000/".$hash;
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
?>