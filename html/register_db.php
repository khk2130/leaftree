<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="/css/style.css">
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


<?php
	if (isset($_POST['ID'], $_POST['name'], $_POST['password'])) {
		$ID = $_POST['ID'];
		$name = $_POST['name'];
		$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
		
	
		
		
	
		$insert_query = sprintf("INSERT INTO user(id, name, pw_hash) values('%s', '%s', '%s');", $ID, $name, $password);
		if (mysqli_query($conn, $insert_query) === false) {
			echo mysqli_error($conn);
		 } else {
			 echo "register success..! <br><br>";
			 header('Location: /');
			}
			} else {
			 echo 'register form error..!';
				}

	 mysqli_close($conn);
?>

<?php // footer ?>

</body>
</html>