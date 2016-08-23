<?php
$mylib_path = $_SERVER['DOCUMENT_ROOT'] . '/../includes/mylib_bookies.php';
require_once($mylib_path);


// 하나의 페이지에서 한 번만 호출되어야 한다.
function start_session() {
    $secure = false; // https
    $httponly = true; // 클라이언트에서 세션 쿠키를 수정 불가능 
	
    // 세션이 쿠키만 사용하도록 강제
    if (ini_set('session.use_only_cookies', 1) === false) {
        header("Location: error.php?error_code=2");
        exit();
    }
	
    $params = session_get_cookie_params();
    session_set_cookie_params($params["lifetime"],
        $params["path"], 
        $params["domain"], 
        $secure,
        $httponly);
 
    session_start();
    session_regenerate_id(true); // session fixation 대비
}

 // start_session 호출된 후에 사용되어야 한다
function destroy_session() {
	$_SESSION = array(); // 모든 세션 변수 제거
	// 세션 쿠키 제거
	$params = session_get_cookie_params(); // 쿠키삭제를 위해서는 생성될때의 인자들을 알아야한다.
	setcookie(session_name(), '', 0, 
		$params['path'], $params['domain'], $params['secure'], isset($params['httponly'])); 
	session_destroy(); 
}

 // start_session 호출된 후에 사용되어야 한다
function try_to_login($username, $password) {

	if (check_user_account($username, $password)) {
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['username'] = $username;
		$_SESSION['password'] = $password;
		$_SESSION['name'] = get_name($username); 	// *현재는 이름만 가져옴(추후 수정 가능성 있음.)
		$_SESSION['login_status'] = true;
		
		if($_SESSION['username'] == "admin"){		// 관리자 계정의 경우 관리자모드 on.
			$_SESSION['admin_mode'] = true;
		}else {
			$_SESSION['admin_mode'] = false;
		}

		return true;
	} else {
		return false;
	}
}

function check_user_account($username, $password) {

	$conn = get_mysql_conn();
	$stmt = mysqli_prepare($conn, "SELECT password_hash FROM member WHERE username = ?");
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if (mysqli_num_rows($result) === 0) { // 등록되지 않은 아이디	
		mysqli_free_result($result);
		mysqli_close($conn);	
		header('Location: error.php?error_code=1');
	} else {
		$row = mysqli_fetch_assoc($result);
		$hash = $row["password_hash"];		
		
		mysqli_free_result($result);
		mysqli_close($conn);	
		
		return password_verify($password, $hash);
	}
}

function get_name($username) {
	$conn = get_mysql_conn();
	$stmt = mysqli_prepare($conn, "SELECT name FROM member WHERE username = ?");
	mysqli_stmt_bind_param($stmt, "s", $username);
	mysqli_stmt_execute($stmt);
	
	$result = mysqli_stmt_get_result($stmt);
	$row = mysqli_fetch_assoc($result);
	$name = $row["name"];
	
	mysqli_free_result($result);
	mysqli_close($conn);	
	
	return $name;
}



// start_session 호출된 후에 사용되어야 한다
function check_login() {
	return isset($_SESSION['ip'], $_SESSION['user_agent'], $_SESSION['login_status']) && 
		// 세션 탈취를 방어. 세션이 생성될 때의 ip, 브라우저와 현재 상태가 동일한 지 확인.
		$_SESSION['ip'] == $_SERVER['REMOTE_ADDR'] && 
		$_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT'] &&
		$_SESSION['login_status'];
}


// start_session 호출된 후에 사용되어야 한다
function try_to_logout() {
	if (check_login()) {
		$_SESSION['login_status'] = false;
	} else {
	}
}

 ?>