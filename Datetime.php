<?php
date_default_timezone_set('Asia/Calcutta');


$TodaysDate = date('Ymd');
echo $TodaysDate;
echo "<br>";



$CurrentTime = date('H:i:s');
echo $CurrentTime;
echo "<br>";



$SpanTime = date('H:i:s', strtotime('15 minute'));
echo $SpanTime."<br>";


$t=time();
echo($t . "<br>");


?>