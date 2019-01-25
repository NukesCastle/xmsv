<?php
/**
 * Created by PhpStorm.
 * User: lenove
 * Date: 29.01.2017
 * Time: 10:52
 */
if(isset($_POST['download'])){
$file = $_POST['download'];
download($file);
}
function download($file){
    header('Content-Disposition: attachment; filename="'.$file.'"');
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Description: File Transfer");
    readfile($file);
}
