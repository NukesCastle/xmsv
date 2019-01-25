<?php

/**
 * Created by PhpStorm.
 * User: lenove
 * Date: 05.01.2017
 * Time: 10:32
 */
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
set_time_limit(0);

class wrietCsv
{
    function searchArray($array, $search, $productID, $keys = array())
    {
       // print_r($search);
        global $tmpKey;
        global $theValues;
        if($productID !==$tmpKey ){
            $theValues ='';
        }
        $tmpKey = $productID;

        foreach ($array as $key => $value) {
//          /  print_r($key.'<br>');
            if (is_array($value)) {
                $sub = $this->searchArray($value, $search,$productID, array_merge($keys, array($key)));
                if (count($sub)) {
                 return $sub;

                }
            } elseif ($value=== $search) {
               // print_r('/////////////////////////////////////////////////////////////////////match');
              // $theValues .= $value;
                return array_merge($keys, array($key));
            }
        }
       return array();
//        return $theValues;
    }

    function decodeKeys($pathsToSearch)
    {
        $decodedArr = array();
        foreach ($pathsToSearch as $key => $pathToItem) {
            $varitem = unserialize(base64_decode($pathToItem));
            $decodedArr[$key] = $varitem;
        }
        return $decodedArr;
    }

    function findProducts($array, $product, $keys = array())
    {
        global $return;
        global $toCsv;
        foreach ($array as $key => $value) {
            if ($key === $product) {

                foreach ($value as $key2 => $productItems) {
                    print_r($key2 . '-----------------------------Start -----------------------------<br>');
                     //return $productItems;
                    $toCsv[] = $productItems;
                   // return array_merge($keys, array($key));
                    print_r('-----------------------------End -----------------------------<br>');
                }
                // return array_merge($keys, array($key));
            } elseif (is_array($value)) {
                $sub = $this->findProducts($value, $product, array_merge($keys, array($key)));
                if (count($sub)) {
                    return $sub;
                }
            }
        }
        $return[0]=$keys;
        $return[1]=$toCsv;
    return $toCsv;
    }
    function creatUnicArray($array){

        static $tmpAr = [];
        $tmpAttribute = "";
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                //  print_r($key);
                //    print_r('<br>');
                //      echo "<pre>";
                //   print_r($value);
                //      echo "</pre>";

                if ($key !== '@attributes' && !in_array($key, $tmpAr)) {

                    $tmpAr[] = $key;
                }
                $this->creatUnicArray($value);

            }
//            }else{
////                print_r($key.'<br>');
//                if($key !== '@attributes' && !in_array($key,$tmpAr)){
////                    $tmpAr[]=$key;
//                }
//
//            }
        }

        return $tmpAr;
    }
        function getSize($array){
          static  $tmpSize = [];

            foreach ($array as $index => $item) {

                if (is_array($item)) {

                    if ($index === '@attributes'){

                        $tmpSize[$item['id']] = $item['name'];
                    }
                    $this->getSize($item);

                }

            }
            return $tmpSize;
        }
        function creatNewRow($productList,$path,$arrayForSplit)
        {
//print_r(count($arrayForSplit));
//            foreach ($productList as $key => $item1) {
//                $dummyArray = array_fill(0, 84, '');
//                echo "<pre>";
//
//                echo "</pre>";
//                $tmpItem = '';
//                $tmpDontAdd = '';
//                $ext = new ArrayObjectExt($item1);
//                foreach ($path as $index => $item) {
//                    echo "item <br>";
//                    print_r($item);
//                    echo 'item <br>';
//                    if ($tmpItem == '' || $item != $tmpItem) {
//                        $imInProduct = '';
//                    } else {
//                        $imInProduct = ',';
//                    }
////        print_r($index.'<br>');
//                    // print_r($item1);
//
//                    $d = $ext->getPathValue($index);
////        print_r($d.'<br>');
////        print_r($d);
//
//                    $tmpDontAdd = $d;
//                    $tmpItem = $item;
//
//                    if ($d) {
//                        $dummyArray[0] = "default";
//                        $dummyArray[1] = "base";
//                        $dummyArray[2] = "default";
//                        $dummyArray[3] = "simpel";
//                        $dummyArray[6] = "0";
//                        $dummyArray[15] = "rwd/default";
//                        $dummyArray[17] = "Artikelinformationsspalte";
//                        $dummyArray[21] = "Polen";
//                        $dummyArray[22] = "Konfiguration verwenden";
//                        $dummyArray[23] = "Konfiguration verwenden";
//                        $dummyArray[29] = "Katalog, Suche";
//                        //  if($item == 45){
//                        //  $dummyArray[$item] .= "ss" . $d;
//                        // $dummyArray[$item] .= $imInProduct . $d;
//                        // }elseif($tmpItem != 45){
//                        if ($item != 45) {
//                            //  $dummyArray[45] = "1000";
//                        }
//
//                        $dummyArray[46] = "1";
//                        $dummyArray[47] = "1";
//                        $dummyArray[48] = "0";
//                        $dummyArray[49] = "0";
//                        $dummyArray[50] = "1";
//                        $dummyArray[51] = "1";
//                        $dummyArray[52] = "1";
//                        $dummyArray[53] = "1000";
//                        $dummyArray[54] = "1";
//                        $dummyArray[55] = "1";
//                        $dummyArray[56] = "1";
//                        $dummyArray[57] = "1";
//                        $dummyArray[58] = "1";
//                        $dummyArray[59] = "1";
//                        $dummyArray[60] = "0";
//                        $dummyArray[61] = "0";
//                        $dummyArray[62] = "1";
//                        $dummyArray[63] = "0";
//                        $dummyArray[64] = "1";
//                        $dummyArray[65] = "0";
//                        $dummyArray[67] = "1";
//                        $dummyArray[68] = "simple";
//                        $dummyArray[80] = "0";
//                        $dummyArray[81] = "0";
//
//
//                        //  print_r($d);
//                        if (is_array($d)) {
//                            //     print_r($d);
//                        }
//                        $dummyArray[$item] .= $imInProduct . $d;
//
//
//                    }
//
//                }
//            }
        }
}