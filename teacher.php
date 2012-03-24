<?
include("scripts/basicfunctions.php");
include("includes/header.inc.php");
?>
<hr />
<div id="latest-post-wrap">
<div id="latest-post" class="post">
	<p class="byline"><span>A web based data management tool</a></span></p>
	<h1 class="title">List of all Teachers</h1>
	<div class="entry">
		<?
			$connect=mysqli_connect("localhost","root","alse","project_IT") or die("cant connect");
			$query=mysqli_query($connect,"select*from teacher_info");
			$i=1;
		?>
			<table>
				<tr>
					<th><h2>Sl no.</h2></th>
					<th><h2>Teaching staff</h2></th>
				</tr>
		<?		while($row=mysqli_fetch_array($query)){
					echo "<tr><td><h2>$i.</h2></td>";
					echo "<td><h2>".$row['fullname']."</h2></td></tr>";
					$i++;
				}
		?>
			</table>
	</div>
</div>
</div>
<hr />
<? include("includes/footer.inc.php"); ?>
</body>
</html>
