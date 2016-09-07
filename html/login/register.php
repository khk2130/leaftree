<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel="stylesheet" type="text/css" href="/css/mystyle.css">
</head>
<body>
<div class="content">
<h1>나의 게시판</h1>
<?php
require_once 'session.php';
require_once $_SERVER["DOCUMENT_ROOT"]."/../includes/my/mylib.php";
 
if (isset($_POST['id'], $_POST['hash'])) { // 들어오는 인자는 이미 클라이언트에서 해쉬로 된 것
    $id = $_POST['id'];
    $password = $_POST['hash']; 
	$conn = get_db_connection();
	$stmt = mysqli_prepare($conn, "SELECT hash FROM user_account WHERE id = ?");
	mysqli_stmt_bind_param($stmt, "s", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if (mysqli_num_rows($result) != 0) { // 이미 등록된 아이디
		header('Location: error.php?error_code=4');
	} else {
		$stmt = mysqli_prepare($conn, "INSERT INTO user_account VALUES (?, ?)");
		$hash = password_hash($password, PASSWORD_DEFAULT);
		mysqli_stmt_bind_param($stmt, "ss", $id, $hash);
		mysqli_stmt_execute($stmt);
?>
		회원가입 성공!<br>
		<form action="../index.php">
		<input type="submit" value="메인 화면으로 돌아가기">
		</form>
	
<?php
	}
	mysqli_free_result($result);
	mysqli_close($conn);
} else {
    echo '회원가입 폼 에러';
}
?>
</div>
</body>
</html>