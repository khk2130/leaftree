<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/css/mystyle.css">
 <script type="text/JavaScript" src="../js/sha512.js"></script> 
 <script type="text/JavaScript" src="../js/check_form.js"></script> 
</head>
<body>
<div class="content">
<h1>가입할 회원 정보를 입력하시오</h1>
<form action="register.php" method="post">
	<table>
		<tr><td>ID:</td><td><input type="text" name="id"></td></tr>
		<tr><td>비번:</td><td><input type="text" name="password"></td></tr>
		<tr><td>비번확인:</td><td><input type="text" name="password2"></td></tr>
	</table>
	<input type="button" value="가입하기" onclick=
		"checkRegisterForm(this.form, this.form.id, this.form.password, this.form.password2);">
</form>
</div>
</body>
</html>