<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<title>Data@nitk</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="css/style.css" rel="stylesheet" type="text/css" media="screen" />
<link href="css/dropdown_menu	.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="scripts/dropdown_menu.js"></script>
<script type="text/javascript">
	function login_window(){
		if(document.getElementById("login_window").style.visibility=="hidden"){
			document.getElementById("login_window").style.visibility="visible";
			document.getElementById("login_window").style.height="40px";
		}
		else{
			document.getElementById("login_window").style.visibility="hidden";
			document.getElementById("login_window").style.height="0px";
		}
	}
	function login_window_core(element,defaultname){
		if(document.getElementById(element).value==defaultname)
			document.getElementById(element).value="";
		if(document.getElementById(element).value=="")
			document.getElementById(element).value=defaultname;
	}
	function page_navigator(){
		var current_url=window.location.href;
		var all_url=new Array();
		all_url[0]="http://localhost/project_IT/index.php";
		all_url[1]="http://localhost/project_IT/data.php";
		all_url[2]="http://localhost/project_IT/calculus.php";
		all_url[3]="http://localhost/project_IT/contact.php";
		all_url[4]="http://localhost/project_IT/signup.php";
		all_url[5]="http://localhost/project_IT/account.php";
		var i=parseInt("0");
		for(i=0;i<6;i++)
			if(all_url[i]==current_url)
				document.getElementById("nav_"+i).setAttribute("class", "first");
			else
				document.getElementById("nav_"+i).setAttribute("class", "");
	}
	//find another way for page navigator
	window.onload=page_navigator;
</script>
</head>
<body>
<div id="header">
<div id="logo">
	<h1>DATA@NITK</h1>
</div>
</div>
<div id="menu-wrap">
<div id="menu">
	<ul id="new_menu">
		<li id="nav_0" ><a href="index.php" accesskey="1" title="">_HOME</a></li>
		<li id="nav_1"><a href="data.php" accesskey="2" title="">_DATA</a></li>
		<li id="nav_2"><a href="#" accesskey="3" title="">_CALCULUS</a></li>
		<? if(isLogin()) { ?>
		<li id="nav_2"><a href="teacher.php" accesskey="3" title="">_TEACHERS</a></li>
		<? } ?>
		
		<li id="nav_3"><a href="contact.php" accesskey="5" title="">_CONTACT</a></li>
		
		<?php if(!isLogin()){ ?>
		<li id="nav_4"><a href="signup.php">_SIGNUP</a></li>
		<li><a onclick="login_window();" style="cursor:pointer;">_LOGIN</a></li>
		<?php } else { ?>
		<li id="nav_5"><a href="#" accesskey="5" title="">_ACCOUNT</a></li>
        <li id="nav_6"><a href="scripts/basicfunctions_remote.php?action=logout" accesskey="5" title="">LOGOUT</a></li>
		<?php }?>
	</ul>
	</div>
</div>
</div>
<div style="clear:both"></div>



<div id="content">
	<div id="login_window" <? if(!$_GET['login_error']) {?>style="visibility:hidden;height:0px"<?}?>>
	<form method="POST" action="scripts/basicfunctions_remote.php?action=login">
		<center>
			<input class="big" type="text" id="login_username" name="login_username" value="uname" />&nbsp &nbsp
			<input class="big" type="password" id="login_password" name="login_password" value="password"/>&nbsp &nbsp
			<input type="hidden" value="<?php echo get_url(); ?>" name="url">
			<input type="submit" value="Login">
		</center>
	</form>
	<? 
	echo "<h3 style='color:red;'>".$_GET['login_error']."</h3>";?>
	</div>
</div>
