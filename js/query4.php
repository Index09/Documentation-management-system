<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] == 'Admin' or $_SESSION['Role'] == 'User')
	{
?>
	<div class="formtit"> المحرارت الخاصة بكل حرف
	</div>

	<form action="index.php?url=query4" method="post" class="ser1" dir="rtl">
		<center> 
		<div class="box">
			<label id="lab"> نوع المحرر </label>
			<select name="doctyp" required>
				<option value="">اختر</option>
				<option value="1">محررات رسمية موثقة</option>
				<option value="2">محاضر التصديق على التوقيعات</option>
				<option value="3">محررات عرفية</option>
			</select>
			<label>الحرف</label>
			<select name="doclet" required>
				<option value="">اختر</option>
				<option value="أ">أ</option>
				<option value="ب">ب</option>
				<option value="ج">ج</option>
				<option value="د">د</option>
				<option value="هـ">هـ</option>
				<option value="و">و</option>
				<option value="ز" >ز</option>
				<option value="ح" >ح</option>
				<option value="ط" >ط</option>
				<option value="ك" >ك</option>
				<option value="ل" >ل</option>
				<option value="م" >م</option>
				<option value="-">-</option>
			</select>
			<label>فى الفترة من</label>
			<input name="start" type="date" required />
			<label>إلى</label>
			<input name="end" type="date" required />
			<input type="submit" name="query" value="استعلام"/>
		</div>
	</form>
<?php
	$url = $_SERVER["REQUEST_URI"];
	if (isset($_POST['query']))
		{
		$doctyp = $_POST['doctyp'];
		if ($doctyp != "")
			{
			$_SESSION['doctyp'] = $doctyp;
			}
		$doclet = $_POST['doclet'];
		if ($doclet != "")
			{
			$_SESSION['doclet'] = $doclet;
			}
		$start = $_POST['start'];
		if ($start != "")
			{
			$_SESSION['start'] = $start;
			}
		$end = $_POST['end'];
		if ($end != "")
			{
			$_SESSION['end'] = $end;
			}
	/* elseif ($url === "/index.php?url=query4" or $url === "/index.php?url=query4/")
		{
		unset($_SESSION["doctyp"]);
		}
	*/
		$stmt = $has->prepare("select * from documentation where date between ? and ? and doctyp=? and doclet=?");
		$stmt->bind_param('ssss', $_SESSION['start'], $_SESSION['end'], $_SESSION['doctyp'], $_SESSION['doclet']);
		$stmt->execute();
		$result=$stmt->get_result();
		$total = $result->num_rows;
		$_SESSION['total'] = $total;
		$stmt->close();
		}
	$topics = 30;
	$pages = $_SESSION['total'] / $topics;
	$y = ceil($pages);
	if	($_SESSION['total'] > 0)
		{
		echo '<br/><br/><label class="reptit">تقرير المحررات الخاصة بحرف | '.$_SESSION['doclet'].' | فى الفترة من '.$_SESSION['start'].' إلى  '.$_SESSION['end'].' بمكتب توثيق '.$office.' </label>';
		if (isset($_GET["show"]))
			{
			$j = $_GET["number"];
			$h = $j - 1;
			$l = $h * $topics;
			$k = $j * $topics;
			echo '<table class="tab" >';
				echo '<tr>';
					 echo '<td class="td">التاريخ</td>';
					 if ($_SESSION['doctyp'] == 1)
						{
						echo '<td class="td">محررات رسمية موثقة</td>'; 	
						}
					elseif ($_SESSION['doctyp'] == 2)
						{
						echo '<td class="td">محاضر التصديق والتوقيعات</td>'; 	
						}
					else
						{
						echo '<td class="td">محررات عرفية</td>'; 	
						}
				echo '</tr>';
				$stmt = $has->prepare("select * from documentation where date between ? and ? and doctyp=? and doclet=? order by docnum asc LIMIT $l, $topics");
				$stmt->bind_param('ssss', $_SESSION['start'], $_SESSION['end'], $_SESSION['doctyp'], $_SESSION['doclet']);
				$stmt->execute();
				$fetch=$stmt->get_result();
				while($item=$fetch->fetch_array())
					{
					$docnum = $item['docnum'];
					$date = $item['date'];
					echo '<tr>';
						 echo '<td class="td">'.$date.'</td>';
						 echo '<td class="td">'.$docnum.'</td>'; 	
					echo '</tr>';
					}
			echo '</table>';
			}
		else
			{
			$j = 1;
			$h = $j - 1;
			$l = $h * $topics;
			$k = $j * $topics;
			echo '<table class="tab" >';
				echo '<tr>';
					 echo '<td class="td">التاريخ</td>';
					 if ($_SESSION['doctyp'] == 1)
						{
						echo '<td class="td">محررات رسمية موثقة</td>'; 	
						}
					elseif ($_SESSION['doctyp'] == 2)
						{
						echo '<td class="td">محاضر التصديق على التوقيعات</td>'; 	
						}
					else
						{
						echo '<td class="td">محررات عرفية</td>'; 	
						}
				echo '</tr>';
				$stmt = $has->prepare("select * from documentation where date between ? and ? and doctyp=? and doclet=? order by docnum asc LIMIT $l, $topics");
				$stmt->bind_param('ssss', $_SESSION['start'], $_SESSION['end'], $_SESSION['doctyp'], $_SESSION['doclet']);
				$stmt->execute();
				$fetch=$stmt->get_result();
				while($item=$fetch->fetch_array())
					{
					$docnum = $item['docnum'];
					$date = $item['date'];
					echo '<tr>';
						 echo '<td class="td">'.$date.'</td>';
						 echo '<td class="td">'.$docnum.'</td>'; 	
					echo '</tr>';
					}
			echo '</table>';
			}
		$next = $j + 1;
		$prev = $j - 1;
		$x = $j+4;
		$z = $y - 4;
		$c = $y / 2;
		$p = $j - 2;
		$n = $p + 4;
			
		echo '<div class="page-button">';
			echo '<div class="page">';
			if ($prev == 0)
				{
				echo '<span>السابق</span>';
				}
			else
				{
				echo '<a href="index.php?url=query4&number='.$prev.'&show=enter" alt="previous" title="Previous">السابق</a>';
				}
			echo '</div>';
			
			echo '<div class="page">';
			if ($j > 4 and $j <= $z)
				{
				if (1 == $j)
					{
					echo '<span class="pagination"> 1 </span>';
					}
				else
					{
					echo '<a href="index.php?url=query4&number=1&show=enter" title="1" alt="1">';
						echo '<span> 1 </span>';
					echo '</a>';
					}
				echo '<span class="dots"> ... </span>';
				}
			if ($j < 5)
				{
				for ($i = 1; $i <= 5; $i++)
					{
					if ($i == $j)
						{
						echo '<span class="pagination"> '.$i.' </span>';
						}
					else
						{
						echo '<a href="index.php?url=query4&number='.$i.'&show=enter" title="'.$i.'" alt="'.$i.'">';
							echo '<span>'.$i.' </span>';
						echo '</a>';
						}
					}
				}
			elseif ($j > $z)
				{
					echo '<a href="index.php?url=query4&number=1&show=enter" title="1" alt="1">';
						echo '<span> 1 </span>';
					echo '</a>';
				}
			elseif ($j > $c and $j<= $z)
				{
				for ($i = $p; $i <= $n; $i++)
					{
					if ($i == $j)
						{
						echo '<span class="pagination"> '.$i.' </span>';
						}
					else
						{
						echo '<a href="index.php?url=query4&number='.$i.'&show=enter" title="'.$i.'" alt="'.$i.'">';
							echo '<span>'.$i.' </span>';
						echo '</a>';
						}
					}
				}
			else
				{
				for ($i = $j; $i <= $x; $i++)
					{
					if ($i == $j)
						{
						echo '<span class="pagination"> '.$i.' </span>';
						}
					else
						{
						echo '<a href="index.php?url=query4&number='.$i.'&show=enter" title="'.$i.'" alt="'.$i.'">';
							echo '<span>'.$i.' </span>';
						echo '</a>';
						}
					}
				}
			if ($y > 5)
				{
				echo '<span class="dots"> ... </span>';
				if ($j > $z)
					{
					for ($i = $z; $i <= $y; $i++)
						{
						if ($i == $j)
							{
							echo '<span class="pagination"> '.$i.' </span>';
							}
						else
							{
							echo '<a href="index.php?url=query4&number='.$i.'&show=enter" title="'.$i.'" alt="'.$i.'">';
								echo '<span>'.$i.' </span>';
							echo '</a>';
							}
						}
					}
				else
					{
					echo '<a href="index.php?url=query4&number='.$y.'&show=enter" title="'.$y.'" alt="'.$y.'">';
						echo '<span>'.$y.' </span>';
					echo '</a>';
					}
				}	
			echo '</div>';
			
			echo '<div class="page">';
			if ($next > $y)
				{
				echo '<span>التالى</span>';
				}
			else
				{
				echo '<a href="index.php?url=query4&number='.$next.'&show=enter" alt="next" title="Next"> التالى</a>';
				}
			echo '</div>';
			
		echo '<div style="clear:both"></div>';
		echo '</div>';
		}
	else
		{
		echo '<h4 dir="rtl" style="margin-right:20px; color:red">لا توجد أى بيانات</h4>';
		}
		
	}
else
	{
	header("Location:error.php"); die();
	}
?>