<?php require_once("setting.fya"); ?>
<?php require_once 'incFirewall.fya'; ?>
<?php
date_default_timezone_set('Asia/Tokyo');  // you are required to set a timezone

$date1 = new DateTime('2009-08-12');
$date2 = new DateTime('2009-04-12');

$diff = $date1->diff($date2);

echo (($diff->format('%y') * 12) + $diff->format('%m')) . " full months difference";
?>