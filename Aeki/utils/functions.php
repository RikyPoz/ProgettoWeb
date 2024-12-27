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
    return str_repeat('&#9733;', $rating) . str_repeat('&#9734;', 5 - $rating);
}

?>