<?php
	include 'config.php';
	if (isset($_GET['user']))
		{
		$cid = $_GET['user'];
		$stmt = $has->prepare("select * from members where nid=? limit 5");
		$stmt->bind_param('s', $cid);
		$stmt->execute();
		$idfider = $stmt->get_result();
		$finderno = $idfider->num_rows;
		if ($finderno == 0)
			{
			echo '<h5>لم يعثر على هذا الرقم فى اى من المحررات المسجلة لدينا</h5>';
			}
		else
			{
			while ($reports = $idfider->fetch_array())
				{
				$mrand = $reports['mrand'];
				$docnum = $reports['docnum'];
				$root = $has->query ("select * from documentation where mrand='$mrand' and BINARY docnum='$docnum'");
				$rootd = $root->fetch_array();
				$doctyp = $rootd['doctyp'];
				$doclet = $rootd['doclet'];
				$date = $rootd['date'];
				$repet = $rootd['repet'];
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
				echo '<a href="index.php?url=reportd&report='.$mrand.'" target="_blank">محرر رقم '.$docnum;
				if ($repet == 'on')
					{
					echo ' مكرر';
					}
				echo ' '.$doctyp1.' حرف '.$doclet.' بتاريخ '.$date.'</a><br />';
				}
			echo '<br /><br />';
			echo '<form action="index.php?url=search" method="post">';
				echo '<input type="hidden" name="cid1" value="'.$cid.'" />';
				echo '<input type="submit" name="search" value="رؤية جميع نتائج البحث" />';
			echo '</form>';
			}
		}

	elseif (isset($_GET['member']))
		{
		$member = $_GET['member'];
		$stmt = $has->prepare("select distinct mrand from members where BINARY member LIKE ? limit 5");
		$member = "%".$member."%";
		$stmt->bind_param('s', $member);
		$stmt->execute();
		$idfider = $stmt->get_result();
		$finderno = $idfider->num_rows;
		/* DISTINCT helps to eliminate duplicates. If a query returns a result that contains duplicate rows, you can remove duplicates to produce a result set in which every row is unique.
		To do this, include the keyword DISTINCT after SELECT and before the output column list.*/
		if ($finderno == 0)
			{
			echo '<h5>لم يعثر على هذا الاسم فى أى من المحررات المسجلة لدينا</h5>';
			}
		else
			{
			while ($reports = $idfider->fetch_array())
				{
				$mrand = $reports['mrand'];
				$root = $has->query ("select * from documentation where mrand='$mrand'");
				$rootd = $root->fetch_array();
				$doctyp = $rootd['doctyp'];
				$docnum = $rootd['docnum'];
				$doclet = $rootd['doclet'];
				$date = $rootd['date'];
				$repet = $rootd['repet'];
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
				echo '<a href="index.php?url=reportd&report='.$mrand.'" target="_blank">محرر رقم '.$docnum;
				if ($repet == 'on')
					{
					echo ' مكرر';
					}
				echo ' '.$doctyp1.' حرف '.$doclet.' بتاريخ '.$date.'</a><br />';
				}
			echo '<br /><br />';
			echo '<form action="index.php?url=search" method="post">';
				echo '<input type="hidden" name="member1" value="'.$member.'" />';
				echo '<input type="submit" name="search1" value="رؤية جميع نتائج البحث" />';
			echo '</form>';
			}
		}

	elseif (isset($_GET['doctyp']))
		{
		$doctyp = $_GET['doctyp'];
		$docnum = $_GET['docnum'];
		$doclet = $_GET['doclet'];
		$year = $_GET['year'];
		$stmt = $has->prepare("select * from documentation where doctyp=? and BINARY docnum=? and doclet=? and YEAR(date)=?");
		$stmt->bind_param('sisi', $doctyp, $docnum, $doclet, $year);
		$stmt->execute();
		$idfider = $stmt->get_result();
		$finderno = $idfider->num_rows;
		if ($finderno == 0)
			{
			echo '<h5>لم يعثر على بيانات هذا المحرر لدينا</h5>';
			}
		else
			{
			while ($reports = $idfider->fetch_array())
				{
				$mrand = $reports['mrand'];
				$docnum = $reports['docnum'];
				$doctyp = $reports['doctyp'];
				$doclet = $reports['doclet'];
				$date = $reports['date'];
				$repet = $reports['repet'];
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
				echo '<a href="index.php?url=reportd&report='.$mrand.'" target="_blank">محرر رقم '.$docnum;
				if ($repet == 'on')
					{
					echo ' مكرر';
					}
				echo ' '.$doctyp1.' حرف '.$doclet.' بتاريخ '.$date.'</a><br />';
				}
			echo '<br /><br />';
			}
		}

	elseif (isset($_GET['username']))
		{
		$username = $_GET['username'];
		$stmt = $has->prepare("SELECT * FROM users WHERE username=?");
		$stmt->bind_param('s', $username);
		$stmt->execute();
		$data = $stmt->get_result();
		$datano = $data->num_rows;
		if ($datano > 0)
			{
			echo '<font style="color:red;font-weight:bold">هذا اسم المستخدم موجود بالفعل</font>';
			}
		elseif (strlen($username) < 4)
			{
			echo '<font style="color:red;font-weight:bold">اسم المستخدم لا يجب ان يقل عن 4 احرف وارقام</font>';
			}
		elseif(!preg_match('/^([A-z0-9]+[_\'-]?[a-z0-9]+[ ]?)+$/', $username)) 
			{
			echo '<font style="color:red;font-weight:bold">اسم مستخدم غير صالح</font>';
			}
		else
			{
			echo '<span style="color:green;font-weight:bold">اسم المستخدم متاح</span>';
			}
		$stmt->close();
		}

	elseif (isset($_GET['password']))
		{
		$password = $_GET['password'];
		if (strlen($password) < 6)
			{
			echo '<font style="color:red">كلمة السر لا يجب ان تقل عن 6 احرف او ارقام</font>';
			}
		elseif (strlen($password) > 14)
			{
			echo '<font style="color:red">كلمة السر لا يجب ان تزيد عن 14 حرف او رقم</font>';
			}
		else 
			{
			echo '<font style="color:green">كلمة سر مناسبة</font>';
			}
		}

	elseif (isset($_POST['username']))
		{
		$username1 = $_POST['username'];
		$stmt = $has->prepare("SELECT * FROM users WHERE username=?");
		$stmt->bind_param('s', $username1);
		$stmt->execute();
		$data = $stmt->get_result();
		$datano = $data->num_rows;
		if ($datano > 0 or strlen($username1) < 4)
			{
			echo '1';
			}
		elseif(!preg_match('/^([A-z0-9]+[_\'-]?[a-z0-9]+[ ]?)+$/', $username1)) 
			{
			echo '1';
			}
		else
			{
			echo '0';
			}
		}

	elseif (isset($_GET['password1']))
		{
		$password1 = $_GET['password1'];
		if (strlen($password1) < 6)
			{
			echo '<font style="color:red">كلمة السر لا يجب ان تقل عن 6 احرف او ارقام</font>';
			}
		elseif (strlen($password1) > 14)
			{
			echo '<font style="color:red">كلمة السر لا يجب ان تزيد عن 14 حرف او رقم</font>';
			}
		else 
			{
			echo '<font style="color:green">كلمة سر مناسبة</font>';
			}
		}
?>