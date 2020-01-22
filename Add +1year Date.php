<?php
$abc = date("y-m-d");
echo $abc;
echo "<br>";
echo date("Y-m-d H:i:s", strtotime("+1 years", strtotime('2014-05-22')));
echo "<br>";

$oneYearOn = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day"));
echo $oneYearOn;
echo "<br>";

$presentyear = '2016-08-23';
echo "present year is".$presentyear;
echo "<br>";
$nextyear  = date("M d,Y",mktime(0, 0, 0, date("m",strtotime($presentyear )),   date("d",strtotime($presentyear )),   date("Y",strtotime($presentyear ))+1));
echo "<br>";
echo "next year is".$nextyear;
echo "<br>";


echo "Today is " . date("Y/m/d") . "<br>";
$pqr=(date("Y/m/d")+1);
echo $pqr;

echo "<br>";

$oneYearOn = date('Y-m-d',strtotime(date("Y-m-d", mktime()) . " + 365 day"));
echo "<br>";
//Working 1 year Plus date ==== 86400 are the total seconds in a year.
echo $ghk=date("Y-m-d");
echo "<br>";
$mnp=date("Y-m-d", time()+86400*364); 
echo $mnp;


?>