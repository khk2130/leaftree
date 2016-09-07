<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>

<h2> My Tree </h2>

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
		
		echo '<table>';

		echo '<tr><th><li>'.'이름 '.'</th>'.'<td>'.$name.'</td></tr></li>';
		
		echo '<tr><th><li>'.'내용 '.'</th>'.'<td>'.$content.'</td></tr></li><br>';
		
		echo '</table>';
		printf ("<a href='leaf_delete.php?board_id=%d'><button>글삭제</button></a>", $board_id);
		printf ("<a href='leaf_modify_form.php?board_id=%d'><button>글수정</button></a>", $board_id);
	}
		
		echo '<br><br>';
		 
		printf ("<a href='leaf_insert_form.php?user_id=%s'><button>글작성</button></a>",$user_id);
		
	

	mysqli_close($conn);
	
?>

</table>
		
</html>