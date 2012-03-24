<style type="text/css">
	table.tab h4 {
	font-size: 10px;
	font-weight: normal;
	color: #999;
	margin: 2px 0 3px 0;
	width: 85%;
	padding: 0;
}
</style>
<?
/* Functions implemented
 * get_list_dropbox
 * new_student_list
 * add_new_student
 * TODO view_student_list
 * TODO edit_student_list
 * update_student_list
 * update_attendance
 * view_marks
 * update_marks_list
 * update_marks
 * get_max($string)
 */
function get_list_dropbox(){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	if(isTeacher()){
		?>
		<select name='student_list_dropdown' id='student_list_dropdown' onchange='update_list_url();'>
		<option value='-1'>Select students list</option>
		<?
		$query=mysqli_query($connect,"select table_name from ".get_teacher_table())or die("cant connect");
		while($row=mysqli_fetch_array($query)){
			$student_list=explode("_",$row['table_name']);
			echo "<option value='".$student_list[3]."'>".$student_list[3]."</option>";
		}
		
		echo "</select><br><br>";
		?>
		<select name='course_code_dropdown' id='course_code_dropdown' onchange='update_list_url();'>
		<option value='-1'>Select course code</option>
		<?
		$query=mysqli_query($connect,"select table_name from ".get_teacher_table())or die("cant connect");
		while($row=mysqli_fetch_array($query)){
			$student_list=explode("_",$row['table_name']);
			echo "<option value='".$student_list[5]."'>".$student_list[5]."</option>";
		}
		echo "</select><br><br>";
	}
}
function new_student_list(){
	if($_GET['table_name']&&$_GET['description']){
		session_start();
		$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
		$table_name=secure_string($_GET['table_name']);
		$description=secure_string($_GET['description']);
		$class_strength=secure_string($_GET['strength']);
		$course_code=secure_string($_GET['course_code']);
		$table_name=get_teacher_table()."".get_id(get_teacher_table(),'table_name',$table_name)."_".$table_name;
		$query=mysqli_query($connect,"insert into ".get_teacher_table()." (table_name,description) values('".$table_name."','".$description."')") or die("cant add to teacher's list");
		//create a table id(teacher_info)_id(teacher's user_info)_(teacher_name)_id(student list in teacher's table)_(class_name)_(class_strength)_(course_code)
		/*0-id(teacher_info)
		 * 1-id(teacher's user_info)
		 * 2-id(teacher's name)
		 * 3-class_name
		 * 4-class_strength
		 * 5-course_code
		 * */
		$query=mysqli_query($connect,"create table ".$table_name."(
										id int primary key,
										student_name varchar(60),
										rollno varchar(30),
										total_attendance varchar(30),
										total_marks varchar(100))") or die("cant create table");
		$query=mysqli_query($connect,"insert into ".$table_name." (id,student_name,total_attendance,total_marks) values('0','default','0','0')");
		$i=1;
		while($i<=get_from_student_table($table_name,4)){
			$query=mysqli_query($connect,"insert into ".$table_name." (id,total_attendance,total_marks) values('".$i."',0,0)");
			$i++;
		}
		header("Location:http://localhost/project_IT/data.php?action=edit_student_list");
	}
	else{
?>
		<script type="text/javascript">
			function update_url(){
				var table_name=document.getElementById("class_name").value+"_"
								+document.getElementById("class_strength").value+"_"
								+document.getElementById("course_code").value;
				//table_name = (class_name)_(class_strength)_(course_code)
				var discription=document.getElementById("description").value;
				document.getElementById("submit").href="http://localhost/project_IT/data.php?action=new_student_list"+"&table_name="+table_name+"&description="+discription;
			}
		</script>
	<h1 class="title" style="border-bottom: 1px solid black;">New student List</h1>
			<div class="tab">
				<h3>class <strong>name</strong></h3>
        		<input class="big" id="class_name" name="class_name" size="15" type="text" onkeyup="update_url();"/>
        
				<h3 class="group">class <strong>strength</strong></h3>
				<input class="big" id="class_strength" name="class_strength" size="15" type="text" onkeyup="update_url();"/>
				
				<h3 class="group">course <strong>code</strong></h3>
				<input class="big" id="course_code" name="course_code" size="20" type="text" onkeyup="update_url();"/>
				
				<h3 class="group">Description</h3>
				<input class="big" id="description" name="description" size="20" type="text" onkeyup="update_url();"/><br>
		<p><a href="localhost/project_IT?action=new_student_list" id="submit"><input value="Make Table" type="button" onclick="update_url();"></a></p>
	</div>
<? }
}


