<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

 <?php
date_default_timezone_set("Africa/cairo");

$nameday=date("l");
$day=date("d");
$namemonth=date("m");
$year=date("Y"); 

$time = date("h:i");
$t = date("a");
switch ($t)
{
case "am":
$t="ص";
break;	
case "pm":
$t="م";
break;	
}
switch ($nameday)
{
case "Saturday":
$nameday="السبت";
break;
case "Sunday":
$nameday="الأحد";
break;
case "Monday":
$nameday="الاثنين";
break;
case "Tuesday":
$nameday="الثلاثاء";
break;
case "Wednesday":
$nameday="الأربعاء";
break;
case "Thursday":
$nameday="الخميس";
break;
case "Friday":
$nameday="الجمعة";
break;
}
switch ($namemonth)
{
case 1:
$namemonth="يناير";
break;
case 2:
$namemonth="فبراير";
break;
case 3:
$namemonth="مارس";
break;
case 4:
$namemonth="إبريل";
break;
case 5:
$namemonth="مايو";
break;
case 6:
$namemonth="يونيو";
break;
case 7:
$namemonth="يوليو";
break;
case 8:
$namemonth="اغسطس";
break;
case 9:
$namemonth="سبتمبر";
break;
case 10:
$namemonth="اكتوبر";
break;
case 11:
$namemonth="نوفمبر";
break;
case 12:
$namemonth="ديسمبر";
break;
} 
$date= "$nameday ، $day $namemonth $year - $time $t";
$time20= "$time $t";
?>