<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] === 'Admin' or $_SESSION['Role'] === 'User')
	{
	if (isset($_POST["add"]))
		{
		$docnum = $_POST['docnum'];
		$mrand = $_POST['mrand'];
		$myFile = $_FILES['img'];
		$sname = $_SESSION['office'];
		$docchk = 'read';
        $fileCount = count($myFile["name"]);
		for ($i = 0; $i < $fileCount; $i++) 
			{
			$filename = $_FILES['img'] ['name'][$i];
			$filesource = $_FILES['img'] ['tmp_name'][$i];
			$filetype = $_FILES['img'] ['type'][$i];
			$filesize = $_FILES['img'] ['size'][$i];
		
			$filename = preg_replace("#[^a-z0-9.]#i","", $filename);
					
			if (!$filesource) 
				{
				die("No image has been selected, Please go back & try again");
				}
			else 
				{
				if ($filename)									
					{
					if ($filetype === "image/jpeg" or $filetype === "image/tiff" or $filetype === "image/png")
						{
						if ($filesize < 250075)
							{
							move_uploaded_file ($filesource, "d:/image/$sname/$filename");		
							$stmt = $has->prepare("INSERT INTO articlesimg SET docnum=?, mrand=?, docchk=?, img1=?, office=?, imgsize=?, writer=?, time=?");
							$stmt->bind_param('sississs', $docnum, $mrand, $docchk, $filename, $_SESSION['office'], $filesize, $_SESSION['Fullname'], $date);
							$stmt->execute();
							$stmt->close();
							}
						else
							{
							echo '<center><h2>Ooooops..The picture you have uploaded is bigger than 250 kbs. Please try again with another picture with a maximum size of 250kbs!</h2></center>';	
							}		
						}
					else  
						{
						echo '<center><h2>Ooooops..Please make sure the file you have uploaded is a picture of extentions(jpeg , tiff , png) and nothing else!</h2></center>';
						}	
					}
				}
			}
		}
	
	if (isset($_GET['imgid'])) 
		{
		$imgid = $_GET['imgid'];
		$report_id = $_GET['report'];
		$stmt = $has->prepare("SELECT * FROM articlesimg WHERE id=?");
		$stmt->bind_param('i', $imgid);
		$stmt->execute();
		$del= $stmt->get_result();
		$count = $del->num_rows;
		$data = $del->fetch_array();
		$img = $data['img1'];
		$office = $data['office'];
		$id = $data['id'];
		
		$check = $has->query("SELECT * FROM articlesimg WHERE img1='$img'") or die ('mysql_error');
		$count1 = $check->num_rows;
		if ($count1 == 1)
			{
			unlink('imgs/'.$office.'/'.$img);
			}

		$has->query("DELETE FROM articlesimg WHERE id='$id'");
		header("Location:index.php?url=reportd&report=".$report_id);
		}
	
	
	
	if (isset($_GET['report']))
		{
		$report = $_GET['report'];
		$stmt = $has->prepare("select * from documentation where mrand=?");
		$stmt->bind_param('i', $report);
		$stmt->execute();
		$retrieve = $stmt->get_result();
		$rettail = $retrieve->fetch_array();
		$doctyp = $rettail['doctyp'];
		$writer = $rettail['writer'];
		$time1 = $rettail['time'];
		switch ($doctyp)
			{
			case "1":
			$doctyp1="محررات رسمية موثقة";
			break;
			case "2":
			$doctyp1="محاضر التصديق والتوقيعات";
			break;
			case "3":
			$doctyp1="محررات عرفية";
			break;
			}
		$docnum = $rettail['docnum'];
		$doclet = $rettail['doclet'];
		$date22 = $rettail['date'];
		$mrand = $rettail['mrand'];
		$repet = $rettail['repet'];
		echo '<div id="scncon">';
			echo '<div id="headcon">المسح الضوئى</div>';
			echo '<div id="kindname">';
				echo '<div id="kind">';
					echo '<p>نوع المحرر : '.$doctyp1.'</p>';
					echo '<p>رقم المحرر : '.$docnum;
					if ($repet == 'on')
						{
						echo ' مكرر';
						}
					echo '</p>';
					echo '<p>الحرف : '.$doclet.'</p>';
					echo '<p>تاريخ الاصدار : '.$date22.'</p>';
				echo '</div>';
				echo '<div id="nme">';
				$i=0;
				$retrieve1 = $has->query("select * from members where mrand='$mrand'") or die('mysql_error');
				while ($rettail1 = $retrieve1->fetch_array())
					{
					$member = $rettail1['member'];
					$arrt = $rettail1['arrt'];
					$i++;
					switch ($arrt)
						{
						case "1":
						$arrt1="طرف أول";
						break;
						case "2":
						$arrt1="طرف ثان";
						break;
						}
					echo $i.' - '.$member.' ('.$arrt1.')<br />';
					}
				echo '</div>';
			echo '</div>';
	  
			echo '<form action="" method="post" enctype="multipart/form-data" " style="display: inline-block">';
				echo '<input type="hidden" name="mrand" value="' . $mrand . '" />';
				echo '<input type="hidden" name="docnum" value="'.$docnum.'" />';
				echo '<input type="file" name="img[]" multiple required />';
				echo '<input type="submit" name="add" value="اضف صور المحررات" />';
			echo '</form>';
			if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] === 'User')
				{
				echo '<a href="index.php?url=cnr" target="" class="" style="display: inline-block;
    margin-right: 8vw;
    padding: 1vw 2vw;
    color: white;
    background: darkblue;
    border-radius: 2vw;" >إضافة محرر جديد</a>';
				}
			echo '<div id="img">';
			$show = $has->query("SELECT * FROM articlesimg WHERE mrand='$mrand'");
			while ($data = $show->fetch_array())
				{
				$imgid = $data['id'];
				$img1 = $data['img1'];
				$imgsize1 = $data['imgsize'];
				$actsize = filesize("d:/image/".$_SESSION['office']."/".$img1);
				$wrtier = $data['writer'];
				$time2 = $data['time'];
				echo '<div class="imgthum">';
					if ($imgsize1 == $actsize)
						{
						echo '<a target="_blank" href="http://localhost/files/'.$_SESSION['office'].'/'.$img1.'">';
							echo '<img src="http://localhost/files/'.$_SESSION['office'].'/'.$img1.'" title="أضيف هذا المحرر بواسطة '.$wrtier.' بتاريخ '.$time2.'" />';
						echo '</a>';
						}
					else
						{
						echo '<a target="_blank" href="http://localhost/files/'.$_SESSION['office'].'/'.$img1.'">';
							echo '<img src="http://localhost/files/'.$_SESSION['office'].'/'.$img1.'" title="أضيف هذا المحرر بواسطة '.$wrtier.' بتاريخ '.$time2.'" />';
						echo '</a>';
						$has->query("update articlesimg set docchk='reed' where id='$imgid'");
						}
					if ($_SESSION['Role'] === 'Admin1')
						{
						$chk = $has->query("select docchk from articlesimg where id='$imgid'");
						$chk1 = $chk->fetch_array();
						$dochck = $chk1['docchk'];
						if ($dochck == 'reed')
							{
							echo '<i class="fa fa-exclamation-triangle" aria-hidden="true" title="هذا المحرر قد يوجد به خطأ. مساحة هذا المحرر لدينا '.$imgsize1.' بايت"></i>';
							}
						?>
						<a href="index.php?url=reportd&report=<?php echo $mrand; ?>&imgid=<?php echo $imgid; ?>" class="imgdel" onclick="return confirm('هل انت متأكد من حذف هذا المحرر؟');" >حذف</a>
						<?php
						}
				echo '</div>';
				}
			echo '<div style="clear:both"></div>';
			echo '</div>';
		echo '</div>';
		echo '<div class="createby">';
			echo '<span>بواسطة '.$writer.' بتاريخ '.$time1.'</span>';
		echo '</div>';
		}
	}
else 
	{
	header("Location:error.php"); die();
	}
?>