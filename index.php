<?php
ob_start();
session_start();
include 'config.php';
error_reporting(E_ALL ^ E_NOTICE);
include 'time.php';
?>
<html>
<head>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/model.css" type="text/css" />
<link rel="stylesheet" href="css/menu.css" type="text/css" />
<link rel="stylesheet" href="css/css.css" type="text/css" />
<link rel="stylesheet" href="css/font-awesome.min.css" />
<script src="js/jquery.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<meta charset="utf-8" />
<title>الحفظ الالكترونى للمكاتب اليدوية</title><link rel="icon" type="image/x-icon" href="Images/home.png"/>
</head>

<body style="background-color:#fffcd5">
<center>
			<div id="header">
					<img src="imgs/face/documantation.png"  alt=""/> 
					</div>
<?php
	if ($_SESSION['LOGINIS'] == 'done')
		{
		$link = $has->real_escape_string ($_GET['url']);
		$stmt = $has->prepare("select office from offices where mrand=?");
		$stmt->bind_param('s', $_SESSION['office']);
		$stmt-> execute();
		$stmt->bind_result($office);
		$stmt->fetch();
		$stmt->close();
		echo '<div class="menu_bar div_is_borderd">';
		require('logindone.php');
		echo '<a href="index.php?home=enter">الصفحة الرئيسية</a> | ';
		echo 'ادارة حفظ توثيق '.$office;
		echo '</div>';
		echo '<div class="container" dir="rtl">';
	echo '<nav> ';
        echo '<center>';
     echo '<ul>';
        echo '<li><a href="index.php?home=enter">الصفحة الرئيسية</a></li>';
        echo '<li><a href="#">التقارير</a>';
            echo '<ul>';
                echo '<li><a href="index.php?url=query">احصائية عن اعمال المكتب</a></li>';
                echo '<li><a href="index.php?url=query2">تقرير انجاز عن فترة</a></li>';
                echo '<li><a href="index.php?url=query3">اخر محرر لكل حرف</a></li>';
                echo '<li><a href="index.php?url=query4">المحرارت الخاصة بكل حرف</a>';
				if ($_SESSION['Role'] === 'Admin1' or $_SESSION['Role'] === 'Admin')
					{
					echo '<li><a href="index.php?url=query5">الفهرس</a>';
					}
				if ($_SESSION['Role'] === 'Admin1')
					{
					echo '<li><a href="index.php?url=query6">الصور الغير اصلية</a>';
					}
               echo '</ul>';
            echo '</li>';
            echo '<li><a href="#">الاعدادت</a>';
                echo '<ul>';
					if ($_SESSION['Role'] === 'Admin1')
						{
						echo '<li><a href="index.php?url=offices">مكاتب الشهر العقارى اليدوية</a></li>';
						}
                    echo '<li><a href="index.php?url=edit_pass">تغيير وإعادة تعيين كلمة السر</a></li>';
                    if ($_SESSION['Role'] === 'Admin1' or $_SESSION['Role'] === 'Admin')
						{
						echo '<li><a href="index.php?url=signup">انشاء حساب جديد</a></li>';
						echo '<li><a href="mybackup.php">تنزيل Backup لقاعدة البيانات</a>';
						}
               echo '</ul>';
            echo '</li>';
            echo '<li><a href="logout.php">تسجيل الخروج</a></li>';
              echo '</ul>';
              echo '</center>';
    echo '</nav>';
	echo '</div>';	
		}
	if ($_SESSION['LOGINIS'] != 'done'){ require('login.php');}

echo '<div>';

if ($link == ''){}
elseif ($link == 'reportd'){require ('reportd.php');}
elseif ($link == 'offices'){require ('offices.php');}
elseif ($link == 'signup'){require ('signup.php');}
elseif ($link == 'cnr'){require ('cnr.php');}
elseif ($link == 'search'){require ('search.php');}
elseif ($link == 'edit_pass'){require ('edit_pass.php');}
elseif ($link == 'query'){require ('query.php');}
elseif ($link == 'query2'){require ('query2.php');}
elseif ($link == 'query3'){require ('query3.php');}
elseif ($link == 'query4'){require ('query4.php');}
elseif ($link == 'query5'){require ('query5.php');}
elseif ($link == 'query6'){require ('query6.php');}
elseif ($link == 'govs'){require ('govs.php');}
else {}

