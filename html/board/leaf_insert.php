<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
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

	
	if ($_SERVER['REQUEST_METHOD'] == 'POST'){ 
		$user_id = $_POST['user_id'];
		$name = $_POST['name'];
		$content = $_POST['content'];
		
		
	$insert_query = sprintf ("INSERT INTO board (user_id, name, content) VALUES ('%s', '%s', '%s')", $user_id, $name, $content);
		
		if (mysqli_query($conn, $insert_query) === false) {
			echo mysqli_error($conn);
			
			echo 'DB INSERT:name, ID, content<br>';
		}
	}
	//echo 'DB INSERT 성공<br>';
	mysqli_close($conn);
	header('Location: board_main.php');
?>
</body>
</html>