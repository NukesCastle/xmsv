<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<?php
include "wrietCsv.php";
include "ArrayObjectExt.php";
ini_set('display_errors', 1);
error_reporting(E_ALL | E_STRICT);
session_start();
echo '<h1>'.basename($_SESSION['files']).'</h1>';
echo '<pre>';
$writeCsv = new wrietCsv();
$elementsArray = $_SESSION['elementsArray'];


print_r($_POST['product']);
if (isset($_POST['product'])) {
    $path = explode(",", $_POST['product']);
//print_r($_POST['product']);
    if (isset($path[3])) {

        bob($elementsArray[$path[0]][$path[1]][$path[2]][$path[3]]);
    } elseif (isset($path[2])) {

        bob($elementsArray[$path[0]][$path[1]][$path[2]]);
    } elseif (isset($path[1])) {

        bob($elementsArray[$path[0]][$path[1]]);
    } elseif (isset($path[0])) {

        bob($elementsArray[$path[0]]);
    }

}


echo '<pre>';
echo '<style>select{
right: 114px;
position: absolute;
}

</style>';

function selectDisable()
{
    $html = '<div style="width: 700px; height: 30px;"><br><label style="padding-right: 10px;" >Wartosc produktu pomijanego</label><input type="text" name="dismisVal" >';
    $html .= '</div>';
    return $html;
}

function bob($rrr)
{

    $testRoom = [];
    $arrlength = count($rrr);

    $zerowyProduct = $rrr[0];
    for ($x = 0; $x < $arrlength; $x++) {
        $y = $x +1 ;

        if (!isset($testRoom[0])) {
            if ($y < $arrlength) {
                $testRoom[0] = array_replace_recursive($zerowyProduct, $rrr[$y]);
            }
        } else {
            if ($y < $arrlength) {
                $testRoom[0] = array_replace_recursive($testRoom[0], $rrr[$y]);
            }
        }
    }
    renderTrea($testRoom, $rrr);
}

$ss = 0;
function creatSelects($magentoElem, $index = null, $key = null, $key1 = null, $key2 = null, $key3 = null, $key4 = null, $key5 = null)
{
    global $ss;
    $theSelects = "";

    if (isset($key5)) {
        $theSelects = '<select type="select" id="'.$ss.'" name="test' . "[/$key/$key1/$key2/$key3/$key4/$key5]" . '"><option value="">  </option>';
    } elseif (isset($key4)) {
        $theSelects = '<select type="select" id="'.$ss.'" name="test' . "[/$key/$key1/$key2/$key3/$key4]" . '"><option value="">  </option>';
    } elseif (isset($key3)) {
        $theSelects = '<select type="select" id="'.$ss.'" name="test' . "[/$key/$key1/$key2/$key3/]" . '"><option value="">  </option>';
    } elseif (isset($key2)) {
        $theSelects = '<select type="select"  id="'.$ss.'"name="test' . "[/$key/$key1/$key2/]" . '"><option value="">  </option>';
    } elseif (isset($key1)) {
        $theSelects = '<select type="select" id="'.$ss.'" name="test' . "[/$key/$key1/]" . '"><option value="">  </option>';
    } elseif (isset($key)) {
        $theSelects = '<select type="select" id="'.$ss.'" name="test' . "[/$key/]" . '"><option value="">  </option>';
    } elseif (isset($index)) {
        $theSelects = '<select type="select" id="'.$ss.'" name="test' . "[]" . '"><option value="">  </option>';
    }
    $ss++;
    foreach ($magentoElem as $key1 => $value1) {

        $theSelects .= '<option name="option" value="' . $key1 . '">' . $value1 . '</option>';
    }

    $theSelects .= '</select>';

    return $theSelects;
}

function checkifArray($value)
{
    if (!is_array($value) && $value !== '@attributes') {
        return $value;
    } else {
        return '';
    }
}

function checkIfattribute($value)
{
    if ($value !== '@attributes') {
        return $value;
    } else {
        return ' Atrybuty ';
    }
}

