<?php


if(!function_exists('p')){
    
function p($data = null) {
     
            echo '<pre>';
            print_r($data ?? request()->all());
            echo '</pre>';
        }
 
}



