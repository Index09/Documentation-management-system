<?php
$has = new mysqli("localhost", "root", "123", "markbatzaq");
// Check connection
if (mysqli_connect_errno())
	{
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
	}
	$has->query("SET CHARACTER SET utf8");

?>