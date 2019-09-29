<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<title>Document</title>
<style type="text/css"> 
.in_search { 
border:1 none; 
color:#999999; 
float:left; 
font-size:14px; 
height:18px; 
line-height:18px; 
margin:3px 2px; 
width:253px; 
} 
</style> 

</head>
<body>
<!-- <input name="q" class="in_search" onfocus="if(this.value=='请输入你想要输入的内容'){this.value='';}" onblur="if(this.value==''){this.value='请输入你想要输入的内容';}" type="text" value="请输入你想要输入的内容"/>  -->
<form method="post" action="test10.php" enctype="multipart/form-data">
	<input type="file" id="fileupload" name="fileupload[]"><br>
	<input type="file" id="fileupload" name="fileupload[]"><br>
	<input type="file" id="fileupload" name="fileupload[]"><br>
	<input type="file" id="fileupload" name="fileupload[]"><br>
	<input type="file" id="fileupload" name="fileupload[]"><br>
	<input type="file" id="fileupload" name="fileupload[]"><br>
	<input type="file" id="fileupload" name="fileupload[]"><br>
	<input type="file" id="fileupload" name="fileupload[]"><br>
	<input type="file" id="fileupload" name="fileupload[]"><br>
	<input type="file" id="fileupload" name="fileupload[]"><br>
	<input type="submit" name="submit" value="提交">
</form>
</body>
</html>


<?php
	require 'upload.php';
	$uploadFileClass = new FileUpload(52428800, array('.mp4'), '.');
	if ($_POST) {
		if ($_POST['submit']) {
			echo "<pre>";
			$file = $_FILES["fileupload"];
			// var_dump($file);
			var_dump($uploadFileClass->upload($file));
			die;
		}
	}
?>