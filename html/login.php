<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="/css/style.css">
</head>
 
<?php
$root = '.';
include_once $root.'/../include/header.php';
?>
<?php
if (isset($_POST['ID'], $_POST['password'])) {
	$ID = $_POST['ID'];
	$password = $_POST['password'];
	
	if (try_to_login($ID, $password) == true) {
		echo '로그인 성공';
		header('Location: board/');
	} else {
		echo '로그인 실패';
		header('Location: /');
		//header('Location: error.php?error_code=1');
	}
} else {
	echo 'login form error..!';
	header('Location: /');
}
?>

<?php // footer ?>
</body>
</html>