<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>

<head>
<h1>Leaf Tree</h1>
<link rel="stylesheet" type="text/css" href="/style/css/mystyle.css">

</head>
<body>
<?php
$root = '.';
include_once $root.'/../include/header.php';
?>
	<a href="/">login</a>


		<div class="login">
		
			<form action="login.php" method="POST">
				<ul>
					<li>
						<input type="text" name="email" value="ID" onfocus="if(this.value =='ID') this.value=''" onblur="if(this.value =='') this.value='ID';">
					</li>
					<li>
						<input type="text" name="password" value="password" onfocus="if(this.value =='password') { this.value=''; this.type='password'; }" onblur="if(this.value =='') { this.value='password'; this.type='text'; }">
					</li>
				</ul>
				<ul>
					<li>
						<input type="submit" value="login">
					</li>
				</ul>
			</form>

		</div>

	<a href="/register_form.php">register</a>

</body>
</html>