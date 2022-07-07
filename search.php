<?php
if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] === 'Admin' or $_SESSION['Role'] === 'User')
	{
	if (isset($_POST['search']))
		{
		$cid1 =$_POST['cid1'];
		$stmt = $has->prepare("select * from members where nid=?");
		$stmt->bind_param('s', $cid1);
		$stmt->execute();
		$idfider = $stmt->get_result();
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
		}
	if (isset($_POST['search1']))
		{
		$member1 =$_POST['member1'];
		$stmt = $has->prepare("select distinct mrand from members where member LIKE ?");
		$member1 = "%".$member1."%";
		$stmt->bind_param('s', $member1);
		$stmt->execute();
		$idfider = $stmt->get_result();
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
				$doctyp1="محاضر التصديق والتوقيعات";
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
		}
	if (isset($_POST['search2']))
		{
		$doctyp1 =$_POST['doctyp1'];
		$docnum1 =$_POST['docnum1'];
		$doclet1 =$_POST['doclet1'];
		$stmt = $has->prepare("select * from documentation where doctyp=? and docnum=? and doclet=?");
		$stmt->bind_param('sss', $doctyp1, $docnum1, $doclet1);
		$stmt->execute();
		$idfider = $stmt->get_result();
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
				$doctyp1="محاضر التصديق والتوقيعات";
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
		}
	}
else 
	{
	header("Location:error.php"); die();
	}
?>