function renderTrea($arrTrea, $theProducts)
{

    $magentoElem = array("store", "websites", "attribute_set", "type", "category_ids", "sku", "has_options", "name", "meta_title", "meta_description", "image", "small_image", "thumbnail", "url_key", "url_path", "custom_design", "page_layout", "options_container", "image_label", "small_image_label", "thumbnail_label", "country_of_manufacture", "msrp_enabled", "msrp_display_actual_price_type", "gift_message_available", "manufacturer", "color", "status", "is_recurring", "visibility", "tax_class_id", "price", "special_price", "weight", "msrp", "description", "short_description", "meta_keyword", "custom_layout_update", "special_from_date", "special_to_date", "news_from_date", "news_to_date", "custom_design_from", "custom_design_to", "qty", "min_qty", "use_config_min_qty", "is_qty_decimal", "backorders", "use_config_backorders", "min_sale_qty", "use_config_min_sale_qty", "max_sale_qty", "use_config_max_sale_qty", "is_in_stock", "notify_stock_qty", "use_config_notify_stock_qty", "manage_stock", "use_config_manage_stock", "stock_status_changed_auto", "use_config_qty_increments", "qty_increments", "use_config_enable_qty_inc", "enable_qty_increments", "is_decimal_divided", "product_name", "store_id", "poroduct_type_id", "product_status_changed", "product_status_websites", "option_size_title", "option_size_type", "option_size_isreq", "option_size_values", "option_color_title", "option_color_type", "option_color_isreq", "option_color_values", "base_image", "stock_status_changed_automatically", "use_config_enable_qty_increments", "size", "stil","idcode");

    $html = '<form id="trea" method="post" action="write.php" enctype="multipart/form-data">';
    $html .= '<input name="productList" value="' . base64_encode(serialize($theProducts)) . '" type="hidden">';
    $html .= selectDisable();
    $html .= '<br>';
    $html .= '<ul>';
//print_r($arrTrea);
    foreach ($arrTrea as $indexkk => $item) {

        $html .= '<li>'
//            . ' <input type="checkbox" id="' . $indexkk . '"/> '
            . '  <span class="val">'
            . checkIfattribute($indexkk)
            . '  </span>'
            . checkifArray($item)

            . creatSelects($magentoElem, $indexkk)
            . '</li>';
        $html .= '<ul>';
        if (is_array($item)) {
            foreach ($item as $key0 => $i) {

                $html .= '<li>'
//                    . '<input type="checkbox"  id="' . checkIfattribute($key0) . '"/> '
                    . '  <span class="val">'
                    . checkIfattribute($key0)
                    . '  </span>'
                    . checkifArray($i)

                    . creatSelects($magentoElem, $indexkk, $key0)
                    . '</li>';

                if (is_array($i)) {
                    $html .= '<ul>';
                    foreach ($i as $key1 => $i1) {
                        $html .= '<li> '
//                            . '<input type="checkbox"id="' . checkIfattribute($key1) . '"/>'
                            . '  <span class="val">'
                            . checkIfattribute($key1) .' '. count($i1);
                            if(count($i1)>1){
                            $html.=' <input style="margin-left: 100px;" type="checkbox" name="multip" value="">';
}
                            $html.= '  </span>'
                            . checkifArray($i1)

                            . creatSelects($magentoElem, $indexkk, $key0, $key1)
                            . '</li>';
                        if (is_array($i1)) {
                            $html .= '<ul>';
                            foreach ($i1 as $key2 => $i2) {
                                if(checkIfattribute($i2) == ' Atrybuty '){
                                   // $key2 == '';
                                }
                                $html .= '<li>'
//                                    . '<input type="checkbox"/>'
                                    . '  <span class="val">'
                                    . checkIfattribute($key2)
                                    . '  </span>'
                                    . checkifArray($i2)

                                    . creatSelects($magentoElem, $indexkk, $key0, $key1, $key2)

                                    . '</li>';
                                if (is_array($i2)) {
                                    $html .= '<ul>';
                                    foreach ($i2 as $key3 => $i3) {
                                        if (is_array($i3)) {
                                            $html .= '<ul>';
                                            foreach ($i3 as $key4 => $i4) {
                                                $html .= '<li>'
//                                                    . '<input type="checkbox"/>'
                                                    . '  <span class="val">'
                                                    . checkIfattribute($key4)
                                                    . '  </span>'
                                                    . checkifArray($i4)

                                                    . creatSelects($magentoElem, $indexkk, $key0, $key1, $key2, $key3, $key4)


                                                    . '</li>';

                                                // print_r($key3 . ' ' .$i3);
                                            }
                                            $html .= '</ul>';
                                        } else {
                                            $html .= '<li>'
//                                                . '<input type="checkbox"/>'
                                                . '  <span class="val">'
                                                . checkIfattribute($key3)
                                                . '  </span>'
                                                . checkifArray($i3);
                                            if(!isset($key3)){
                                               $key4 = null;
                                            }

                                            $html  .=  creatSelects($magentoElem, $indexkk, $key0, $key1, $key2, $key3);
                                           // print_r('aa '.$indexkk.' '.$key0.' '. $key1.' '. $key2.' '.$key3.' '. $key4.'<br>');
                                            $html  .= '</li>';

                                            // print_r($key3 . ' ' .$i3);
                                        }
                                    }
                                    $html .= '</ul>';
                                } else {

                                    if(checkIfattribute($i2) == ' Atrybuty '){
                                $key2 == '';
                                    }
                                    $html .= '<ul>'
                                        . '<li>'
//                                        . '<input type="checkbox"/>'
                                        . ' '

                                        . creatSelects($magentoElem, $indexkk, $key0, $key1, $key2)

                                        . '</li>'
                                        . '</ul>';
                                }
                            }
                            $html .= '</ul>';
                        }
                    }
                    $html .= '</ul>';
                }
            }

        } else {
            //  print_r('----- ' . $item);
        }
        $html .= '</ul>';
    }
    $html .= '</ul>';
    $html .= '<input name="file" type="hidden" value="' . $_SESSION['files'] . '">';
    $html .= '<input id="submit" type="submit" value="submit" ></form>';
    echo '</pre>';
    echo $html;
}

