<?php
session_start();

//Create a session of username and logging in the user to the chat room
if(isset($_POST['username'])){
	$_SESSION['username']=$_POST['username'];
}

//Unset session and logging out user from the chat room
if(isset($_GET['logout'])){
	unset($_SESSION['username']);
	header('Location:index.php');
}

?>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CLASS ROOM</title>
	<link href="css/bootstrap.min.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/style.css" />
	<script type="text/javascript" src="js/jquery-1.10.2.min.js" ></script>
	<meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />
<link rel="stylesheet" type="text/css" href="table_style.css">
<style>
* {box-sizing: border-box;}

body { 
  margin: 0;
  font-family: Arial, Helvetica, sans-serif;
}


    @font-face {
  font-family: J;
  src: url(j.ttf);
}

@font-face {
  font-family: J;
  src: url(j.ttf);
  font-weight: bold;
}
   body {
        position: absolute;
        top: 0; bottom: 0; left: 0; right: 0;
        height: 100%;
    }
    body:before {
        content: "";
        position: absolute;
        height: 20%; width: 20%;
        background: url(juve2.jpg);
        background-size: cover;
        z-index: -1; /* Keep the background behind the content */
        
        /* don't forget to use the prefixes you need */
        -webkit-transform: scale(5);
        -webkit-transform-origin: top left;
        -webkit-filter: blur(2px);
    }
    .button{
  background-color: green; /* Green */
  border: none;
  color: green;
  padding: 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
}
.button1 {padding: 10px 24px;
margin-top: 15px;
background-color: black;
color: white;
margin-left: 15px;
border-radius: 12px;
}
  }
body
{
  -webkit-filter: blur(5px); /* Safari 6.0 - 9.0 */
  filter: blur(5px);
 
}
.footer {
   position: fixed;
   left: 0;
   bottom: 0;
   width: 100%;
   size: 1px;
   color: black;
   text-align: center;
}
p{
    font-family: "J";
    font-size:90px;
}
h3
{
    font-family: "J";
    font-size: 60px;
    color: white;
}
p1{
    font-family: "J";
    color: white;

}
.button1 {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;

}
.button1 {border-radius: 50%;}
h1{
	font-family: "J";
	color: black;
}
</style>
</head>
<body>
<div class='header'>
	<h1>
		CLASSROOM
		<?php // Adding the logout link only for logged in users  ?>
		<?php if(isset($_SESSION['username'])) { ?>
			<a class='logout' href="?logout">Logout</a>
		<?php } ?>
	</h1>

</div>

<div class='main'>
<?php //Check if the user is logged in or not ?>
<?php if(isset($_SESSION['username'])) { ?>
<div id='result'></div>
<div class='chatcontrols'>
	<form method="post" onsubmit="return submitchat();">
	<input type='text' name='chat' id='chatbox' autocomplete="off" placeholder=" MESSAGES" />
	<input type='submit' name='send' id='send' class='btn btn-send' value='Send' />
	
</form>
<script>
// Javascript function to submit new chat entered by user
function submitchat(){
		if($('#chat').val()=='' || $('#chatbox').val()==' ') return false;
		$.ajax({
			url:'chat.php',
			data:{chat:$('#chatbox').val(),ajaxsend:true},
			method:'post',
			success:function(data){
				$('#result').html(data); // Get the chat records and add it to result div
				$('#chatbox').val(''); //Clear chat box after successful submition
				document.getElementById('result').scrollTop=document.getElementById('result').scrollHeight; // Bring the scrollbar to bottom of the chat resultbox in case of long chatbox
			}
		})
		return false;
};

// Function to continously check the some has submitted any new chat
setInterval(function(){
	$.ajax({
			url:'chat.php',
			data:{ajaxget:true},
			method:'post',
			success:function(data){
				$('#result').html(data);
			}
	})
},1000);

// Function to chat history
$(document).ready(function(){
	$('#clear').click(function(){
		if(!confirm('Are you sure you want to clear chat?'))
			return false;
		$.ajax({
			url:'chat.php',
			data:{username:"<?php echo $_SESSION['username'] ?>",ajaxclear:true},
			method:'post',
			success:function(data){
				$('#result').html(data);
			}
		})
	})
})
</script>
<?php } else { ?>
<div class='userscreen'>
	<form method="post">
		<input type='text' class='input-user' placeholder="ENTER YOUR NAME HERE" name='username' />
		<input type='submit' class='btn btn-user' value='START CHAT' />
	</form>
</div>
<?php } ?>

</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</body>
</div>
</html>