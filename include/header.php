<link rel="stylesheet" type="text/css" href="/css/head.css">

<?php
$root = '.';
require_once '/../include/host.php';
start_session();
?>

<header class="clearfix">
<?php
if (check_login()) {  // 로그인
	// 세션 : get_nick();
	$conn = get_connection();
?>
	
	<div class="floatright">
		<a href="/logout.php">logout</a>
	</div>
	<div class="floatright">
		<a href="/admin/profile_change.php">profile</a>
	</div>
	<div class="floatright">
		<?php
		$user_id = get_user_id($conn, $_SESSION['id']);
		printf('<a href="/dashboard/?user=%d">%s</a>',
			$user_id, get_user_nick($conn, $user_id));
		?>
	</div>
<?php
} else { // 비로그인
?>
	


<?php
}
?>
</header>