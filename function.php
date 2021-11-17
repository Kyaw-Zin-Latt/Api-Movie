<?php
//common start
function dateCompare($element1, $element2) {
    $datetime1 = strtotime($element1);
    $datetime2 = strtotime($element2);
    return $datetime1 - $datetime2;
}

function dateCompareTV($element1, $element2) {
    $datetime1 = strtotime($element1->first_air_date);
    $datetime2 = strtotime($element2->first_air_date);
    return $datetime1 - $datetime2;
}

function showDate($str,$format = "M d, Y") {
    return date($format,strtotime($str));
}

function short($str,$length = 500) {
    return substr(html_entity_decode(htmlentities($str,ENT_QUOTES)),0,$length);
}

function textFilter($str) {
    return html_entity_decode(htmlentities($str,ENT_QUOTES));
}

function countTotal($arr) {
    return count($arr);
}

function numberFormat($num) {
    return number_format((($num)*10));
}

function minToHour($minutes) {
    return floor($minutes / 60).'h : '.($minutes -   floor($minutes / 60) * 60). 'min';
}

function showAge($birthday) {
    $birthDate = $birthday;

    $currentDate = date("Y-m-d");

    $age = date_diff(date_create($birthDate), date_create($currentDate));

    return $age->format("%y");
}

//common end