if ($_SESSION['Role'] == 'Admin1' or $_SESSION['Role'] == 'Admin' or $_SESSION['Role'] == 'User')
			{
			if (isset($_GET["home"]))
				{
				?>
					<div>
					<?php
					if ($_SESSION['Role'] === 'Admin1' or $_SESSION['Role'] === 'User')
						{
					?>
							
							<div class="main_page">
							<a href="index.php?url=cnr">
							  <img src="imgs/face/real-estate-registration.png" alt="انشاء محرر جديد" title="حفظ محرر موثق"/>
							</a>
						</div>
					<?php
						}
					?>
						<div class="main_page">
						<!-- Button trigger modal -->
							<a data-toggle="modal" data-target="#exampleModal" href="">
								<img src="imgs/face/real-estate-document-checklist.png" alt="استدعاء محرر سابق" title="استدعاء محرر موثق"/>
							</a>
							<!-- Modal1 -->
							<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel"></h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								  </div>
								  <div class="modal-body">
									<button type="button" class="btn btn-primary"><a data-dismiss="modal" data-toggle="modal" href="#lost">البحث بواسطة المحرر</a></button>
									<button type="button" class="btn btn-primary" ><a data-dismiss="modal" data-toggle="modal" href="#lost1">البحث بواسطة الاسم</a></button>
									<button type="button" class="btn btn-primary" ><a data-dismiss="modal" data-toggle="modal" href="#lost2">البحث بواسطة الرقم القومى</a></button>
								  </div>
								  <div class="modal-footer">
								  </div>
								</div>
							  </div>
							</div>
							<!-- Modal2 -->
							<div class="modal fade" id="lost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title" id="exampleModalLabel">البحث بواسطة نوع ورقم المحرر</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
												<span aria-hidden="true">×</span>
											</button>
										</div>
										<div class="modal-body">
											<form action="" id="hala" method="post" dir="rtl">
												<label>نوع المحرر :</label>
												<select name="doctyp" id="doctyp" class="input_field" required>
													<option value="">اختر</option>
													<option value="1">محررات رسمية موثقة</option>
													<option value="2">محاضر التصديق على التوقيعات</option>
													<option value="3">محررات عرفية</option>
												</select>
												<label>رقم المحرر :</label><input type="text" name="docnum" id="docnum" class="input_field" required />
												<select name="doclet" id="doclet" style="height: 30px" required>
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
												<select name="year" id="year" style="height: 30px" required>
													<option value="">سنة</option>
													<?php
													for ($i = 2010; $i <= date("Y"); $i++)
														{
														echo '<option value="'.$i.'">'.$i.'</option>';
														}
													?>
												</select>
												<input type="submit" name="create" value="استعلام" class="newrecord" data-dismiss="modal" data-toggle="modal" href="#lost5" style="display:unset; padding: 7px 10px;" />
											</form>
										</div>
										<div class="modal-footer">
										</div>
									</div>
								</div>
							</div>
							<!-- Modal3 -->
							<div class="modal fade" id="lost1" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">البحث بواسطة الاسم</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form action="" method="post" dir="rtl">
										<label>الاسم بالكامل :</label><input type="text" name="member" id="member" class="input_field" required />
										<input type="submit" name="create1" value="استعلام" class="newrecord" data-dismiss="modal" data-toggle="modal" href="#lost4" style="display:unset; padding: 7px 10px;" />
									</form>
								  </div>
								  <div class="modal-footer">
								  </div>
								</div>
							  </div>
							</div>
							<!-- Modal4 -->
							<div class="modal fade" id="lost2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								  <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">البحث بواسطة الرقم القومى</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								  </div>
								  <div class="modal-body">
									<form action="index.php?home=enter" method="post" dir="rtl">
										<label>الرقم القومى :</label><input type="text" name="cid" id="cid" class="input_field" required />
										<input type="submit" name="create2" value="استعلام" class="newrecord" data-dismiss="modal" data-toggle="modal" href="#lost3" style="display:unset; padding: 7px 10px;" />
									</form>
								  </div>
								  <div class="modal-footer">
								  </div>
								</div>
							  </div>
							</div>
							<!-- Modal5 -->
							<div class="modal fade" id="lost3" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								 <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">البحث بواسطة الرقم القومى</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								  </div>
								  <div class="modal-body" id="fourth-choice">
									<script>
										$("#cid").change(function() {
										$("#fourth-choice").load("menu1.php?user="+encodeURI($("#cid").val()));
										});
									</script>
								  </div>
									<div class="modal-footer">
								  </div>
								</div>
							  </div>
							  </div>
							  <!-- Modal6 -->
							<div class="modal fade" id="lost4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								 <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">البحث بواسطة اسم المتعامل</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								  </div>
								  <div class="modal-body" id="fifth-choice">
									<script>
										$("#member").change(function() {
									    $("#fifth-choice").load("menu1.php?member="+encodeURI($("#member").val()));
										});
									</script>
								  </div>
									<div class="modal-footer">
								  </div>
								</div>
							  </div>
							 </div>
							  <!-- Modal7 -->
							<div class="modal fade" id="lost5" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog" role="document">
								<div class="modal-content">
								 <div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">البحث بواسطة نوع المحرر ورقمه</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
								  </div>
								  <div class="modal-body" id="sixth-choice">
									<script>
										$("#hala").change(function() {
										$("#sixth-choice").load("menu1.php?doctyp=" + encodeURI($("#doctyp").val()) + "&docnum=" + encodeURI($("#docnum").val()) + "&doclet=" + encodeURI($("#doclet").val()) + "&year=" + encodeURI($("#year").val()));
										});										
									</script>
								  </div>
									<div class="modal-footer">
								  </div>
								</div>
							  </div>
							</div>
						</div>
						
						<div style="clear:both"></div>
					</div>
					<div>
					<?php
					if ($_SESSION['Role'] === 'Admin1' or $_SESSION['Role'] === 'User')
						{
					?>	
						<div class="main_page">
							<a href="index.php?url=cnr">
								حفظ محرر موثق
							</a>
						</div>
						<!-- Button trigger modal -->
					<?php
					}
					?>
						<div class="main_page main_page1">
							<a data-toggle="modal" data-target="#exampleModal" href="">
								استدعاء محرر موثق
							</a>
						</div>
						
						<div style="clear:both"></div>
					</div>
<?php
				}
			}
?>
	</div>
	</center>
</body>
<footer>
	<div style="margin-top:200px"><center>
		<h5> Designed & Developed by <a href="">AhmedNabil</a> @ <?php echo date("Y");?></h5></center>
	</div>
</footer>
</html>