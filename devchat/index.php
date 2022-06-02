<?php
require_once("functions.php");
//require_once("wrapper.php");
if(!isset($_SESSION["id"])) session_start();
global $db;
$db = new mysqli("localhost", "root", "", "chat");
if(!isset($_SESSION['id']))
{
	header("Location: ./auth.php");
}
if(isset($_POST["getSessionId"]))
{
	$id = $_SESSION["id"];
	echo "$id";
}
if(isset($_POST["logout"]))
{
	$id = $_SESSION['id'];
	$req = $GLOBALS['db']->prepare("update `user` set status= 'offline' where id = '$id'");
	$req->execute();
	session_destroy();
	header("Location: ./auth.php");
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>MiniChat</title>
  <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700,300' rel='stylesheet' type='text/css'>

<script src="https://use.typekit.net/hoy3lrg.js"></script>
<script>try{Typekit.load({ async: true });}catch(e){}</script><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css'><link rel="stylesheet" href="./style.css">

</head>
<body>
<!-- partial:index.partial.html -->
<!-- 

A concept for a chat interface. 

Try writing a new message! :)


Follow me here:
Twitter: https://twitter.com/thatguyemil
Codepen: https://codepen.io/emilcarlsson/
Website: http://emilcarlsson.se/

-->

<div id="frame">
	<div id="sidepanel">
		<div id="profile">
			<div class="wrap">
				<?=getUser($_SESSION["id"])?>
			</div>
		</div>
		<div id="contacts">
				<?php drawAllContacts($_SESSION["id"]); ?>
		</div>
		<div id="bottom-bar">
			<form method="POST">
				<button id="addcontact" type="submit" name="logout"><i class="fa fa-sign-out fa-fw" aria-hidden="true"></i><span>Logout</span></button>
				<!--<button id="settings"><i class="fa fa-cog fa-fw" aria-hidden="true"></i> <span>Settings</span></button>!-->
			</form>
		</div>
	</div>
	<div class="content">
		<div class="contact-profile">
		</div>
		<div class="messages">
			<?php drawAllMessages($_SESSION["id"]); ?>
		</div>
		<div class="message-input">
			<div class="wrap">
			<input type="text" placeholder="Write your message..." />
			<form method="POST" enctype="multipart/form-data">
				<input type="file" name="uploadedFile" id="uploadedFile" style="display:none;"></input>
				<i class="fa fa-paperclip attachment" aria-hidden="true"></i>
			</form>
			<button class="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
			</div>
		</div>
	</div>
</div>
<div id="result">
	<!-- Результат из upload.php -->
</div>
<!-- partial -->
  <script src='https://code.jquery.com/jquery-2.2.4.min.js'></script><script  src="./script.js"></script>

</body>
</html>
