<?php
function overlap($start1, $end1, $start2, $end2) {
    return (strtotime($start1) < strtotime($end2)) && (strtotime($start2) < strtotime($end1));
}

function generate_ref($length = 8) {
    $chars = 'ABCDEFGHJKMNPQRSTUVWXYZ23456789';
    $ref = '';
    for ($i = 0; $i < $length; $i++) $ref .= $chars[random_int(0, strlen($chars)-1)];
    return $ref;
}
?>