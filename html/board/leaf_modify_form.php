<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<?php
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
		$board_id = $_GET['board_id'];
	}	
	$hostname = 'kocia.cytzyor3ndjk.ap-northeast-2.rds.amazonaws.com';
	$username = 'kimhyekwan'; 
	$password = 'password';
	$dbname = 'leaftree';
	$conn = mysqli_connect($hostname, $username, $password, $dbname);
	mysqli_query($conn, "SET NAMES 'utf8'");	
	$stmt = mysqli_prepare($conn, "SELECT * FROM board WHERE board_id =?");
	
	mysqli_stmt_bind_param($stmt, "d", $board_id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);
	
			$name = $row['name'];
			
			$content = $row['content'];
	
		printf("<h1>글수정</h1>");
		printf("<form action='leaf_modify_process.php' method='post'>");
		printf("<table>");
		printf("<tr><th><b></b></th><td><input type='hidden' value='%d' name='board_id' readonly></td></tr>",$board_id);
		
		printf("<tr><th><b>이름 :</b></th><td><input type='text' value='%s' name='name'></td></tr>",$name);
		
		printf("<tr><th><b>내용 :</b></th><td><input type='text' value='%s' name='content'></td></tr>",$content);
	
		printf("<tr><td colspan='2' align='center'><input type='submit' value='완료'></td></tr>");
		printf("</table>");
		printf("</form>");
	
	
?>