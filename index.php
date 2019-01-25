<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
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

    <title>Titel</title>
</head>
<body>
<div class="container">
    <div class="progress hide">
        <div class="progress-bar progress-bar-striped active"><span></span></div>
    </div>
<form action="upload.php" method="post" enctype="multipart/form-data" target="hidden_iframe" id="upload">
    Wybierz plik z twojego komputera:
    <input type="hidden" name="UPLOAD_PROGRESS" value="123" />
    <input type="file" name="fileToUpload" id="fileToUpload" >

    <input type="submit" value="Upload File" name="submit" class="btn btn-primary">

</form>
<form action="choosProduct.php" method="post" enctype="multipart/form-data">
    Podaj link do pliku xml:
    <input type="url" name="url" id="fileToUpload">

    <input type="submit" value="Get form url" name="submitUrl" class="btn btn-primary"/>

</form>


<?php
if (!file_exists(getcwd() . '/temp')) {
    mkdir(getcwd() . '/temp', 0744);
}
/**
 * Created by PhpStorm.
 * User: roofoos
 * Date: 16.10.2016
 * Time: 17:58
 */
//session_destroy();
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
$url = 'http://www.ifc.pl/xml/ifc_fp.xml';

$dir = getcwd() . '/temp';
//$dir = '/var/www/html/tmp';
if (!isset($_POST['submit'])) {
    if ($dp = opendir($dir)) {
        $files = array();
        while (($file = readdir($dp)) !== false) {
            if (!is_dir($dir . $file)) {
                $files[] = $file;
            }
        }
        closedir($dp);
    } else {
        exit('Directory not opened.');
    }
    if ($files) {
        echo '<form action="choosProduct.php" method="post">';
        foreach ($files as $file) {
            if ($file === ".." || $file === ".") {

            } else {
                $_SESSION['file'] = $file;
                echo '<input type="radio" name="files[]" value="' . $file . '" /> ' .

                    $file . '<br />';
            }
        }

        echo '<br><input type="submit" name="submit" value="submit" class="btn btn-primary" />' .
            '</form> ';
    } else {
        exit('No files found.');
    }
} else {
    if (isset($_POST['files'])) {
        foreach ($_POST['files'] as $value) {
            echo $dir . $value . '<br />';
        }
    } else {
        exit('No files selected');
    }
}
if(isset($_POST['del'])){

}
?>
</div>
<script>
    var $progressBar = $('.progress-bar');
    $('#upload').on('submit', function () {
        $progressBar.parent().removeClass('hide');
        alert("test");
        setTimeout(updateProgress, 1000);
    });
    function updateProgress() {
        $.get('UploadProgress.php', function (data) {
            var progress = data.progress;
            $progressBar.css('width', progress + '%');
            $progressBar.find('span').html(progress + '%');
            if (progress < 100) {
                setTimeout(updateProgress, 100);
            }
        });
    }
</script>
</body>
</html>