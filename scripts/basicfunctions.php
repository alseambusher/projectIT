<?php session_start();
/*List of functions
 * remote_test a test function
 * isLogin
 * isUser(username)
 * get_id($table_name,$column_name,$column_value)
 * get_url
 * isTeacher
 * get_teacher_table
 * get_student_table
 * secure_string($string)
 * get_from_student_table($string,$option)
 * max_marks($table_name)
 * get_marks($table_name,$string)
 * TODO get_update
*/
//returns 0 when not logged in else returns 1
function remote_test(){
	echo "works";
}
function isLogin(){
	session_start();
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	if($_SESSION['user_id']&&$_SESSION['username']&&$_SESSION['user_type']&&$_SESSION['fullname']&&
		($_SESSION['user_id']!=NULL)&&($_SESSION['username']!=NULL)&&($_SESSION['user_type']!=NULL)&&($_SESSION['fullname']!=NULL))
			return 1;
	else
		return 0;
}
//isUser() returns 1 if username and fullname exists before itself
function isUser($username){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$query=mysqli_query($connect,"SELECT*FROM user_info where username=\"".$username."\"") or die("cant connect");
	while($row=mysqli_fetch_array($query)){
		if($row['username']==$username)
			return 1;
	}
	return 0;
}
//get_id gets id of anything arguments: table_name,column_name,column_value
function get_id($table_name,$column_name,$column_value){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$query=mysqli_query($connect,"select*from ".$table_name." where ".$column_name."=\"".$column_value."\"") or die("cant get id");
	while($row=mysqli_fetch_array($query))
		if($row[$column_name]==$column_value)
			return $row['id'];
}
function get_url(){
	return (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
}
//returns 1 if the current user is teacher,returns 0 not a teacher
function isTeacher(){
	session_start();
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$query=mysqli_query($connect,"SELECT*FROM user_info where username=\"".$_SESSION['username']."\"") or die("cant connect");
	while($row=mysqli_fetch_array($query))
		if($row['account_type']=="teaching_staff")
			return 1;
		else
			return 0;
}
//returns teachers table id(teacher_info)_id(teacher's user_info)_(teacher_name)
function get_teacher_table(){
	return get_id('teacher_info','username',$_SESSION['username'])."_".get_id('user_info','username',$_SESSION['username'])."_".$_SESSION['username'];
}
//if both student_list and course_code matches it returns that table else preference is given to student_list
function get_student_table($student_list,$course_code){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$query=mysqli_query($connect,"select table_name from ".get_teacher_table());
	while($row=mysqli_fetch_array($query)){
		$temp_table=explode("_",$row['table_name']);
		if(($temp_table[3]==$student_list)&&($temp_table[5]==$course_code))
			return $row['table_name'];
	}
	while($row=mysqli_fetch_array($query)){
		$temp_table=explode("_",$row['table_name']);
		if($temp_table[3]==$student_list)
			return $row['table_name'];
	}
	return "error";
}
//returns from a string and option:
/*0-id(teacher_info)
 * 1-id(teacher's user_info)
 * 2-id(teacher's name)
 * 3-class_name
 * 4-class_strength
 * 5-course_code
 * */
function get_from_student_table($table_name,$option){
		$temp=explode("_",$table_name);
		return $temp[$option];
}	
//secures string against sql inj
function secure_string($string){
	$string=htmlentities($string,ENT_QUOTES);
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$string=mysqli_real_escape_string($connect,$string);
	return $string;
}
//marks string is like 45_quiz1:20:10_quiz2:10:10_midsem:50:20
function max_marks($table_name){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$query=mysqli_query($connect,"select *from ".$table_name." where student_name='default'");
	while($row=mysqli_fetch_array($query)){
		$temp=explode("_",$row['total_marks']);
		return $temp[0];
	}
}
//returns max marks in each sub tests
function get_marks($table_name,$string){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$query=mysqli_query($connect,"select *from ".$table_name." where student_name='default'");
	while($row=mysqli_fetch_array($query)){
		$all_marks=explode("_",$row['total_marks']);
		$i=1;
		while($all_marks[$i]){
			$temp=explode(":",$all_marks[$i]);
			if($string==$temp[0])
				return $temp[1];
		}
	}
}
?>
