<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>

<h2> My Tree </h2>
<table>
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
	$select_query = 'SELECT user_id,name,content,board_id FROM board ORDER BY board_id DESC';
	$result = mysqli_query($conn,$select_query);
		
	while($row = mysqli_fetch_assoc($result)){
		
		$user_id = $row['user_id'];
		$name = $row['name'];
		$content = $row['content'];
		$board_id = $row['board_id'];
		echo '</table>';
		echo '<table>';

		echo '<tr>'.'<th>'.'이름 '.'</th>'.'<td>'.$name.'</td>'.'</tr>';
		echo '<tr>'.'<th>'.'아이디 '.'</th>'.'<td>'.$user_id.'</td>'.'</tr>';
		echo '<tr>'.'<th>'.'내용 '.'</th>'.'<td>'.$content.'</td>'.'</tr>'.'<br>';
		echo '<tr>';
		printf ("<a href='leaf_delete.php?board_id=%d'><button>글삭제</button></a>", $board_id);
		echo '</tr>';
	
	}

	
	
?>

</table>
		
</html>