
<?php
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$board_id = $_GET['board_id'];
	}
	$hostname = 'kocia.cytzyor3ndjk.ap-northeast-2.rds.amazonaws.com';
	$username = 'kimhyekwan';
	$password = 'password';
	$dbname = 'leaftree';
	$conn = mysqli_connect($hostname, $username, $password, $dbname);
	
	mysqli_query($conn, "SET NAMES 'utf8'");
	
	if (!$conn) {
		die('Mysql connection failed: '.mysqli_connect_error());
	} 		
	$delete_query = sprintf("DELETE FROM board WHERE board_id=%d", $board_id);
		
	if (mysqli_query($conn, $delete_query) === false) {
			die(mysqli_error($conn));
	}
		
		mysqli_close($conn);
		
	header('Location: board_main.php');
	

?>