
function login_func()
{
		var uname=document.getElementById("username").value;
		var pwd=document.getElementById("inputPassword").value;
		$.ajax(
	      {
	        url: "login.php",
	        type:"post",
	        dataType:"json",
	        data:
	        {
	        	uname:uname,
	            pwd:pwd
	        },

	        success: function(json)
	        {
	            //alert("SUCCESS");
	            //alert(json.status);
	            if(json.status == 1)
	            {
	              	location.href="newtrip.php";
	            }
	            else if(json.status==2)
	            {
	            	document.getElementById("wrong-user").hidden = false;
					document.getElementById("wrong-user").innerHTML="Wrong username or password";
					document.getElementById("username").value="";
					document.getElementById("inputPassword").value="";
	            }

	        },

	        error : function()
	        {
	          alert("ERROR");
	          //console.log("something went wrong");
	        }
	      });
}
function signup()
{
	var name=document.getElementById("entername").value;
	var uname=document.getElementById("enterusername").value;
	var email=document.getElementById("enterEmail").value;
	var pass=document.getElementById("enterPassword").value;
	//console.log(cntact.match(patcontact));
	var ev = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    var x= ev.test(email);
    var cv=/^\d+$/;
    if(x==false)
    {
    	alert("Invalid Email");
    	document.getElementById("enterEmail").value="";
    }
    else
    {
		 $.ajax(
	      {
	        url: "signup.php",
	        type:"post",
	        dataType:"json",
	        async: false,
	        data:
	        {
	        	name:name,
	        	email:email,
	            uname:uname,
	            pass:pass
	        },

	        success: function(json)
	        {
	        	console.log(json.status);
	        	if(json.status==2)
	        	{
	        		location.href="newtrip.php";
	        	}
	        	else if(json.status==0)
	            {
	            	document.getElementById("wrong-new-user").hidden = false;
					document.getElementById("wrong-new-user").innerHTML="Username already taken.";
					document.getElementById("enterusername").value="";
	            }
	            else if(json.status==1)
	            {
	            	document.getElementById("wrong-new-email").hidden = false;
					document.getElementById("wrong-new-email").innerHTML="Email already taken";
					document.getElementById("enterEmail").value="";
	            }
	           	
	        },

	        error : function()
	        {
	          alert("ERROR");
	          //console.log("something went wrong");
	        }
	      });
		
	}
}
