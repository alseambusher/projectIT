<?
include("scripts/basicfunctions.php");
include("includes/header.inc.php");
include("scripts/data_student.php");
include("scripts/data_student_student.php");
?>
<style type="text/css">
.button{
	margin-right: 6px;
	padding: 5px 20px 5px 20px;
	background: #4C4D51;
	border: 1px #575C5F solid;
	text-decoration: none;
	font-weight: bold;
	font-size: 11px;
	color: #FFFFFF;
}
.button:hover{
	color:white;
	text-decoration: none;
	background: #983D3A;
	border: 1px #D45951 solid;
}
</style>
<div id="latest-post-wrap">	
<div id="latest-post" class="post">
	<p class="byline"><span>A web based data management tool</a></span></p>
	<? echo "<h2 style='color:red'>".$_GET['error']."</h2>";?>
<?
if(isLogin()&&isTeacher()){
//LOGGED IN//////////////////////////////////////////////////////////////
	switch($_GET['action']){
		case "new_student_list": new_student_list();break;
		case "edit_student_list":edit_student_list();break;
		case "add_new_student":add_new_student();break;
		case "update_student_list":update_student_list();break;
		case "view_attendance":view_attendance();break;
		case "update_attendance":update_attendance();break;
		case "view_marks":view_marks();break;
		case "update_marks":update_marks();break;
		case "update_marks_list":update_marks_list();break;
	}
?>
<hr />
	<script type="text/javascript">
		function update_list_url(){
			var student_list=document.getElementById("student_list_dropdown").value;	
			var course_code=document.getElementById("course_code_dropdown").value;
			if((student_list!="-1")&&(course_code!="-1")){
				var defaults="http://localhost/project_IT/data.php?action=";
				document.getElementById("edit_student_list").setAttribute("href",defaults+"edit_student_list&student_list="+student_list+"&course_code="+course_code);
				document.getElementById("view_attendance").setAttribute("href",defaults+"view_attendance&student_list="+student_list+"&course_code="+course_code);
				document.getElementById("view_marks").setAttribute("href",defaults+"view_marks&student_list="+student_list+"&course_code="+course_code);
			}
		}
	</script>
	<? get_list_dropbox();?>
	<h2 style="border-bottom:1px solid black;" >Student List</h2><br>
	<a href="http://localhost/project_IT/data.php?action=new_student_list" class="button">CREATE A NEW STUDENT LIST</a>
	<a href="#" id="edit_student_list" class="button">EDIT STUDENT LIST</a><br><br>
	<h2 style="border-bottom:1px solid black;">Attendence and Marks</h2><br>
	<a href="#" id="view_attendance"class="button">VIEW ATTENDENCE</a>
	<a href="#" id="view_marks"class="button">VIEW MARKS</a>
</div>
</div>
<?}
//TEACHER ENDS HERE/////////////////////////////////////////////////////////
//else if(isLogin()){
	//switch($_GET['action']){
		//case "view_student_student_list":view_student_student_list();break;
	//}
//}
//LOGGED IN ENDS//////////////////////////////////////////////////////////////
else{
//NOT LOGGED IN//////////////////////////////////////////////////////////////
?>
<hr />
	<!-- update this part with images -->
	<img style="border:2px solid black;"src="images/Screenshot.png" alt="" width="350" height="250" />
	<img style="border:2px solid black;"src="images/Screenshot-1.png" alt="" width="350" height="250" />
	<p>This is where students get to see the data and teaching staff enter data of the students</p>
</div>
</div>
<? include("includes/recentpost.inc.php");?>
<? } 
//NOT LOGGED IN ENDS//////////////////////////////////////////////////////////////
?>
<hr />
<? include("includes/footer.inc.php"); ?>
</body>
</html>
