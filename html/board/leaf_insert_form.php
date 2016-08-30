<html>

<h2> 게시글 작성 </h2>

<body>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$board_id = $_GET['board_id'];
	}	
?>
	<form action="leaf_insert.php" method="post"><br><br>
	
	<?php printf("<input type='hidden' name='board_id' value='%s'>", $board_id); ?>
	<table>
	<tr><th>이름: <input type="text" name="name"></th></tr><br><br>
	<tr><th>ID: <input type="text" name="user_id"></th></tr><br><br>
	<th>내용: <br><textarea name="content" rows="5" cols="100"></textarea></th><br><br>
	
	<tr><th><input type="submit" value="완료"></th></tr>
	</form>


</table>
</body>
</html>