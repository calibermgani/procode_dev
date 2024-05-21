<?php
if(strcmp($_SERVER['HTTP_HOST'],'35.208.83.145') == 0){
    return [
         'PRO_CODE_URL' => 'https://aims.officeos.in',
    ];
} else {
    return [
         'PRO_CODE_URL' => 'http://dev.aims.officeos.in',
    ];
    
}
