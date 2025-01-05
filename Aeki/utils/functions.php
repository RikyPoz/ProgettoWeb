<?php
function isActive($pagename){
    if(basename($_SERVER['PHP_SELF'])==$pagename){
        echo " class='active' ";
    }
}

function getIdFromName($name){
    return preg_replace("/[^a-z]/", '', strtolower($name));
}


function getStars($rating) {
    $output = "";
    $fullStars = floor($rating);
    $halfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = 5 - $fullStars - $halfStar;

    for ($i = 0; $i < $fullStars; $i++) {
        $output .= '<i class="bi bi-star-fill text-warning"></i>';
    }

    if ($halfStar) {
        $output .= '<i class="bi bi-star-half text-warning"></i>';
    }

    for ($i = 0; $i < $emptyStars; $i++) {
        $output .= '<i class="bi bi-star text-warning"></i>';
    }
    return $output;
}
?>