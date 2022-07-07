<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] == 'Admin' or $_SESSION['Role'] == 'User')
	{
?>
	<div class="formtit"> الفـهــرس
	</div>

	<form action="index.php?url=query5" method="post" class="ser1" dir="rtl">
		<center> 
		<div class="box">
			<label id="lab"> نوع المحرر </label>
			<select name="doctyp" required>
				<option value="">اختر</option>
				<option value="1">محررات رسمية موثقة</option>
				<option value="2">محاضر التصديق على التوقيعات</option>
				<option value="3">محررات عرفية</option>
			</select>
			<label>فى الفترة من</label>
			<input name="start" type="date" required />
			<label>إلى</label>
			<input name="end" type="date" required />
			<input type="submit" name="query" value="استعلام"/>
		</div>
	</form>
<?php
	if (isset($_POST['query']))
		{
		$doctyp = $_POST['doctyp'];
		$start = $_POST['start'];
		$end = $_POST['end'];
		$stmt = $has->prepare("SELECT documentation.doclet, members.docnum, documentation.date, members.member, documentation.repet
								FROM documentation INNER JOIN members 
								ON documentation.mrand=members.mrand and documentation.docnum=members.docnum 
								where documentation.doctyp=? and date  between ? and ? order by member asc") or die ('mysql_error');
		("select * from documentation where date between ? and ? and doctyp=? and doclet=?");
		$stmt->bind_param('sss', $doctyp, $start, $end);
		$stmt->execute();
		$result=$stmt->get_result();
		$total = $result->num_rows;
		if	($total > 0)
			{
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
			echo '<br/><br/><label class="reptit">فهرس المحررات الخاصة | '.$doctyp1.' | فى الفترة من '.$start.' إلى  '.$end.' بمكتب توثيق '.$office.' </label>';
			echo '<table class="tab" >';
				echo '<tr>';
					 echo '<td class="td">الاسم</td>';
					 echo '<td class="td">الرقم</td>';
					 echo '<td class="td">الحرف</td>';
					 echo '<td class="td">التاريخ</td>';
				echo '</tr>';
				while($item=$result->fetch_array())
					{
					$date = $item['date'];
					$member = $item['member'];
					$docnum = $item['docnum'];
					$doclet = $item['doclet'];
					$repet = $item['repet'];
					echo '<tr>';
						echo '<td class="td">'.$member.'</td>';
						echo '<td class="td">'.$docnum;						
						if ($repet == 'on')
							{
							echo ' مكرر';
							}
						echo '</td>';
						echo '<td class="td">'.$doclet.'</td>'; 	
						echo '<td class="td">'.$date.'</td>';
					echo '</tr>';
					}
			echo '</table>';
						echo $total;
			}
		else
			{
			echo '<h4 dir="rtl" style="margin-right:20px; color:red">لا توجد أى بيانات</h4>';
			}
		}
	}
else
	{
	header("Location:error.php"); die();
	}
?>