function edit_student_list(){
	if(isTeacher()&&$_GET['student_list']&&$_GET['course_code']){
		$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
		$student_list=secure_string($_GET['student_list']);
		$course_code=secure_string($_GET['course_code']);
		$student_list=get_student_table($student_list,$course_code);
		?>
		<table style="border-spacing:20px 2px;">
			<tr>
				<td> <strong><h3>Teacher:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,2);?></h3></td>
			</tr>
			<tr>
				<td> <strong><h3>Class Name:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,3);?></h3></td>
			</tr>
			<tr>
				<td> <strong><h3>Class Strength:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,4);?></h3></td>
			</tr>
			<tr>
				<td> <strong><h3>Course Code:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,5);?></h3></td>
			</tr>
			<tr>
				<td><br><strong>Total Classes:</strong></td>
				<td>
					<?
					$query=mysqli_query($connect,"select * from ".$student_list." where student_name='default'") or die("cant get max");
					while($row=mysqli_fetch_array($query))
						echo "<br>".$row['total_attendance'];
					?>
				</td>
			</tr>
			<tr>
				<td><br><strong>IMP</strong> update before adding new students<br></td>
			</tr>
			<tr>
				<td>
					<strong>Enter the number of students to be added here</strong>
				</td>
				<td>
					<form method="POST" action="http://localhost/project_IT/data.php?action=add_new_student">
					<input type="text" name="new_student" id="new_student" class="big" size="3">
					<input type="hidden" value=<? echo $student_list; ?> name="table">
					&nbsp&nbsp<input type="submit" value="Make new students">
					</form>
				</td>
			</tr>
		</table>
		<h1 style="border-bottom:3px black solid"></h1>
		<form method="POST" action="http://localhost/project_IT/data.php?action=update_student_list">
			<table style="border-spacing:10px 5px;">
				<tr>
					<th> Sl no.</th>
					<th>Register no.</th>
					<th>Student Name</th>
					<th>Attendence</th>
					<th>Total Marks</th>
				</tr>
				
		<?  $connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
			$i=get_from_student_table($student_list,4);
			$query=mysqli_query($connect,"select*from ".$student_list." order by id ASC");
				while($row=mysqli_fetch_array($query)){
					if($row['id']!=0){
						$temp=explode("_",$row['total_marks']);
						echo "<tr><td>".$row['id']."</td>";
						echo "<td><input type='text' class='big' size='5' value='".$row['rollno']."' id='rollno_".$row['id']."' name='rollno_".$row['id']."'></td>";
						echo "<td><input type='text' class='big'  value='".$row['student_name']."' id='student_name_".$row['id']."' name='student_name_".$row['id']."'></td>";
						echo "<td>".$row['total_attendance']."</td>";
						echo "<td>".$temp[0]."</td></tr>";
					}
				}
		?>
		<input type="hidden" value="<? echo $student_list;?>" name="table">
		</table>
		&nbsp&nbsp&nbsp&nbsp<input type="submit" value="update">
		</form>
		<h1 style="border-bottom:3px black solid"></h1>
		<?
	}
}
function update_student_list(){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$student_list=secure_string($_POST['table']);
	$class_strength=get_from_student_table($student_list,4);
	$i=$class_strength;
	while($i>0){
		$temp=$class_strength+1-$i;
		$query2=mysqli_query($connect,"update ".$student_list." set rollno=\"".secure_string($_POST['rollno_'.$i])."\" where id=\"".$i."\"");
		$query2=mysqli_query($connect,"update ".$student_list." set student_name=\"".secure_string($_POST['student_name_'.$i])."\" where id=\"".$i."\"");
		$i--;
	}
	header("Location:http://localhost/project_IT/data.php?action=edit_student_list&student_list=".get_from_student_table($student_list,3)."&course_code=".get_from_student_table($student_list,5));
}
function add_new_student(){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$table_name=secure_string($_POST['table']);
	$number=secure_string($_POST['new_student']);
	$query=mysqli_query($connect,"select id from ".$table_name);
	$i=-1;
	while($row=mysqli_fetch_array($query)){
		$i++;
	}
	while($number>0){
		$i++;
		$query=mysqli_query($connect,"insert into ".$table_name." (id,total_attendance,total_marks) values('".$i."',0,0)");
		$number--;
	}
	//write a code to update add class strengths
	$table_old=$table_name;
	$table_name=explode("_",$table_name);
	$table_new=$table_name[0]."_".$table_name[1]."_".$table_name[2]."_".$table_name[3]."_".$i."_".$table_name[5];
	//echo "update ".get_teacher_table()." set table_name=\"".$table_new."\" where id=\"".get_id(get_teacher_table(),'table_name' ,$table_old)."\"";
	$query=mysqli_query($connect,"rename table ".$table_old." to ".$table_new) or die("cant rename");
	$query=mysqli_query($connect,"update ".get_teacher_table()." set table_name=\"".$table_new."\" where id=\"".get_id(get_teacher_table(),'table_name' ,$table_old)."\"") or die ("cant update teachers table"); 
	header("Location:http://localhost/project_IT/data.php?action=edit_student_list&student_list=".get_from_student_table($table_new,3)."&course_code=".get_from_student_table($table_new,5));
}
function view_attendance(){
	if(isTeacher()&&$_GET['student_list']&&$_GET['course_code']){
		$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
		$student_list=secure_string($_GET['student_list']);
		$course_code=secure_string($_GET['course_code']);
		$student_list=get_student_table($student_list,$course_code);
		?>
		<table style="border-spacing:20px 2px;">
			<tr>
				<td> <strong><h3>Teacher:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,2);?></h3></td>
			</tr>
			<tr>
				<td> <strong><h3>Class Name:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,3);?></h3></td>
			</tr>
			<tr>
				<td> <strong><h3>Class Strength:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,4);?></h3></td>
			</tr>
			<tr>
				<td> <strong><h3>Course Code:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,5);?></h3></td>
			</tr>
			<tr>
				<td><br><strong>Total Classes:</strong></td>
				<td>
					<?
					$query=mysqli_query($connect,"select * from ".$student_list." where student_name='default'") or die("cant get max");
					while($row=mysqli_fetch_array($query))
						echo "<br>".$row['total_attendance'];
					?>
				</td>
			</tr>
			<tr>
				<td> <br><strong>IMP default</strong> should be used to set the maximum</td>
			</tr>
		</table>
		<h1 style="border-bottom:3px black solid"></h1>
		<form method="POST" action="http://localhost/project_IT/data.php?action=update_attendance">
			<table style="border-spacing:10px 5px;">
				<tr>
					<th> Sl no.</th>
					<th>Register no.</th>
					<th>Student Name</th>
					<th>Attendence</th>
					<th>P/A</th>
					<th>Multiplier</th>
				</tr>
				
		<?  $connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
			$i=get_from_student_table($student_list,4);
			$query=mysqli_query($connect,"select*from ".$student_list." order by id ASC");
				$i=0;
				while($row=mysqli_fetch_array($query)){
					echo "<tr><td>".$i."</td>";
					echo "<td>".$row['rollno']."</td>";
					echo "<td>".$row['student_name']."</td>";
					echo "<td>".$row['total_attendance']."</td>";
					echo "<td><input type='checkbox' checked='checked' value='selected' name='P/A_".$i."' id='P/A_".$i."'</td>";
					echo "<td><input type='text' class='big' value='1' size='3' id='multiplier_".$i."' name='multiplier_".$i."'></td></tr>";
					$i++;
				}
		?>
		<input type="hidden" value="<? echo $student_list;?>" name="table">
		</table>
		&nbsp&nbsp&nbsp&nbsp<input type="submit" value="update">
		</form>
		<h1 style="border-bottom:3px black solid"></h1>
		<?
	}
}
function update_attendance(){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$table_name=secure_string($_POST['table']);
	$class_strength=get_from_student_table($table_name,4);
	$i=$class_strength+1;
		while($i>=0){
		if($_POST['P/A_'.$i]){
			$query=mysqli_query($connect,"select*from ".$table_name." where id=\"".$i."\"");
			while($row=mysqli_fetch_array($query))
				$attendance=$row['total_attendance'];
			$attendance=(secure_string($_POST['multiplier_'.$i]))+($attendance);
			$query2=mysqli_query($connect,"update ".$table_name." set total_attendance=\"".$attendance."\" where id=\"".$i."\"");
		}
		$i--;
	}
	header("Location:http://localhost/project_IT/data.php?action=view_attendance&student_list=".get_from_student_table($table_name,3)."&course_code=".get_from_student_table($table_name,5));
}
function view_marks(){
	if(isTeacher()&&$_GET['student_list']&&$_GET['course_code']){
		$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
		$student_list=secure_string($_GET['student_list']);
		$course_code=secure_string($_GET['course_code']);
		$student_list=get_student_table($student_list,$course_code);
		?>
		<table style="border-spacing:20px 2px;">
			<tr>
				<td> <strong><h3>Teacher:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,2);?></h3></td>
			</tr>
			<tr>
				<td> <strong><h3>Class Name:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,3);?></h3></td>
			</tr>
			<tr>
				<td> <strong><h3>Class Strength:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,4);?></h3></td>
			</tr>
			<tr>
				<td> <strong><h3>Course Code:</h3></strong></td><td><h3><? echo get_from_student_table($student_list,5);?></h3></td>
			</tr>
			<tr>
				<td><br><strong>Total Classes:</strong></td>
				<td>
					<?
					$query=mysqli_query($connect,"select * from ".$student_list." where student_name='default'") or die("cant get max");
					while($row=mysqli_fetch_array($query))
						echo "<br>".$row['total_attendance'];
					?>
				</td>
			</tr>
			<tr>
				<td><br><strong>Max marks</strong></td>
				<td><? echo "<br>".max_marks($student_list);?></td>
			</tr>
		</table>
		<h1 style="border-bottom:3px black solid"></h1>
			<table style="border-spacing:10px 5px;">
				<tr>
					<th>Reg no.</th>
					<th>Name</th>
					<?
					$query=mysqli_query($connect,"select *from ".$student_list." where student_name='default'");
					while($row=mysqli_fetch_array($query)){
						$all_marks=explode("_",$row['total_marks']);
						$i=1;
						while($all_marks[$i]){
							$temp=explode(":",$all_marks[$i]);
							echo "<th>".$temp[0]."</th>";
							$i++;
						}
					}
					?>
					<th>Total</th>
				</tr>
				<script type="text/javascript">
				function update_individual_total_marks(){
					var max_cols=parseInt(document.getElementById("count_value").value);
					var max_rows=parseInt(document.getElementById("max_rows").value);
					var i;
					var output="";
					var total_marks=0;
					for(var k=1;k<=max_rows;k++){
						i=1;
						output="";
						total_marks=0;
						while(i<max_cols){
							output=output+"_"+document.getElementById("individual_subj_"+k+"_"+i).value+":"+document.getElementById("individual_max_"+k+"_"+i).value+":"+document.getElementById(k+"_"+i).value;
							total_marks=total_marks+(parseInt(document.getElementById("percent_"+i).value)*parseInt(document.getElementById(k+"_"+i).value))/parseInt(document.getElementById("individual_max_"+k+"_"+i).value);
							i++;
						}
						document.getElementById("individual_total_marks_"+k).value=""+total_marks+output;
						//alert(document.getElementById("individual_total_marks_"+k).value);
					}
				}
				</script>
				<form method="POST" action="http://localhost/project_IT/data.php?action=update_marks">
		<?  $i=get_from_student_table($student_list,4);
			$query=mysqli_query($connect,"select*from ".$student_list." order by id ASC");
				$i=0;
				while($row=mysqli_fetch_array($query)){
					if($row['student_name']!="default"){
						echo "<td>".$row['rollno']."</td>";
						echo "<td>".$row['student_name']."</td>";
						$query2=mysqli_query($connect,"select *from ".$student_list." where id='".$row['id']."'");
						while($row2=mysqli_fetch_array($query2)){
							$all_marks=explode("_",$row2['total_marks']);
							$j=1;
							while($all_marks[$j]){
								$temp=explode(":",$all_marks[$j]);
								echo "<td><input type='text' class='big' size='3' onkeyup='update_individual_total_marks();'value='".$temp[2]."'id='".$row['id']."_$j' name='".$row['id']."_$j'></td>";
								echo "<input type='hidden' id='individual_subj_".$row['id']."_$j' name='individual_subj_$j' value='".$temp[0]."'>";
								echo "<input type='hidden' id='individual_max_".$row['id']."_$j' name='individual_subj_$j' value='".$temp[1]."'>";
								$j++;
							}
						}
						echo "<input type='hidden' id='individual_total_marks_".$row['id']."' name='individual_total_marks_".$row['id']."'>";
						//echo "<input type='hidden' id='individual_total_marks_'".$row['id']."' name='individual_total_marks_'".$row['id']."'>";
						echo "<td><strong>".$all_marks[0]."</strong></td></tr>";
						$i++;
					}
					$max_rows=$row['id'];
				}
		?>
		<input type='hidden' value="<? echo $max_rows;?>" name="max_rows" id="max_rows">
		<input type="hidden" value="<? echo $student_list;?>" name="table">
		</table>
		<input type="submit" value="update marks">
		</form>
		<h1 style="border-bottom:3px black solid"></h1>
		<h2><strong>update marks before creating or changing marks list</strong></h2><br>
		
		<script type="text/javascript">
			function js_update_marks_list(){
				var j=parseInt(document.getElementById("count_value").value);
				var output="";
				var total_marks=0;
				var i=1;
				while(i<=j){
					if((document.getElementById("test_"+i).value.length>0)&&(document.getElementById("max_"+i).value.length>0)&&(document.getElementById("percent_"+i).value.length>0)){
						output=output+"_"+document.getElementById("test_"+i).value+":"+document.getElementById("max_"+i).value+":"+document.getElementById("percent_"+i).value;
						total_marks=total_marks+parseInt(document.getElementById("percent_"+i).value);
					}
					i++;
				}
				document.getElementById("total_marks_string").value=""+total_marks+output;
			}
			window.onload=js_update_marks_list;
			window.onload=update_individual_total_marks;
		</script>
		<form method="POST" action="http://localhost/project_IT/data.php?action=update_marks_list">
		<table>
		<?
		$query=mysqli_query($connect,"select *from ".$student_list." where student_name='default'");
					while($row=mysqli_fetch_array($query)){
						$all_marks=explode("_",$row['total_marks']);
						$i=1;
						while($all_marks[$i]){
							$temp=explode(":",$all_marks[$i]);
							echo "<tr><td><strong>Test</strong></td><td><input type='text' onkeyup='js_update_marks_list();'class='big' id='test_".$i."'name='test_".$i."' value='".$temp[0]."'</td></tr><tr>";
							echo "<tr><td>Max marks</td><td><input type='text' onkeyup='js_update_marks_list();'class='big' id='max_".$i."'name='max_".$i."' value='".$temp[1]."'</td></tr><tr>";
							echo "<td>Percentage</td><td><input type='text' onkeyup='js_update_marks_list();'class='big' id='percent_".$i."'name='percent_".$i."' value='".$temp[2]."'</td></tr>";
							echo "<tr><td><h1 style='border-bottom:3px black solid'></h1></td><td><h1 style='border-bottom:3px black solid'></h1></td></tr>";
							$i++;
						}
					}
					echo "<tr><td><strong>Add New marks List</strong></td></tr>";
					echo "<tr><td><strong>Test</strong></td><td><input type='text' onkeyup='js_update_marks_list();'class='big' id='test_".$i."'name='test_".$i."'></td></tr><tr>";
					echo "<tr><td>Max marks</td><td><input type='text' onkeyup='js_update_marks_list();'class='big' id='max_".$i."'name='max_".$i."'> </td></tr><tr>";
					echo "<td>Percentage</td><td><input type='text' onkeyup='js_update_marks_list();'class='big' id='percent_".$i."'name='percent_".$i."'</td></tr>";
					echo "<tr><td><h1 style='border-bottom:3px black solid'></h1></td><td><h1 style='border-bottom:3px black solid'></h1></td></tr>";
		?>
		</table>
		<input type="hidden" value="<? echo $i;?>" id="count_value" name="count_value">
		<input type="hidden" value="<? echo $student_list;?>" name="table">
		<input type="hidden" name="total_marks_string" id="total_marks_string">
		<input type="submit" value="update marks list">
		<h1 style="border-bottom:3px black solid"></h1>
		</form>
		<?
	}
}
function update_marks_list(){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	if(secure_string($_POST['total_marks_string'])){
	$query=mysqli_query($connect,"update ".secure_string($_POST['table'])." set total_marks=\"".secure_string($_POST['total_marks_string'])."\" where student_name='default'");
	$count=secure_string($_POST['count_value']);
	$query=mysqli_query($connect,"select* from ".secure_string($_POST['table']." order by id ASC"));
	$blue=explode("_",secure_string($_POST['total_marks_string']));
	while($row=mysqli_fetch_array($query)){
		$string="";
		$max=0;
		if($row['student_name']!="default"){
			$total_max=explode("_",$row['total_marks']);
			$k=1;
			while($blue[$k]){
				$temp1=explode(":",$blue[$k]);
				$temp2=explode(":",$total_max[$k]);
				if(!$temp2[2])
					$temp2[2]=0;
				$string=$string."_".$temp1[0].":".$temp1[1].":".$temp2[2];
				$max+=($temp2[1]/$temp1[1])*$temp2[2];
				$k++;
			}
			$string=$max."".$string;
			//echo "update ".secure_string($_POST['table'])." set total_marks=\"".$string."\" where id='".$row['id']."'<br>";
			$query2=mysqli_query($connect,"update ".secure_string($_POST['table'])." set total_marks=\"".$string."\" where id='".$row['id']."'") or die("cant do");
		}
	}
	}
	header("Location:http://localhost/project_IT/data.php?action=view_marks&student_list=".get_from_student_table(secure_string($_POST['table']),3)."&course_code=".get_from_student_table(secure_string($_POST['table']),5));
}
function update_marks(){
	$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
	$student_list=secure_string($_POST['table']);
	$query=mysqli_query($connect,"select id from ".$student_list." order by id ASC") or die("cant connect");
	while($row=mysqli_fetch_array($query)){
		if($row['id']!="0"){
			$max=secure_string($_POST["individual_total_marks_".$row['id']]);
			//echo 'individual_total_marks_'.$row['id'];
			//echo $max."<br>";
			$query2=mysqli_query($connect,"update ".$student_list." set total_marks='".$max."' where id='".$row['id']."'")or die("cant update");
		}
	}
	header("Location:http://localhost/project_IT/data.php?action=view_marks&student_list=".get_from_student_table($student_list,3)."&course_code=".get_from_student_table($student_list,5));
}
?>
