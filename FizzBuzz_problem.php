<?php
function solution ($arr){
    $last_val = $arr[count($arr)-1];
    $flag = 1;
    $output = "";
        foreach($arr as $value){
            if(!is_INT($value)){
                $explod = explode(":",$value);
                if ($last_val % $explod[0] == 0) {
                    $output .= $explod[1];
                    $flag = 0;
                }
                } elseif ($flag == 1) {
                    $output .= $value;
            }
        }
    
    echo $output;
}

//$arr = array("3:Fizz","5:Buzz",15);
//$arr = array("3:Tsukemen","5:Mazesoba",29);
$arr = array("3:Sweet","5:Bitter","7:Beauty","11:Song",1150);

solution($arr);

?>
