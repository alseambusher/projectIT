<?
//functons implemented
//signup()
//login()
//logout()
//TODO maintain log
//TODO modify_account(arguments)
include("basicfunctions.php");
switch($_GET['action']){
	case "login": login();break;
	case "signup": signup();break;
	case "logout": logout();break;
	case "test":isUser("alseambusher");break;
}
function login(){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$username=mysqli_real_escape_string($connect,$_POST['login_username']);
	$password=mysqli_real_escape_string($connect,$_POST['login_password']);
	$query=mysqli_query($connect,"select*from user_info where username=\"".$username."\" and password=MD5(\"".$password."\")")
			or die(header("Location:".$_POST['url']."?login_error=invalid username and password"));
	while($row=mysqli_fetch_array($query)){
		 if($username==$row['username']){
				session_start();
               $_SESSION['user_id']=$row['id'];
               $_SESSION['user_type']=$row['account_type'];
               $_SESSION['username']=$row['username'];
               $_SESSION['fullname']=$row['fullname'];
               header("Location:../index.php");
          }
	 }
	 if(!isLogin())
		header("Location:".$_POST['url']."?login_error=invalid username and password");
	
}
function signup(){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$username=secure_string($_POST['new_account_username']);
	$fullname=secure_string($_POST['new_account_name']);
	$password=secure_string($_POST['new_account_password']);
	$confirm_password=secure_string($_POST['new_account_password_confirmation']);
	$email=secure_string($_POST['new_account_email_address']);
	$confirm_email=secure_string($_POST['new_account_email_address_confirmation']);
	$account_type=$_POST['new_account_type'];
	//check if username exists already
	if(isUser($username))
		header("Location:http://localhost/project_IT/signup.php?message=Username already exists.<br>Please choose another username");
	//check before signing up
	if(($_POST['error_final']=="")&&$username&&$fullname&&$password&&$confirm_password&&$email&&$confirm_email&&
		($password==$confirm_password)&&($email==$confirm_email)&&
		(strlen($username)>4)&&(strlen($password)>5)){
				if($account_type=="student"){
					$query=mysqli_query($connect,"insert into user_info (username,fullname,password,email,account_type) values('$username',
					'$fullname',MD5(\"$password\"),'$email','$account_type')") or die("cant add to table");
					header("Location:http://localhost/project_IT/signup.php?message=Success!!<br>You have successfully signed up as a student.");
				}
				if($account_type=="teaching_staff"){
					$query=mysqli_query($connect,"insert into user_info (username,fullname,password,email,account_type) values('$username',
					'$fullname',MD5(\"$password\"),'$email','$account_type')") or die("cant add to table");
					$query=mysqli_query($connect,"insert into teacher_info (username,fullname,password,email) values('$username',
					'$fullname',MD5(\"$password\"),'$email')") or die("cant add to table");
					//create a table for every teacher
					$query=mysqli_query($connect,"create table ".get_id('teacher_info','username',$username)."_".get_id('user_info','username',$username)."_".$username."(
														id int auto_increment primary key,
														table_name varchar(60),
														description text,
														time timestamp)") or die("cant create table");
					header("Location:http://localhost/project_IT/signup.php?message=Success!!<br>You have successfully signed up as teaching staff.");
				}
			}
		else
			header("Location:http://localhost/project_IT/signup.php?message=Something went wrong please try again");
}

function logout(){
	echo isLogin();
	if(isLogin()){
		$_SESSION=array();
		session_destroy();
		header("Location: ../index.php");
	}
	header("Location: ../index.php");
}
?>
