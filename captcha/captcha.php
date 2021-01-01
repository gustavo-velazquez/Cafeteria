<?php

session_start();

function randomText($length){
$pattern="123456789abcdefghijklmnñopqrstuvwxyz";
$max=strlen($pattern)-1;
$key = '';
    for($i=0;$i<$length;$i++){
        $key.=$pattern{rand(0,$max)};

    }
return $key;
}
$_SESSION['txt']=randomText(5);
$captcha=imagecreatefromgif("cap.gif");
$colText=imagecolorallocate($captcha,0,0,250);
imagestring($captcha,5,20,10,$_SESSION['txt'],$colText);

header("Content-type:image/gif");
imagegif($captcha);

?>