<?php

try {
    $db = new PDO("mysql:host=localhost;dbname=shot_link;charset=utf8", "root", "");
} catch ( PDOException $e ){
    print $e->getMessage();
}


$hash = explode('/', $_SERVER['REQUEST_URI'])[1];
if($hash){
    $controller = $db->query("SELECT link FROM link WHERE hash = '$hash'")->fetch(PDO::FETCH_OBJ);

    if($controller){
        $yon = $controller->link;
        header("Location: http://".$yon);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js?v=9999"></script>
    <script src="app.js" defer></script>
    <title>Link Shortener</title>
</head>
<body>
    
    <div>
        <h2>
            Link Kısaltıcı
        </h2>

        <input type="text"name="link" id="link" required placeholder="Link Giriniz." />
		<button type="submit" id="linkver">Link'i Kısalt</button>

    </div>
    <br>
    <label for="area"><h4>Kısaltılmış Linkiniz</h4></label>
    <input type="textarea" name="area" id="area"/>

</body>
</html>
