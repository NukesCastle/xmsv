<?php
session_start();
/**
 * Created by PhpStorm.
 * User: lenove
 * Date: 18.01.2017
 * Time: 19:44
 */
echo '<style>
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 5px;
}
</style>';
//include "workXml.php";
include "ArrayObjectExt.php";
include "wrietCsv.php";
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);

$dontAdd ='';
$oxyd = basename($_SESSION['files']);
//$arraySizes = $_SESSION['sizes'];
if (isset($_POST['file'])) {
    $csvFileName = $_POST['file'];
    $finalCsvName = basename($csvFileName, ".xml") . '-' . date('Hismdy');
}
if(isset($_POST['dismisVal'])){
$dontAdd = $_POST['dismisVal'];
}
$productList = unserialize(base64_decode($_POST['productList']));
$testValue = $_POST['test'];
$magentoElem = array("store", "websites", "attribute_set", "type", "category_ids", "sku", "has_options", "name", "meta_title", "meta_description", "image", "small_image", "thumbnail", "url_key", "url_path", "custom_design", "page_layout", "options_container", "image_label", "small_image_label", "thumbnail_label", "country_of_manufacture", "msrp_enabled", "msrp_display_actual_price_type", "gift_message_available", "manufacturer", "color", "status", "is_recurring", "visibility", "tax_class_id", "price", "special_price", "weight", "msrp", "description", "short_description", "meta_keyword", "custom_layout_update", "special_from_date", "special_to_date", "news_from_date", "news_to_date", "custom_design_from", "custom_design_to", "qty", "min_qty", "use_config_min_qty", "is_qty_decimal", "backorders", "use_config_backorders", "min_sale_qty", "use_config_min_sale_qty", "max_sale_qty", "use_config_max_sale_qty", "is_in_stock", "notify_stock_qty", "use_config_notify_stock_qty", "manage_stock", "use_config_manage_stock", "stock_status_changed_auto", "use_config_qty_increments", "qty_increments", "use_config_enable_qty_inc", "enable_qty_increments", "is_decimal_divided", "product_name", "store_id", "poroduct_type_id", "product_status_changed", "product_status_websites", "option_size_title", "option_size_type", "option_size_isreq", "option_size_values", "option_color_title", "option_color_type", "option_color_isreq", "option_color_values", "base_image","stock_status_changed_automatically","use_config_enable_qty_increments","size","stil","idcode");
$count = 0;
$imInProduct = '';
$csvArray = [];
$csvArray[0] = $magentoElem;
$wrietCsv = new wrietCsv();


foreach ($productList as $key => $item1) {
    $dummyArray = array_fill(0, 84, '');
    $tmpItem = '';
    $tmpDontAdd ='';
    $ext = new ArrayObjectExt($item1);
    foreach ($testValue as $index => $item) {
//        echo "item <br>";
//        print_r($item);
//        echo 'item <br>';
        if ($tmpItem == '' || $item != $tmpItem) {
            $imInProduct = '';
        } else {
            $imInProduct = ',';
        }
//        print_r($index.'<br>');
      // print_r($item1);

        $d = $ext->getPathValue($index);
//        print_r($d.'<br>');
//        print_r($d);

        $tmpDontAdd = $d;
        $tmpItem = $item;
       if ($d) {
            $dummyArray[0] = "default";
            $dummyArray[1] = "base";
            $dummyArray[2] = "default";
            $dummyArray[3] = "simpel";
            $dummyArray[6] = "0";
            $dummyArray[15] = "rwd/default";
            $dummyArray[17] = "Artikelinformationsspalte";
            $dummyArray[21] = "Polen";
            $dummyArray[22] = "Konfiguration verwenden";
            $dummyArray[23] = "Konfiguration verwenden";
            $dummyArray[29] = "Katalog, Suche";
          //  if($item == 45){
              //  $dummyArray[$item] .= "ss" . $d;
              // $dummyArray[$item] .= $imInProduct . $d;
           // }elseif($tmpItem != 45){
            if($item != 45){
             //  $dummyArray[45] = "1000";
            }

            $dummyArray[46] = "1";
            $dummyArray[47] = "1";
            $dummyArray[48] = "0";
            $dummyArray[49] = "0";
            $dummyArray[50] = "1";
            $dummyArray[51] = "1";
            $dummyArray[52] = "1";
            $dummyArray[53] = "1000";
            $dummyArray[54] = "1";
            $dummyArray[55] = "1";
            $dummyArray[56] = "1";
            $dummyArray[57] = "1";
            $dummyArray[58] = "1";
            $dummyArray[59] = "1";
            $dummyArray[60] = "0";
            $dummyArray[61] = "0";
            $dummyArray[62] = "1";
            $dummyArray[63] = "0";
            $dummyArray[64] = "1";
            $dummyArray[65] = "0";
            $dummyArray[67] = "1";
            $dummyArray[68] = "simple";
            $dummyArray[80] = "0";
            $dummyArray[81] = "0";
          

              //  print_r($d);
            if(is_array($d)){
           //     print_r($d);
            }
            $dummyArray[$item] .= $imInProduct . $d;






        }else if(is_array($d)){
            $wrietCsv->creatNewRow($productList,$testValue,$d);
        }

    }
if($tmpDontAdd != $dontAdd || !isset($dontAdd) || empty($dontAdd)){
    $csvArray[$key + 1] = $dummyArray;
}
}
$stream = fopen($finalCsvName . '.csv', 'w+');
echo '<table style="width:100%">';
foreach ($csvArray as $key1 => $val) {
    fputcsv($stream, $val);
    echo '<tr>';
    echo '<td>'.$key1.'</td>';
    foreach ($val as $i => $iem) {


      echo '<td>'.$iem.'</td>';
    }
    echo '</tr>';

}
echo '</table>';
rewind($stream);

