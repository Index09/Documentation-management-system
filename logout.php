<body style="background-image: -webkit-gradient(linear, 50.00% 0.00%, 50.00% 100.00%, color-stop( 2.59% , rgba(211,191,255,1.00)),color-stop( 48.70% , rgba(255,255,255,1.00)),color-stop( 94.82% , rgba(214,196,255,1.00)));
	background-image: -webkit-linear-gradient(270deg,rgba(211,191,255,1.00) 2.59%,rgba(255,255,255,1.00) 48.70%,rgba(214,196,255,1.00) 94.82%);
	background-image: linear-gradient(180deg,rgba(211,191,255,1.00) 2.59%,rgba(255,255,255,1.00) 48.70%,rgba(214,196,255,1.00) 94.82%);">
<meta charset="utf-8">
<br/> <br/> <br/> <br/> <br/> <br/>
<?php
session_start();

echo '<meta charset="utf-8"><center><br/><br/><br/><br/><br/><br/>
<h2> GOOD BYE <span style="color:red;">'.$_SESSION['Fullname'].'</span><br />
      سيتم تحويلك بعد 5 ثواني</h2>';
echo "<META HTTP-EQUIV='Refresh' Content='.5;URL=index.php'>";
session_destroy();
?>
