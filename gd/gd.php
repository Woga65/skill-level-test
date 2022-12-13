<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GD library example</title>
    <style>
        .main { height: 100vh; width: 100vw; background-color: grey; color: black; }
    </style>    
</head>
<body class="main" tabindex=0 >

<?php

    $width = isset($_GET['width']) ? $_GET['width'] : 300;
    $height = isset($_GET['height']) ? $_GET['height'] : 300;
    $fieldWidth = isset($_GET['fieldWidth']) ? $_GET['fieldWidth'] : 100;

    function show($im) {
        ob_start();
        imagejpeg($im, NULL, 100);
        $rawImageBytes = ob_get_clean();
        echo "<img src='data:image/jpeg;base64," . base64_encode( $rawImageBytes ) . "' />";
    }
    
    $im = imagecreatetruecolor($width, $height);
    $white = imagecolorallocate($im, 255, 255, 255);
    
    for ($i = 0; $i < intdiv($height, $fieldWidth) + 1; $i++) {
        for ($j = ($i % 2) ? 1 : 0; $j < intdiv($width, $fieldWidth) + 1; $j+=2) {
            imagefilledrectangle($im, $j * $fieldWidth, $i * $fieldWidth, ($j * $fieldWidth) + $fieldWidth - 1, ($i * $fieldWidth) + $fieldWidth - 1, $white);
        }
    }
    
    show($im);
    imagedestroy($im);
            
?>

</body>
</html>
