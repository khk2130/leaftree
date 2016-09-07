<html>

<h2> 게시글 작성 </h2>

<body>
<?php
	if($_SERVER['REQUEST_METHOD'] == 'GET'){
		$user_id = $_GET['user_id'];
	}	

?>
	<form action="leaf_insert.php" method="post"><br><br>
	

	<table>
	<?php printf("<input type='hidden' name='user_id' value='%s'>", $user_id); ?>
	<tr><th>이름: <input type="text" name="name"></th></tr><br><br>
	<th>내용: <br><textarea name="content" rows="5" cols="100"></textarea></th><br><br>
	
	<tr><th><input type="submit" value="완료"></th></tr>
	</form>


</table>
</body>
</html>