<?php
/**
 * Created by PhpStorm.
 * User: roofoos
 * Date: 31.10.2016
 * Time: 15:15
 */
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
session_start();

require __DIR__ . '/UploadProgress.php';

$uploadProgress = new UploadProgress();

header('Content-type: text/json');
echo json_encode([
    'progress' => $uploadProgress->progress('123')
]);
$target_dir = getcwd(). '/temp/';
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image

if(isset($_POST["submit"])) {

    if($imageFileType === 'xml') {
//        echo "Plik jest XML - ";
        $uploadOk = 1;

    } else {
//        echo "Plik nie jest XML.";
        $uploadOk = 0;

    }
}
// Check if file already exists


//die();

$phpFileUploadErrors = array(
    0 => 'There is no error, the file uploaded with success',
    1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini',
    2 => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form',
    3 => 'The uploaded file was only partially uploaded',
    4 => 'No file was uploaded',
    6 => 'Missing a temporary folder',
    7 => 'Failed to write file to disk.',
    8 => 'A PHP extension stopped the file upload.',
);


// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {

    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
//        print_r($target_file);

//        sleep(5);
        goback();
      //  loadXml($target_file);
    } else {

       // echo "Sorry, there was an error uploading your file.<br>";
        print_r($phpFileUploadErrors[$_FILES["fileToUpload"]["error"]]);
    }
}
print_r(ini_get("session.upload_progress.name"));

function goback (){
  // print_r(sleep(3));
    header( "refresh:3;url=index.php" );
    exit;
}
//