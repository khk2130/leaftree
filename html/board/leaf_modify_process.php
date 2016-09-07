<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php


	
	$hostname = 'kocia.cytzyor3ndjk.ap-northeast-2.rds.amazonaws.com';
	$username = 'kimhyekwan'; 
	$password = 'password';
	$dbname = 'leaftree';
	$conn = mysqli_connect($hostname, $username, $password, $dbname);
	
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$board_id = $_POST['board_id'];
		$name = $_POST['name'];
		$content = $_POST['content'];
		
			if($name == ''|| $content == ''){
				die('빈칸을 모두 채워주세요.');
			}
		
		$update_query = sprintf("UPDATE board SET name='%s', content='%s' WHERE board_id =%d", 
				$name, $content, $board_id);	
		
			if (mysqli_query($conn, $update_query) === false) {
			die(mysqli_error($conn));
			}
		}
		echo "성공적으로 수정되었습니다. <br>";
		mysqli_close($conn);
	
	header('Location: board_main.php');


?>