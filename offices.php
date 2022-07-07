<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] === 'Admin')
	{
	if (isset($_POST['add']))
		{
		$office = $_POST['office'];
		$mrand = $_POST['mrand'];
		$path = 'd:/image/'.$mrand;
		if (! is_dir($path))
			{
			mkdir($path);		/*creating a folder (dir)*/
			$stmt = $has->prepare("insert into offices set office=?, mrand=?");
			$stmt->bind_param('si', $office, $mrand );
			$stmt->execute();
			$stmt->close();
			}
		}
			$n= $year1.mt_rand (100000,999999).date("m");

?>
	<h2 class="title">قائمة المكاتب اليدوية على مستوى الجمهورية</h2>
	<form action="" method="post" dir="rtl">
		<label>اسم المكتب :</label><input type="text" name="office" class="input_field input_field3" required />
		<input type="text" name="mrand" class="input_field input_field3" required />
		<input type="submit" name="add" value="اضف" class="submt4" />
	</form>
	<table dir="rtl">
		<tr>
			<th>اسم المكتب</th>
			<th>الرقم الكودى</th>
			<th>تعديل</th>
			<th>حذف</th>
		</tr>
<?php
	if (isset($_POST['apply']))
		{
		$id90 = $_POST['id1'];
		$office1 = $_POST['office1'];
		$stmt = $has->prepare("update offices set office=? where id=?");
		$stmt->bind_param('si', $office1, $id90 );
		$stmt->execute();
		$stmt->close();
		}
	if (isset($_POST['delete']))
		{
		$id90 = $_POST['nid'];
		$mrand44 = $_POST['mrand33'];
		$stmt = $has->prepare("select * FROM articlesimg WHERE office=?");
		$stmt->bind_param('i', $mrand44 );
		$stmt->execute();
		$images3 = $stmt->get_result();
		while ($imgname3 = $images3->fetch_array())
			{
			$name3 = $imgname3['img1'];
			unlink('imgs/'.$mrand44.'/'.$name3);
			}
		$path = "imgs/".$mrand44;
		rmdir($path);							/*Deleting the empty folder itself*/
		$stmt->close();
		$stmt = $has->prepare("select mrand FROM offices WHERE mrand=?");
		$stmt->bind_param('i', $mrand44 );
		$stmt->execute();
		$stmt->bind_result($office3);
		$stmt->fetch();
		$stmt->close();
		$has->query("delete from articlesimg where office='$office3'") or die ('mysql_error');
		$has->query("delete from members where office='$office3'") or die ('mysql_error');
		$has->query("delete from documentation where office='$office3'") or die ('mysql_error');
		$has->query("delete from users where office='$office3'") or die ('mysql_error');
		$has->query("delete from offices where mrand='$office3'") or die ('mysql_error');
		}
	$etypes = $has->query("select * from offices") or die ('mysql_errno');
	while ($etype = $etypes->fetch_array())
		{
		$nid = $etype['id'];
		$reoffice = $etype['office'];
		$remrand = $etype['mrand'];
		echo '<form action="index.php?url=offices" method="post">';
		echo '<tr>';
		if (isset($_POST['edit'.$nid]))
			{
			require 'editoffice.php';
			}
		else
			{
			echo '<td>'.$reoffice.'</td>';
			echo '<td>'.$remrand.'</td>';
			echo '<input type="hidden" name="mrand33" value="'.$remrand.'" />';
			echo '<input type="hidden" name="nid" value="'.$nid.'" />';
			echo '<td><input type="submit" name="edit'.$nid.'" class="submt4" value="تعديل" /></td>';
			?>
			<td><input type="submit" name="delete" class="submt4" value="حذف" onclick="return confirm('هل انت متأكد من حذف هذا المكتب؟ كل الملفات والمحررات الخاصة به ستحذف معه');" /></td>
			<?php
			}
		echo '</tr>';
		echo '</form>';
		}
?>	
	</table>
<?php
	}
else
	{
	header("Location:error.php"); die();
	}
?>