<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php

$today = date("Y-m-d");
$preday= date("Y-m-d",strtotime('-6 days'));

$day1 = date("l jS \of F Y",strtotime($preday));
$day2 = date("l jS \of F Y",strtotime($preday."+1 day"));
$day3 = date("l jS \of F Y",strtotime($preday."+2 day"));
$day4 = date("l jS \of F Y",strtotime($preday."+3 day"));
$day5 = date("l jS \of F Y",strtotime($preday."+4 day"));
$day6 = date("l jS \of F Y",strtotime($preday."+5 day"));
$day7 = date("l jS \of F Y",strtotime($preday."+6 day"));

$day11 = date("l",strtotime($preday));
$day22 = date("l",strtotime($preday."+1 day"));
$day33 = date("l",strtotime($preday."+2 day"));
$day44 = date("l",strtotime($preday."+3 day"));
$day55 = date("l",strtotime($preday."+4 day"));
$day66 = date("l",strtotime($preday."+5 day"));
$day77 = date("l",strtotime($preday."+6 day"));

echo $today; echo "<br/>";
echo $preday;echo "<br/>";
echo $day1;echo "<br/>";
echo $day2;echo "<br/>";
echo $day3;echo "<br/>";
echo $day4;echo "<br/>";
echo $day5;echo "<br/>";
echo $day6;echo "<br/>";
echo $day7;echo "<br/>";echo "<br/>";echo "<br/>";

echo $day11;echo "<br/>";
echo $day22;echo "<br/>";
echo $day33;echo "<br/>";
echo $day44;echo "<br/>";
echo $day55;echo "<br/>";
echo $day66;echo "<br/>";
echo $day77;echo "<br/>";echo "<br/>";echo "<br/>";



$preday1= date("Y-m-d",strtotime($preday."0 day"));
echo $preday1;echo "<br/>";
?>
</body>
</html>