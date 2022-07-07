<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] == 'Admin' or $_SESSION['Role'] == 'User')
	{
?>

<div class="formtit"> الصور غير الاصلية
</div>

<form action="" method="post" class="ser1" dir="rtl">
	<center> 
	<div >
        <label #lab>مكتب</label>
        <?php
		echo '<select name="office" required>';
			echo '<option value="">اختر</option>';
			$offices2 = $has->query("select * from offices");
			while ($office2 = $offices2->fetch_array())
				{
				$office3 = $office2['office'];
				$mrand = $office2['mrand'];
				echo '<option value="'.$mrand.'">'.$office3.'</option>';
				}
		echo '</select>';
		?>
        <input type="submit" name="query" value="استعلام"/>
	</div>
</form>
        
        
		<?php
		if (isset($_POST['query']))
			{
			$office = $_POST['office'];
			$stmt = $has->prepare("select distinct mrand from articlesimg where office=? and docchk='reed'");
			$stmt->bind_param('i', $office);
			$stmt->execute();
			$result=$stmt->get_result();
			$total = $result->num_rows;
			if	($total > 0)
				{
				while ($office12 = $result->fetch_array())
					{
					$mrand = $office12['mrand'];
					$root = $has->query ("select * from documentation where mrand=$mrand");
					$rootd = $root->fetch_array();
					$doctyp = $rootd['doctyp'];
					$doclet = $rootd['doclet'];
					$docnum = $rootd['docnum'];
					$date = $rootd['date'];
					switch ($doctyp)
						{
						case "1":
						$doctyp1="محررات رسمية موثقة";
						break;
						case "2":
						$doctyp1="محاضر التصديق على التوقيعات";
						break;
						case "3":
						$doctyp1="محررات عرفية";
						break;
						}
					echo '<a href="index.php?url=reportd&report='.$mrand.'" target="_blank">محرر رقم '.$docnum.' '.$doctyp1.' حرف '.$doclet.' بتاريخ '.$date.'</a><br />';
					}
				}
			else
				{
				echo '<h4 dir="rtl" style="margin-right:20px; color:red">لا توجد أى بيانات</h4>';
				}
			}
		?>
     </center>
<?php
	}
else
	{
	header("Location:error.php"); die();
	}
?>