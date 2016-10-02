<?php
include 'clsUtility.php';

$hours=00;
$minutes=08;
echo  date("H"); echo "<br/>";
echo date("i"); echo "<br/>";
echo $totalHours = date("H") + $hours; echo "<br/>";
echo $totalMinutes = date("i") + $minutes; echo "<br/>";
echo $timeStamp = mktime($totalHours, $totalMinutes); echo "<br/>";
echo $myTime = date("H:i A", $timeStamp); echo "<br/>";echo "<br/>";

$test=strtotime("00:08");
echo  date("H",$test); echo "<br/>";
echo date("i",$test); echo "<br/>";

echo base64_encode("Pass@123");
 $dbObj=new clsUtility();
echo $dbObj->checkEnvironment();

phpinfo();
?>