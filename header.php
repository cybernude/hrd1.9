<?php @session_start(); ?>
<?php
include_once 'connection/connect_i.php';
//===ชื่อโรงพยาบาล
if ($db) {
    $sql = mysqli_query($db, "select * from  hospital");
    $resultHos = mysqli_fetch_assoc($sql);
}
if (!empty($resultHos['logo'])) {
    $pic = $resultHos['logo'];
    $fol = "logo/";
} else {
    $pic = 'agency.ico';
    $fol = "images/";
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />  
        <title>ระบบข้อมูลบุคคลากรโรงพยาบาล</title>
        <LINK REL="SHORTCUT ICON" HREF="<?= $fol . $pic; ?>">
        <!-- Bootstrap core CSS -->
        <link href="option/css/bootstrap.css" rel="stylesheet">
        <!--<link href="option/css2/templatemo_style.css" rel="stylesheet">-->
        <!-- Add custom CSS here -->
        <link href="option/css/sb-admin.css" rel="stylesheet">
        <link rel="stylesheet" href="option/font-awesome/css/font-awesome.min.css">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="option/css/morris-0.4.3.min.css">
        <link rel="stylesheet" href="option/css/stylelist.css">

        <!--date picker-->
        <script src="option/js/jquery.min.js"></script>
        <script src="option/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.js" type="text/javascript"></script>
        <link href="option/jquery-ui-1.11.4.custom/jquery-ui-1.11.4.custom.css" rel="stylesheet" type="text/css"/>
        <link href="option/jquery-ui-1.11.4.custom/SpecialDateSheet.css" rel="stylesheet" type="text/css"/>
        <!--Data picker Thai-->
        <script src="js/DatepickerThai4.js" type="text/javascript"></script>
        <!-- DataTables -->
        <link rel="stylesheet" href="option/DataTables/dataTables.bootstrap4.css">
        <!-- Select2--> 
        <link href="option/select2/select2.min.css" rel="stylesheet" type="text/css"/>
        <!-- excell export -->
        <script src="option/js/excellentexport.js"></script>

        <!-- InstanceBeginEditable name="head" -->
            <!--<style type="text/css">
        html{
        -moz-filter:grayscale(100%);
        -webkit-filter:grayscale(100%);
        filter:gray;
        filter:grayscale(100%);
        }
        </style>-->
        <style type="text/css">
            .black-ribbon {   position: fixed;   z-index: 9999;   width: 70px; }
            @media only all and (min-width: 768px) { .black-ribbon { width: auto; } }

            .stick-left { left: 0; }
            .stick-right { right: 0; }
            .stick-top { top: 0; }
            .stick-bottom { bottom: 0; }
        </style>
        <script type="text/javascript">
            function resizeIframe(obj)// auto height iframe
            {
                {
                    obj.style.height = 0;
                }
                ;
                {
                    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
                }
            }
        </script>
        <script type="text/javascript">
            function getRefresh() {
                $("#auto").show("slow");
                $("#autoRefresh").load("count_comm.php", '', callback);
            }

            function callback() {
                $("#autoRefresh").fadeIn("slow");
                setTimeout("getRefresh();", 1000);
            }

            $(document).ready(getRefresh);
        </script>
        <script language="JavaScript">
            var HttPRequest = false;
            function doCallAjax(Sort) {
                HttPRequest = false;
                if (window.XMLHttpRequest) { // Mozilla, Safari,...
                    HttPRequest = new XMLHttpRequest();
                    if (HttPRequest.overrideMimeType) {
                        HttPRequest.overrideMimeType('text/html');
                    }
                } else if (window.ActiveXObject) { // IE
                    try {
                        HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
                    } catch (e) {
                        try {
                            HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
                        } catch (e) {
                        }
                    }
                }
                if (!HttPRequest) {
                    alert('Cannot create XMLHTTP instance');
                    return false;
                }
                var url = 'count_comm.php';
                var pmeters = 'mySort=' + Sort;
                HttPRequest.open('POST', url, true);
                HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                //HttPRequest.setRequestHeader("Content-length", pmeters.length);
                //HttPRequest.setRequestHeader("Connection", "close");
                HttPRequest.send(pmeters);
                HttPRequest.onreadystatechange = function ()
                {
                    if (HttPRequest.readyState == 3)  // Loading Request
                    {
                        document.getElementById("mySpan").innerHTML = "Now is Loading...";
                    }
                    if (HttPRequest.readyState == 4) // Return Request
                    {
                        document.getElementById("mySpan").innerHTML = HttPRequest.responseText;
                    }
                }
            }
        </script>


    </head>
    <?php
    if (!empty($_GET['popup'])) {
        $project_place = $_GET['project_place'];
        $province = $_GET['province'];
        $stdate = $_GET['stdate'];
        $etdate = $_GET['etdate'];
        $amount = $_GET['amount'];
        ?>
        <body onload="return popup('popup_request_car.php?project_place=<?= $project_place ?>&province=<?= $province ?>&stdate=<?= $stdate ?>&etdate=<?= $etdate ?>&amount=<?= $amount ?>', popup, 600, 650);">
        <?php } elseif (!empty($_POST['popup'])) { ?>
        <body onLoad="KillMe();self.focus();window.opener.location.reload();">
        <?php } elseif (!empty($_GET['approval'])) { 
        $pro_id = $_GET['id'];
        $id = $_GET['empno'];
        ?>
        <body onload="return popup('approval_page1.php?id=<?= $id ?>&pro_id=<?= $pro_id ?>', popup, 800,500);">
        <?php } else { ?>
        <body Onload="bodyOnload();">    
<?php } ?>
        <!-- Top Left 
<img src="/images/black_ribbon_top_left.png" class="black-ribbon stick-top stick-left"/>-->

        <!-- Top Right 
        <img src="/images/black_ribbon_top_right.png" class="black-ribbon stick-top stick-right"/>-->

        <!-- Bottom Left 
        <img src="/images/black_ribbon_bottom_left.png" class="black-ribbon stick-bottom stick-left"/>-->

        <!-- Bottom Right 
        <img src="images/black_ribbon_bottom_right.png" class="black-ribbon stick-bottom stick-right"/>-->
        <!--<div id="wrapper">-->
        <!-- Sidebar -->
        <nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="container-fluid">
                <div class="navbar-header">

                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <a class="navbar-brand logo-mini" href="index.php?unset=1"><img alt="Brand" src="images/kuser.ico" width='35'> 
                        <font color='#ffff00'><b>HRD S</b>ystem V.1.9.4</font>
                    </a>
                </div>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav navbar-right navbar-user">
                    <?PHP if (empty($_SESSION['user'])) { ?>            	
                        <li> 	
                            <form class="navbar-form navbar-right" action='checkLogin(2).php' method='post'>
                                <div class="form-group">
                                    <input type="text" placeholder="User Name" name='user_account' class="form-control" value='' required>
                                </div>
                                <div class="form-group">
                                    <input type="password" placeholder="Password" name='user_pwd' class="form-control"  value='' required>
                                </div>
                                <button type="submit" class="btn btn-warning"><i class="fa fa-lock"></i> Sign in</button> 
                                <div class="form-group">
                                </div>
                            </form>
                        </li>
<?PHP } else { ?>
                        <script language="JavaScript">
                            function bodyOnload()
                            {
                                doCallAjax('countrecomm')
                                setTimeout("doLoop();", 10000);
                            }
                            function doLoop()
                            {
                                bodyOnload();
                            }
                        </script>
                        <ul class="nav navbar-nav navbar-user" id="mySpan"></ul>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/kuser.ico' width='25'> บุคลากร <b class="caret"></b></a>
                            <ul class="dropdown-menu">
    <?php if ($_SESSION['Status'] == 'ADMIN') { ?>
                                    <li><a href="add_person.php?unset=1"><img src='images/adduser.ico' width='25'> เพิ่มข้อมูลบุคลากร</a></li>
                                    <li><a href="pre_person.php?unset=1"><img src='images/identity.png' width='25'> ข้อมูลบุคลากร</a></li>
                                    <!-- <li><a href="create_card.php?unset=1"><img src='images/phonebook.ico' width='25'> พิมพ์บัตรพนักงาน</a></li> -->
                                    <li><a href="#" onClick="window.open('gencardgroup.html', '', 'width=600,height=800'); return false;"><img src='images/phonebook.ico' width='25'> พิมพ์บัตรพนักงาน</a></li>
                                    <li><a href="pre_educate.php?unset=1"><img src='images/Student.ico' width='25'> ประวัติการศึกษา</a></li>
                                    <li><a href="pre_Whistory.php?unset=1"><img src='images/work.ico' width='25'> ประวัติการทำงาน</a></li>
                                    <li><a href="pre_eval.php?unset=1"><img src='images/money.ico' width='25'> ประวัติการประเมิน/เงินเดือน</a></li>
                                    <li><a href="resign_person.php?unset=1"><img src='images/identity-x.png' width='25'> ข้อมูลบุคลากรย้าย/ลาออก</a></li>
                                    <li class="divider"></li>
                                    <li><a href="statistics_person.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติบุคลากร</a></li>
                                    <li><a href="#" onClick="window.open('detial_type.php', '', 'width=470,height=520'); return false;" title="สถิติประเภทพนักงาน"><img src='images/kchart.ico' width='25'> สถิติประเภทพนักงาน</a></li>
                                    <li><a href="#" onClick="window.open('detial_position.php', '', 'width=950,height=680'); return false;" title="สถิติตำแหน่งพนักงาน"><img src='images/kchart.ico' width='25'> สถิติตำแหน่งพนักงาน</a></li>
    <?php } else { ?>
                                    <li><a href="#" onClick="window.open('detial_person.php', '', 'width=700,height=500'); return false;" title="ข้อมูลบุคลากร"><img src='images/identity.ico' width='25'> ข้อมูลบุคลากร</a></li>
                                    <li><a href="detial_educate.php?unset=1"><img src='images/Student.ico' width='25'> ประวัติการศึกษา</a></li>
                                    <li><a href="detial_Whistory.php?unset=1"><img src='images/work.ico' width='25'> ประวัติการทำงาน</a></li>
                                    <li><a href="detial_eval.php?id=<?=$_SESSION['user']?>"><img src='images/money.ico' width='25'> ประวัติการประเมิน/เงินเดือน</a></li>
    <?php } if ($_SESSION['Status'] == 'SUSER' or $_SESSION['Status'] == 'USUSER') { ?>
                                    <li class="divider"></li>
                                    <li><a href="statistics_person.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติบุคลากรในหน่วยงาน</a></li>
    <?php } ?>
                            </ul>            
                        </li>

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/Letter.png' width='25'> การลา <b class="caret"></b></a>
                            <ul class="dropdown-menu">
    <?php if ($_SESSION['Status'] == 'ADMIN') { ?>
                                    <li><a href="receive_leave.php?unset=1"><img src='images/kwrite.ico' width='25'> บันทึกทะเบียนรับใบลา</a></li>
                                    <li><a href="pre_leave.php?unset=1"><img src='images/Lfolder.ico' width='25'> บันทึกการลาบุคลากร</a></li>
                                    <li><a href="conclude_cancle.php?unset=1"><img src='images/Cfolder.ico' width='25'> ยกเลิกการลา</a></li>
                                    <li><a href="conclude_transfer.php?unset=1"><img src='images/folder_sent.ico' width='25'> โอนลาชั่วโมง</a></li>
                                    <li class="divider"></li>
                                    <li><a href="statistics_scan.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติการลืมลงเวลา</a></li>
                                    <li><a href="statistics_late.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติการลงสาย</a></li>
                                    <li class="divider"></li>
                                    <li><a href="Lperson_report.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติการลาแยกหน่วยงาน</a></li>
                                    <!--<li><a href="statistics_leave.php"><img src='images/kchart.ico' width='25'> สถิติการลา</a></li>-->
                                    <li><a href="Lperson_report_sum.php?screen=1&unset=1"><img src='images/kchart.ico' width='25'> สรุปวันลาแยกหน่วยงาน</a></li>
                                    <li><a href="Lperson_report_sum.php?screen=2&unset=1"><img src='images/kchart.ico' width='25'> สรุปวันลาแยกประเภทบุคลากร</a></li>
                                    <li><a href="lateforget_report.php?unset=1"><img src='images/kchart.ico' width='25'> สรุปลืมลงเวลา/สายแยกประเภทบุคลากร</a></li>
                                <?php } else { ?> 
                                    <li><a href="pre_leave.php?unset=1"><img src='images/Lfolder.ico' width='25'> บันทึกการลาบุคลากร</a></li>
    <?php } if ($_SESSION['Status'] == 'SUSER' or $_SESSION['Status'] == 'USUSER') { ?>
                                    <li class="divider"></li>
                                    <li><a href="Lperson_report.php?unset=1"><img src='images/kchart.ico' width='25'> สถิติการลาในหน่วยงาน</a></li>
    <?php } ?>
                            </ul> 
                        </li>
    <?php if ($_SESSION['Status'] == 'ADMIN') { ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/training.ico' width='25'> อบรมภายนอก <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="receive_trainout.php?unset=1"><img src='images/kwrite.ico' width='25'> บันทึกทะเบียนรับอบรมภายนอก/ไปราชการ</a></li>
                                    <li><a href="add_project_out.php?unset=1"><img src='images/add.ico' width='25'></i> บันทึกโครงการฝึกอบรมภายนอก</a></li>
                                    <li><a href="pre_trainout.php?unset=1"><img src='images/kig.ico' width='25'> บันทึกการฝึกอบรมภายนอก</a></li>
                                    <li class="divider"></li>
                                    <li><a href="statistics_trainout.php?unset=1"><img src='images/kchart.ico' width='25'> รายงานการฝึกอบรมภายนอก</a></li>
                                    <li><a href="pre_trainout(N).php?unset=1"><img src='images/kchart.ico' width='25'> รายงานการฝึกอบรมภายนอกที่ยังไม่ได้สรุป</a></li>
                                    <li><a href="pre_persontrainout(N).php?unset=1"><img src='images/kchart.ico' width='25'> รายงานผู้ที่ยังไม่ได้สรุป</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/trainin.ico' width='25'> อบรมภายใน <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="add_project.php?unset=1"><img src='images/add.ico' width='25'> บันทึกโครงการฝึกอบรมภายใน</a></li>
                                    <li><a href="pre_trainin.php?unset=1"><img src='images/kig.ico' width='25'> บันทึกการฝึกอบรมภายใน</a></li>
                                    <li class="divider"></li>
                                    <li><a href="statistics_trainin.php?unset=1"><img src='images/kchart.ico' width='25'> รายงานการฝึกอบรมภายใน</a></li>
                                </ul>
                            </li>

    <?php } else { ?>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/trainin.ico' width='25'> ประวัติระบบฝึกอบรม <b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a href="add_project_out.php?unset=1"><img src='images/add.ico' width='25'></i> บันทึกโครงการฝึกอบรมภายนอก</a></li>
                                    <li><a href="pre_trainout.php?unset=1"><img src='images/kig.ico' width='25'> บันทึกการฝึกอบรมภายนอก</a></li>
                                    <li class="divider"></li>
                                    <li><a href="detial_trainin.php?unset=1"><img src='images/training.ico' width='25'> ประวัติระบบฝึกอบรม(เก่า)</a></li>
                                    <li><a href="detial_trainin(new).php?unset=1"><img src='images/training.ico' width='25'> ประวัติระบบฝึกอบรม(ใหม่)</a></li>
        <?php if ($_SESSION['Status'] == 'SUSER' or $_SESSION['Status'] == 'USUSER') { ?>
                                        <li class="divider"></li>
                                        <li><a href="statistics_trainout.php?unset=1"><img src='images/kchart.ico' width='25'> รายงานการฝึกอบรมภายนอก</a></li>
                                        <li><a href="statistics_trainin.php?unset=1"><img src='images/kchart.ico' width='25'> รายงานการฝึกอบรมภายใน</a></li>
        <?php } ?>
                                </ul>
                            </li><?php } ?>

                        <li class="dropdown user-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src='images/personal.ico' width='20'> 
                                <?php
                                $user_id = isset($_SESSION['user']) ? $_SESSION['user'] : '';
                                if ($user_id != '') {
                                    $sql = mysqli_query($db, "select concat(firstname,' ',lastname) AS name from emppersonal WHERE empno='$user_id'");
                                    $result = mysqli_fetch_assoc($sql);
                                    echo $result['name'];
                                }
                                ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                            <!--  <li><a href="#"><i class="fa fa-user"></i> Profile</a></li>
                              <li><a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge">
                              </span></a></li>
                              <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>         
                                --> 

                                <li><a href="Add_User.php?user_id=<?= $_SESSION['user'] ?>"><img src='images/personal.ico' width='25'> แก้ไขข้อมูลส่วนตัว</a></li>
                                <?php if ($_SESSION['Status'] == 'ADMIN') {
                                    $check = md5(trim('check'));
                                    ?>
                                    <li class="divider"></li>
                                    <li><a href="#" onClick="return popup('set_conn_db.php?method=<?= $check ?>', popup, 400, 515);" title="Config Database"><img src='images/Settings.ico' width='25'> ตั้งค่าเชื่อมต่อโปรแกรม</a></li>
                                    <li><a href="Add_Hos.php?unset=1"><img src='images/Settings.ico' width='25'> ตั้งค่าองค์กร/ผู้บริหาร</a></li>
                                    <li><a href="Add_User.php?unset=1"><img src='images/Settings.ico' width='25'> ตั้งค่าผู้ใช้งาน</a></li>
                                    <li><a href="Add_Department.php?unset=1"><img src='images/Settings.ico' width='25'> ตั้งค่าฝ่าย/งาน</a></li>
                                    <li><a href="Add_Position.php?unset=1"><img src='images/Settings.ico' width='25'> ตั้งค่าตำแหน่ง</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" onClick="window.open('regularity.php', '', 'width=1200,height=700'); return false;" title="เพิ่มระเบียบ"><img src='images/sticky-notes.ico' width='25'> ระเบียบ/ข้อบังคับ</a></li>
                                    <li class="divider"></li>
                                    <li><a href="backup.php?unset=1" onclick="return confirm('กรุณายืนยันการสำรองข้อมูลอีกครั้ง !!!')"><img src='images/backup-restore.ico' width='25'> สำรองข้อมูล</a></li>
                                    <li><a href="#" onClick="window.open('openDB.php', '', 'width=400,height=350'); return false;" title="ข้อมูลสำรอง"><img src='images/database.ico' width='25'> ข้อมูลสำรอง</a></li>
                                    <li class="divider"></li> <?php } ?>
                                <li><a href="#" onClick="return popup('fullcalendar/fullcalendar4.php', popup, 820, 710);" title="ดูกิจกรรมส่วนตัว"><img src='images/calendar-clock.ico' width='25'> ปฏิทินกิจกรรมส่วนตัว</a></li>
                                 <?php if ($_SESSION['Status'] == 'ADMIN') { ?>
                                <li><a href="#" onClick="return popup('add_holiday_calendra.php', popup, 800, 710);" title="เพิ่มวันหยุดนักขัตฤกษ์"><img src='images/Add_calendar.ico' width='25'> เพิ่มวันหยุดนักขัตฤกษ์</a></li>
                                <li class="divider"></li>
                                <li><a href="reset_counter.php" onclick="return confirm('ต่อไปนี้จะเป็นการ รีเซทการนับเลขเอกสารต่าง กรุณายืนยันอีกครั้ง !!!')"><img src='images/Bomb.ico' width='25'> Reset Counter.</a></li>
                                <?php } ?>
                                <li class="divider"></li>
                                <li><a href="#" onClick="return popup('about.php', popup, 550, 700);" title="เกี่ยวกับเรา"><img src='images/Paper Mario.ico' width='25'> เกี่ยวกับเรา</a></li>
                                <li class="divider"></li> 
                                <li><a href="logout.php"><img src='images/exit.ico' width='25'> Log Out</a></li>
                            </ul>
                            </form>
<?PHP } ?>
                    </li>
                </ul>
                </div> 
        </nav>
        <!--scrip check numberical-->
        <script type="text/javascript">
            function inputDigits(sensor) {
                var regExp = /[0-9.-]$/;
                if (!regExp.test(sensor.value)) {
                    alert("กรอกตัวเลขเท่านั้นครับ");
                    sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                }
            }
        </script>
        <!--scrip check ตัวอักษร-->
        <script type="text/javascript">
            function inputString(sensor) {
                var regExp = /[A-Za-zก-ฮะ-็่-๋์]$/;
                if (!regExp.test(sensor.value)) {
                    alert("กรอกตัวอักษรเท่านั้นครับ");
                    sensor.value = sensor.value.substring(0, sensor.value.length - 1);
                }
            }

        </script>
        <script language="JavaScript">
            function chkdel() {
                if (confirm('  กรุณายืนยันการลบอีกครั้ง !!!  ')) {
                    return true;
                } else {
                    return false;
                }
            }
        </script>
        <script type="text/javascript">
            function popup(url, name, windowWidth, windowHeight) {
                myleft = (screen.width) ? (screen.width - windowWidth) / 2 : 100;
                mytop = (screen.height) ? (screen.height - windowHeight) / 2 : 100;
                properties = "width=" + windowWidth + ",height=" + windowHeight;
                properties += ",scrollbars=yes, top=" + mytop + ",left=" + myleft;
                window.open(url, name, properties);
            }
        </script>
        <?php

        function insert_date($take_date_conv) {
            $take_date = explode("-", $take_date_conv);
            $take_date_year = @$take_date[2] - 543;
            $take_date = "$take_date_year-" . @$take_date[1] . "-" . @$take_date[0] . "";
            return $take_date;
        }

        function edit_date($take_date) {

            $take_date = explode("-", $take_date);
            $pyear = $take_date[0] + 543;
            $take_date = "$take_date[2]-$take_date[1]-$pyear";
            return $take_date;
        }

        function unset_session() {
            if (!empty($_SESSION['check_date01'])) {
                unset($_SESSION['check_date01']);
            }
            if (!empty($_SESSION['check_date02'])) {
                unset($_SESSION['check_date02']);
            }
            if (!empty($_SESSION['txtKeyword'])) {
                unset($_SESSION['txtKeyword']);
            }
            if (!empty($_SESSION['check_rec'])) {
                unset($_SESSION['check_rec']);
            }
            if (!empty($_SESSION['check_cancle'])) {
                unset($_SESSION['check_cancle']);
            }
            if (!empty($_SESSION['check_Lperson'])) {
                unset($_SESSION['check_Lperson']);
            }
            if (!empty($_SESSION['dep_Lperson'])) {
                unset($_SESSION['dep_Lperson']);
            }
            if (!empty($_SESSION['depname'])) {
                unset($_SESSION['depname']);
            }
            if (!empty($_SESSION['check_trainout'])) {
                unset($_SESSION['check_trainout']);
            }
            if (!empty($_SESSION['check_out'])) {
                unset($_SESSION['check_out']);
            }
            if (!empty($_SESSION['check_trainin'])) {
                unset($_SESSION['check_trainin']);
            }
            if (!empty($_SESSION['check_pro'])) {
                unset($_SESSION['check_pro']);
            }
            if (!empty($_SESSION['check_stat'])) {
                unset($_SESSION['check_stat']);
            }
            if (!empty($_SESSION['empno'])) {
                unset($_SESSION['empno']);
            }
        }
        ?>
        <script language="JavaScript" type="text/javascript">
            var StayAlive = 4; // เวลาเป็นวินาทีที่ต้องการให้ WIndows เปิดออก 
            function KillMe()
            {
                setTimeout("self.close()", StayAlive * 1000);
            }
        </script>            
        <div id="page-wrapper">