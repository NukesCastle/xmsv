<!DOCTYPE html>
<html>
<head>
    <title>Page Title</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
<?php
/**
 * Created by PhpStorm.
 * User: lenove
 * Date: 31.01.2017
 * Time: 12:12
 */

session_start();
include "wrietCsv.php";
$writeCsv = new wrietCsv();
$dir = getcwd(). '/temp/';
echo '<h1>'.basename($_SESSION['files']).'</h1>';
if (isset($_POST['files'])) {
    $file = $dir . $_POST['files'][0];
    $_SESSION['files'] = $file;
    $toArray = simplexml_load_file($file, 'SimpleXMLElement', LIBXML_NOCDATA);

}elseif(isset($_POST['url'])){
$url = $_POST['url'];
    $_SESSION['file'] = $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);    // get the url contents
    $data = curl_exec($ch); // execute curl request
    curl_close($ch);
    $xml = simplexml_load_string($data, 'SimpleXMLElement', LIBXML_NOCDATA);


    $toArray = $xml;

}


$json = json_encode($toArray);
$elementsArray = json_decode($json, TRUE);
$forSelect = $writeCsv->creatUnicArray($elementsArray);
echo "<pre>";
//print_r($elementsArray);
//echo "<h1> ---- ".array_key_exists('variantSizes',$elementsArray) ."----- </h1>";
//if(array_key_exists('variantSizes',$elementsArray)){
//
//    $size = $elementsArray['variantSizes'];
//    $_SESSION['sizes'] = $writeCsv->getSize($size);
//
//}

echo "</pre>";

?>
<form id="product" method="post" action="choosMagento.php">
    <label>Wybierz lement ktory jest produktem</label><br>
    <select name="product" style="    left: 12%;
    float: left;">
        <option value=""></option>
        <?php
        $countEl = 0;;
        $testTmp = '';

        foreach ($forSelect as $key3 => $value3):
            if ($countEl == 0) {
                $since = "";
            } elseif ($countEl == count($forSelect)) {
                $since = "";
            } else {

                $since = ",";
            }

            $testTmp .= $since . $value3;

            echo '<option value = "' . $testTmp . '">' . $value3 . '</option>'; //close your tags!!

            $countEl++;
        endforeach;

        $_SESSION['elementsArray'] = $elementsArray;
        ?>
    </select>
    <input type="submit" value="GO">
</form>
</div>
</body>
</html>