<?php 
require "../config/connect.php";
require "check_login.php";
require "insert_logs.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/SMTP.php';

$admin_id=$_GET["admin_id"];
$id_member_player=$_GET['id_member_player'];
$email_member=$_GET['email_member'];
$member_name=$_GET['member_name'];
$id_member=$_GET['id_member'];
$id_player=$_GET['id_player'];
// $cmd=mysqli_query($con,"delete from tbl_eyetube where eyetube_id='$eyetube_id'");

$ins = insertLog('tbl_member_player','id_member_player',$id_member_player,'delete',$admin_id,$con,$ip);
if($ins=="sukses"){
	 $mail = new PHPMailer(true); 
		//Server settings
		$mail->SMTPDebug = 2;                                 // Enable verbose debug output
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'eyesoccerindonesia@gmail.com';                 // SMTP username
		$mail->Password = 'BolaSepak777#';                           // SMTP password
		$mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 465;                                    // TCP port to connect to

		//Recipients
		$mail->setFrom('info@eyesoccer.id', 'Info Eyesoccer');
		$mail->addAddress("$email_member");               // Name is optional
		$mail->addReplyTo('info@eyesoccer.id', 'Info Eyesoccer');
		$mail->addBCC('ebenk.rzq@gmail.com');

		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Status Validasi Pemain';
		$mail->Body    = 'Kepada '.$member_name.',<br><br>
		Validasi Pemain anda ditolak karena dokumen tidak mendukung. Silahkan ulangi langkah validasi pemain di member area dan lampirkan dokumen yang valid
		<br><br>
		Salam Eyesoccer';
		$mail->send();
		// echo 'Message has been sent';
		$cmd=mysqli_query($con,"delete from tbl_member_player where id_member_player='$id_member_player'");
		$upd = mysqli_query($con,"update tbl_player set member_id=0 where player_id=".$id_player."");
		$upd = mysqli_query($con,"update tbl_tmp_player set member_id=0,validation=0,newinsert=0 where player_id=".$id_player."");
		// $del = mysqli_query($con,"delete from tbl_online_player where player_id=".$id_player."");
}else{
	// echo $ins;exit();
}
// exit();
header("location:member_player?admin_id=$admin_id");

$_SESSION['admin_id']; 
?>