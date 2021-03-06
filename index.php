<?php

include 'database.php';


$hash = explode('/', $_SERVER['REQUEST_URI'])[1];
if($hash){
    $controller = $db->query("SELECT link FROM link WHERE hash = '$hash'")->fetch(PDO::FETCH_OBJ);

    if($controller){
        $link = $controller->link;
        if (strpos($link, "http") !== 0 && strpos($link, "https") !== 0) {
            $link = 'http://' . $link;
        }

        header("Location: " . $link);
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
    
    <div class="divim">
    <h2>
    Link Shortener
    </h2>
        

        <!--<input type="text"name="link" id="link" required placeholder="Link Giriniz." />-->
        <div class="form">
            <input type="text" name="link" id="link" autocomplete="off" required />
                <label for="text" class="label-name">
                    <span class="content-name">
                        Your Link
                    </span>
                </label>
        </div>
		<!--<button type="submit" id="linkver">Link'i Kısalt</button>-->
        <button id="linkver" type="submit" >
            <p id="btnText">Shortent</p>
            <div class="check-box">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 50 50">
                    <path fill="transparent" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
                </svg>
            </div>
        </button>
        <label for="area"><h3>Shortened Link</h3></label>
    <input class="textarea" type="textarea" name="area" id="area"/>
    <footer><p style="margin-top:85px">© 2022 Designed by tækodev.</p></footer>
    </div>
    
    


    
        


   
    <script type="text/javascript">
        const btn = document.querySelector("#linkver");
        const btnText = document.querySelector("#btnText");

        btn.onclick = () => {
            btnText.innerHTML = "Done";
            btn.classList.add("active");
        };
    </script>
</body>
</html>
