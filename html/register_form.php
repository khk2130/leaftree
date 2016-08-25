<!DOCTYPE HTML>
<html>
<head>

</head>
<body>
<?php
	$hostname = 'kocia.cytzyor3ndjk.ap-northeast-2.rds.amazonaws.com';
	$username = 'kimhyekwan';
	$password = 'password';
	$dbname = 'leaftree';
	
	$conn = mysqli_connect($hostname, $username, $password, $dbname);
	mysqli_query($conn, "SET NAMES 'utf8'");
	if (!$conn) {
		die('Mysql connection failed: '.mysqli_connect_error());
	}

	
?>

<section class="showlogin">
	<div class="login">
		<h1>회원가입</h1>
		<form action="register_db.php" method="POST">
			<ul>
				<li>
					<input type="text" name="ID" value="ID" onfocus="if(this.value == 'ID') this.value=''" onblur="if(this.value == '') this.value='ID';">
				</li>
				<li>
					<input type="text" name="nick" value="name" onfocus="if(this.value == 'name') this.value=''" onblur="if(this.value == '') this.value='name';">
				</li>
				<li>
					<input type="text" name="password" value="password" onfocus="if(this.value =='password') { this.value=''; this.type='password'; }" onblur="if(this.value =='') { this.value='password'; this.type='text'; }">
				</li>
				<li>
					<input type="submit" value="register">
				</li>
			</ul>
		</form>
	</div>
</section>
	
<?php // footer ?>
</body>
</html>