$optionAr = array();
$jj = 0;
function createSelect($option)
{
    // print_r($option);
    global $jj;
    global $optionAr;
    if (is_null($optionAr)) {
        $optionAr[0] = $option;
    }
    foreach ($optionAr as $key => $optItem) {
        if (in_array($option, $optionAr)) {
        } else {
            if (!empty($option) && $option !== null && isset($option)) {
                $optionAr[0] = $option;
            } else {
            }
        }
    }

    $jj++;
    //print_r($optionAr);
    return $optionAr;
}

echo '<pre>';
//print_r($optionAr2);
echo '</pre>';
?>

<style>
    #submit {
        width: 100px;
        height: 30px;

        text-align: center;
        background: whiteSmoke;
        font-weight: bold;
        color: white;
        background-color: #df0019;
        text-decoration: none;
        position: fixed;
        bottom: 75px;
        right: 40px;
    }

    .val {
        font-weight: bold;
    }

</style>
<script>
    $(document).ready(function () {

        $("li").mouseover(function () {
            $(this).css("background-color", "FF0700");
        });
        $("li").mouseout(function () {
            $(this).css("background-color", "white");
        });
        $("li").click(function(){
            $(this).children("select");
            var selectName = $(this).children("select").attr('id');
            console.log($(this).children("select").attr('id'));


            $( "#"+selectName ).simulate('mousedown');
//            $( "input[name="+selectName+"]" ).trigger('mousedown');
        });
        $(window).scroll(function () {
            if ($(this).scrollTop() > 10) {
                $('#submit').fadeIn();
            } else {
                $('#submit').fadeOut();
            }
        });
        if ($("#trea").length) {

            $("#product").hide();

        }
    });

    $(function () {
        $('form').submit(function () {
            $('select').each(function () {
                if ($(this).val() == '') {
                    $(this).attr('disabled', 'disabled');
                }
            })

        })
    })

</script>
