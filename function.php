<?php
//common start

function showDate($str,$format = "M d, Y") {
    return date($format,strtotime($str));
}

function short($str,$length = 500) {
    return substr($str,0,$length);
}

function countTotal($arr) {
    return count($arr);
}
//common end