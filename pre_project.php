<?php @session_start(); ?>
<?php include_once 'head.php';?>
<?php
if (empty($_SESSION['user'])) {
    echo "<meta http-equiv='refresh' content='0;url=index.php'/>";
    exit();
}
if (!empty($_REQUEST['del_id'])) { //ถ้า ค่า del_id ไม่เท่ากับค่าว่างเปล่า
    $del_id = $_REQUEST['del_id'];
    $del_pro = $_REQUEST['del_pro'];
    $sql_del = "delete from plan where type_id = '$del_id' and pjid='$del_pro'";
    mysqli_query($db,$sql_del) or die(mysqli_error($db));
//echo "ลบข้อมูล ID $del_id เรียบร้อยแล้ว";
}
?>
<div class="row">
    <div class="col-lg-12">
        <h1><font color='blue'>  รายละเอียดโครงการ </font></h1>
    </div>
</div>
<?php
include_once ('option/funcDateThai.php');
$project_id = $_REQUEST['id'];
$sql_pro = mysqli_query($db,"SELECT t.*, CONCAT(e.firstname,' ',e.lastname) as fullname,p.PROVINCE_NAME FROM trainingin t
INNER JOIN emppersonal e ON t.adminadd=e.empno
inner join province p on t.in6=p.PROVINCE_ID
 WHERE idpi='$project_id'");
$Project_detial = mysqli_fetch_assoc($sql_pro);
?>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">ตารางบันทึกการฝึกอบรมภายในหน่วยงาน</h3>
            </div>
            <div class="panel-body">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                                <tr>
                                    <td><b>เลขที่โครงการ : &nbsp; </b><?= $Project_detial['in1'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ชื่อโครงการ : &nbsp; </b><?= $Project_detial['in2'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>หน่วยงานที่จัดโครงการ : &nbsp; </b><?= $Project_detial['in3'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>วัตถุประสงค์ที่จัดโครงการ : &nbsp; </b><?= $Project_detial['in4'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ตั้งแตวันที่ : &nbsp; </b><?= DateThai1($Project_detial['dateBegin']) ?>&nbsp; <b> ถึง &nbsp;</b><?= DateThai1($Project_detial['dateEnd']) ?>
                                    <b> &nbsp; จำนวน : &nbsp; </b><?= $Project_detial['in8'] ?><b>&nbsp; วัน</b><b> &nbsp; จำนวนชั่วโมง : &nbsp; </b><?= $Project_detial['in9'] ?><b>&nbsp; ชั่วโมง</b>
                                    <b> &nbsp; ณ. &nbsp; </b><?= $Project_detial['in5'] ?><b> &nbsp; จ. </b> &nbsp; <?= $Project_detial['PROVINCE_NAME'] ?></td>
                                </tr>
                                <tr>
                                    <td><b>ผู้รับผิดชอบโครงการ : &nbsp; </b><?= $Project_detial['fullname'] ?></td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                </tr>
                            </table>
                            <?php   $method = isset($_GET['method'])?$_GET['method']:'';
                            if(empty($method) or $method!='edit'){
                                $sql_pro_name = mysqli_query($db,"SELECT p.*, CONCAT(e.firstname,' ',e.lastname) as fullname FROM plan p
INNER JOIN emppersonal e ON p.type_id=e.empno
 WHERE p.pjid='$project_id'");
                            ?>
                            <table width="80%" border="0" cellspacing="0" cellpadding="0">
                                 
                                <tr>
                                    <td colspan="4" align="center"><b>ผู้เข้าร่วมโครงการ</b></td>
                                </tr>
                                 <tr><th>ลำดับ</th>
                                    <th>ชื่อ-นามสกุล</th>
                                    <th>วันที่เข้าร่วม</th>
                                    <th>จำนวนชั่วโมง</th>
                                    <?php if($_SESSION['Status']=='ADMIN'){?>
                                    <th>แก้ไข</th>
                                    <th>ลบ</th>
                                    <?php }?>
                                </tr>
                                <?php
                    $i = 1;
                    while ($Project_Name = mysqli_fetch_assoc($sql_pro_name)) {
                        ?>
                                <tr><td align="center"><?=$i?></td>
                                    <td><?=$Project_Name['fullname']?></td>
                                    <td align="center"><?=DateThai1($Project_Name['bdate'])?> ถึง <?=DateThai1($Project_Name['edate'])?></td>
                                    <td align="center"><?=$Project_Name['amount']?></td>
                                    <?php if($_SESSION['Status']=='ADMIN'){?>
                                    <td align="center"><a href="pre_project.php?method=edit&&empno=<?=$Project_Name['type_id'];?>&&id=<?=$Project_Name['pjid']?>"><img src='images/tool.png' width='25'></a></td>
                                    <td align="center"><a href='pre_project.php?del_id=<?=$Project_Name['type_id'];?>&del_pro=<?=$Project_Name['pjid'];?>&id=<?=$Project_Name['pjid'];?>' onClick="return confirm('กรุณายืนยันการลบอีกครั้ง !!!')"><img src='images/bin1.png' width='25'></a></td>
                                    <?php }?>
                                </tr>
                                <?php $i++;
                }
                ?>
                            </table>
                            <?php }elseif($method=='edit') {
                                $empno=$_GET['empno'];
                                $add_emp=  mysqli_query($db,"SELECT pid,amount,bdate,edate FROM plan WHERE type_id=$empno AND pjid=$project_id");
                                $planout=  mysqli_fetch_assoc($add_emp);
                                echo "<form action='prctraining.php' method='post' name='form' enctype='multipart/form-data' id='form'>";
                                echo "<lable for='begin_date'>วันที่เข้าร่วม</lable>";
                                echo "&nbsp; <input type='date' name='bdate' id='begin_date' value='".$planout['bdate']."'> &nbsp;";
                                echo "<lable for='end_date'>ถึง</lable>";
                                echo "&nbsp; <input type='date' name='edate' id='end_date' value='".$planout['edate']."'> &nbsp;";
                                echo "<lable for='amount'>จำนวน</lable>";
                                echo "&nbsp; <input type='text' name='amount' id='amount' size='1' value='".$planout['amount']."'> &nbsp; ชั่วโมง";
                                echo "<input type='hidden' name='method' value='edit_date_in'>";
                                echo "<input type='hidden' name='pid' value='".$planout['pid']."'>";
                                echo "<input type='hidden' name='empno' value='".$empno."'>";
                                echo "<input type='hidden' name='pjid' value='".$project_id."'>";
                                echo "&nbsp; <input type='submit' name='submit' class='btn-warning' value='แก้ไข'>";
                                echo "</form>";
                            }?>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <?php 
        $select_url= mysqli_query($db,"select url from hospital");
        $url=  mysqli_fetch_assoc($select_url);
        if($method=='back'){?><center>
                   <a href="fullcalendar/fullcalendar5.php"><img src="images/undo.ico" width="20"  title="ย้อนกลับ"> กลับไปปฏิทินอบรมภายใน</a>
</center>
        <?php }?>
    </div>
</div>
<?php include_once 'footeri.php'; ?>
