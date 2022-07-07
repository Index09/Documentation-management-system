<body>
<?php
if ($_SESSION['Role'] === 'Admin' or $_SESSION['Role'] == 'Admin1')
	{
	$id = $_POST['nid'];
	$stmt = $has->prepare("select office, id from offices where id=?");
	$stmt->bind_param('i', $id );
	$stmt->execute();
	$stmt->bind_result($office, $tid);
	$stmt->fetch();
	$stmt->close();
	echo '<td><input type="text" name="office1" value="'.$office.'" class="input_field input_field3" /></td>';
	echo '<td><input type="hidden" name="id1" value="'.$tid.'" /></td>';
	echo '<td><input type="submit" name="apply" class="submt4" value="تعديل" /></td>';
	echo '<td><input type="submit" class="submt4" value="تراجع" /></td>';
	}
else 
	{
	header("Location:error.php"); die();
	}

?>
<body/>