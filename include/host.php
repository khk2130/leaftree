<?php
function get_connection() {
	$hostname = 'kocia.cytzyor3ndjk.ap-northeast-2.rds.amazonaws.com';
	$username = 'kimhyekwan';
	$password = 'password';
	$dbname = 'leaftree';
	
	$conn = mysqli_connect($hostname, $username, $password, $dbname);
	mysqli_query($conn, "SET NAMES 'utf8'");
	if (!$conn) {
		die('Mysql connection failed: '.mysqli_connect_error());
	}
	
	return $conn;
}

// 존재 여부 확인
function search_count($conn, $table, $where) {
	$query = sprintf("SELECT count(*) AS count FROM %s WHERE %s", $table, $where);
	$result = mysqli_query($conn, $query);
	if ($result === false) {
		die ("Database access failed: ".mysqli_error());
	}
	$row = mysqli_fetch_assoc($result);
	return $row['count'];
}

// $_SESSION['id'] = ID -> id
// get_user_pk($conn, $_ ESSION['id']);
function get_user_pk($conn, $ID) {
	$query = sprintf("SELECT id FROM user WHERE ID = '%s'", $ID);
	$result = mysqli_query($conn, $query);
	if ($result === false) {
		die ("Database access failed: ".mysqli_error());
	}
	$row = mysqli_fetch_assoc($result);
	return $row['id'];
}

// post(user_pk) -> user(ID)
function get_user_ID($conn, $user_pk) {
	$query = sprintf("SELECT ID FROM user WHERE id = %d", $user_pk);
	$result = mysqli_query($conn, $query);
	if ($result === false) {
		die ("Database access failed: ".mysqli_error());
	}
	$row = mysqli_fetch_assoc($result);
	
	return $row['ID'];
}

// post(user_pk) -> user(name)
function get_user_name($conn, $user_pk) {
	$query = sprintf("SELECT name FROM user WHERE id = %d", $user_pk);
	$result = mysqli_query($conn, $query);
	if ($result === false) {
		die ("Database access failed: ".mysqli_error());
	}
	$row = mysqli_fetch_assoc($result);
	
	return $row['name'];
}

// post(user_pk) -> user(picture)
function get_user_picture($conn, $user_pk) {
	$query = sprintf("SELECT picture FROM user WHERE id = %d", $user_pk);
	$result = mysqli_query($conn, $query);
	if ($result === false) {
		die ("Database access failed: ".mysqli_error());
	}
	$row = mysqli_fetch_assoc($result);
	
	return $row['picture'];
}

// post(category_id) -> category(name)
function get_category_name($conn, $id) {
	$query = sprintf("SELECT name FROM category WHERE id = %d", $id);
	$result = mysqli_query($conn, $query);
	if ($result === false) {
		die ("Database access failed: ".mysqli_error());
	}
	$row = mysqli_fetch_assoc($result);
	
	return $row['name'];
}

// user(gender_id) -> gender(gender)
function get_gender_type($conn, $id) {
	$query = sprintf("SELECT * FROM gender WHERE id = %d", $id);
	$result = mysqli_query($conn, $query);
	if ($result === false) {
		die ("Database access failed: ".mysqli_error());
	}
	$row = mysqli_fetch_assoc($result);
	
	return $row['gender'];
}

// db -> my user profile
function get_user_profile($conn, $user_pk) {
	$query = sprintf("SELECT * FROM user WHERE id = %d", $user_pk);
	$result = mysqli_query($conn, $query);
	if ($result === false) {
		die ("Database access failed: ".mysqli_error());
	}
	
	return $result;
}

// db -> category list
function get_category_list($conn, $user_pk) {
	$query = sprintf("SELECT * FROM category WHERE user_pk = %d", $user_pk);
	$result = mysqli_query($conn, $query);
	if ($result === false) {
		die ("Database access failed: ".mysqli_error());
	}
	
	return $result;
}

// 타임셋
function time_set($date) {
	if (!$date) {
		return $date;
	}
	$timezone = 'GMT+0';
	$date = strtotime($date.' '.$timezone);
	$date = date('Y-m-d H:i:s', $date);
	return $date;
}

// 쿠키 생성
function start_session() {
	$secure = false;
	$httponly = true;
	
	if (ini_set('session.use_only_cookies', 1) === false) {
		header("Location: error.php?error_code=2");
		exit();
	}
	
    $params = session_get_cookie_params();
    session_set_cookie_params($params["lifetime"],
        $params["path"], 
        $params["domain"], 
        $secure, $httponly);
 
    session_start();
    session_regenerate_id(true);
}

// 쿠키 삭제
function destroy_session() {
	$_SESSION = array();
	$params = session_get_cookie_params();
	
	setcookie(session_name(), '', 0, 
		$params['path'], $params['domain'], $params['secure'], isset($params['httponly'])); 
	session_destroy();
}

function try_to_login($id, $password) {
	if (check_user_account($id, $password)) {
		$_SESSION['ip'] = $_SERVER['REMOTE_ADDR'];
		$_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
		$_SESSION['id'] = $id;
		$_SESSION['password'] = $password;
		$_SESSION['login_status'] = true;
		return true;
	} else {
		return false;
	}
}

function try_to_logout() {
	if (check_login()) {
		$_SESSION['login_status'] = false;
	} else {
	}
}

function check_login() {
	return isset($_SESSION['ip'], $_SESSION['user_agent'], $_SESSION['login_status']) && 
		$_SESSION['ip'] == $_SERVER['REMOTE_ADDR'] && 
		$_SESSION['user_agent'] == $_SERVER['HTTP_USER_AGENT'] &&
		$_SESSION['login_status'];
}

function check_user_account($id, $password) {
	$conn = get_connection();
	// statement : 명제
	$stmt = mysqli_prepare($conn, "SELECT pw_hash FROM user WHERE ID = ?");
	mysqli_stmt_bind_param($stmt, "s", $id);
	mysqli_stmt_execute($stmt);
	$result = mysqli_stmt_get_result($stmt);
	if (mysqli_num_rows($result) === 0) {
		// header('Location: error.php?error_code=1');
		header('Location: /');
	} else {
		$row = mysqli_fetch_assoc($result);
		$hash = $row["pw_hash"];
		return password_verify($password, $hash);
	}
	mysqli_free_result($result);
	mysqli_close($conn);
}

// file upload
function file_upload($root, $file_name, $ext) {
	// upload file
	$upload_dir = $root.'/../file/';
	$upload_file_name = $file_name.'.'.$ext;
	$upload_file = $upload_dir.$upload_file_name;
	
	if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_file)) {
		echo 'The file '.basename($_FILES['file']['name']).' has been uploaded.';
	} else {
		echo 'Sorry, there was an error uploading your file.';
	}
	
	return $upload_file_name;
}
?>