<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>

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
	}	
?>
<?php
 echo '<table id = "board_id'.$board_id.'">';
?>
<h2>Leaf tree</h2>
<tr>
<th>ID</th><th>Name</th>
</tr>

<?php
echo '<tr>';
echo '<td>'.$user_id.'</td>';
echo '<td>'.$name.'</td>';
echo '</tr>';
?>
<tr>
<th></th>
</tr>
<?php
echo '<tr>';
echo '<td>'.$content.'</td>';
echo '</tr>';
?>
</table>
</html>