fclose($stream);

if(file_exists($finalCsvName.'.csv')){
echo '<form id="download" action="download.php" method="post">
<input name="download" type="hidden" value="'.$finalCsvName.'.csv">
</form>';
}
?>
<?php
   // if (isset($_POST['download'])) {?>

        <script type="text/javascript">
//            document.getElementById('download').submit(); // SUBMIT FORM
        </script>

        <?php
  //  }
  //  else
   // {
        // leave the page alone
    //}
//[0] => store
//[1] => websites
//[2] => attribute_set
//[3] => type
//[4] => category_ids
//[5] => sku
//[6] => has_options
//[7] => name
//[8] => meta_title
//[9] => meta_description
//[10] => image
//[11] => small_image
//[12] => thumbnail
//[13] => url_key
//[14] => url_path
//[15] => custom_design
//[16] => page_layout
//[17] => options_container
//[18] => image_label
//[19] => small_image_label
//[20] => thumbnail_label
//[21] => country_of_manufacture
//[22] => msrp_enabled
//[23] => msrp_display_actual_price_type
//[24] => gift_message_available
//[25] => manufacturer
//[26] => color
//[27] => status
//[28] => is_recurring
//[29] => visibility
//[30] => tax_class_id
//[31] => price
//[32] => special_price
//[33] => weight
//[34] => msrp
//[35] => description
//[36] => short_description
//[37] => meta_keyword
//[38] => custom_layout_update
//[39] => special_from_date
//[40] => special_to_date
//[41] => news_from_date
//[42] => news_to_date
//[43] => custom_design_from
//[44] => custom_design_to
//[45] => qty
//[46] => min_qty
//[47] => use_config_min_qty
//[48] => is_qty_decimal
//[49] => backorders
//[50] => use_config_backorders
//[51] => min_sale_qty
//[52] => use_config_min_sale_qty
//[53] => max_sale_qty
//[54] => use_config_max_sale_qty
//[55] => is_in_stock
//[56] => notify_stock_qty
//[57] => use_config_notify_stock_qty
//[58] => manage_stock
//[59] => use_config_manage_stock
//[60] => stock_status_changed_auto
//[61] => use_config_qty_increments
//[62] => qty_increments
//[63] => use_config_enable_qty_inc
//[64] => enable_qty_increments
//[65] => is_decimal_divided
//[66] => product_name
//[67] => store_id
//[68] => poroduct_type_id
//[69] => product_status_changed
//[70] => product_status_websites
//[71] => option_size_title
//[72] => option_size_type
//[73] => option_size_isreq
//[74] => option_size_values
//[75] => option_color_title
//[76] => option_color_type
//[77] => option_color_isreq
//[78] => option_color_values
//[79] => base_image
//[80] => stock_status_changed_automatically
//[81] => use_config_enable_qty_increments
//[82] => size
//[83] => stil
?>