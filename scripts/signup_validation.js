function validation_username(){
			empty("new_account_username","user");
			pattern_check("new_account_username",/^\w*$/,"user");
			size_check("new_account_username","5","user");
			error_update();
		}
		function validation_fullname(){
			empty("new_account_name","full_user");
			error_update();
		}
		function validation_email(){
			empty("new_account_email_address","email");
			//pattern_check("new_account_email_address",/^\w+@\w+\.\w*$/,"email");
			pattern_check("new_account_email_address",/^([a-zA-Z0-9_.-])+@([a-zA-Z0-9_.-])+\.([a-zA-Z])+([a-zA-Z])+/,"email");
			error_update();
		}
		function validation_confirm_email(){
			empty("new_account_email_address_confirmation","email_again");
			if(document.getElementById("new_account_email_address").value!=document.getElementById("new_account_email_address_confirmation").value)
			document.getElementById("email_again").innerHTML="email doesnt match";
			else if(document.getElementById("email_again").innerHTML=="email doesnt match")
			document.getElementById("email_again").innerHTML="";
			error_update();
		}
		function validation_password(){
			empty("new_account_password","pass");
			size_check("new_account_password","6","pass");
			error_update();
		}
		function validation_confirm_password(){
			empty("new_account_password_confirmation","pass_confirm");
			if(document.getElementById("new_account_password").value!=document.getElementById("new_account_password_confirmation").value)
			document.getElementById("pass_confirm").innerHTML="passwords dont match";
			else if(document.getElementById("pass_confirm").innerHTML=="passwords dont match")
			document.getElementById("pass_confirm").innerHTML="";
			error_update();
		}
		function empty(id,error_id){
			document.getElementById(error_id).style.color="red";
			if(document.getElementById(id).value=="")
			document.getElementById(error_id).innerHTML="enter here";
			else if(document.getElementById(error_id).innerHTML=="enter here")
			document.getElementById(error_id).innerHTML="";
		}
		function pattern_check(id,pattern,error_id){
			if(!pattern.test(document.getElementById(id).value))
			document.getElementById(error_id).innerHTML="invalid";
			else if(document.getElementById(error_id).innerHTML=="invalid")
			document.getElementById(error_id).innerHTML="";
		}
		function size_check(id,size,error_id){
			if(document.getElementById(id).value.length<parseInt(size))
				document.getElementById(error_id).innerHTML="Enter a minimum of "+size+" characters";
			else if(document.getElementById(error_id).innerHTML=="Enter a minimum of "+size+" characters")
				document.getElementById(error_id).innerHTML="";
		}
		function error_update(){
			if((document.getElementById("user").innerHTML!="")||(document.getElementById("full_user").innerHTML!="")||(document.getElementById("email").innerHTML!="")||(document.getElementById("email_again").innerHTML!="")||(document.getElementById("pass").innerHTML!="")||(document.getElementById("pass_confirm").innerHTML!="")||document.getElementById("new_account_terms_of_service").checked!=true)
			document.getElementById("error_final").value="error"
			else
			document.getElementById("error_final").value="";
		}
