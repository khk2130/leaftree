<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<html>

<style type="text/css">

.wrap{margin:0 auto;width:50%;margin-top:50px;text-align: center;}
table{width:90%;border:1px solid #9BFA73;border-collapse:collapse;}

.num{width:10%;}
td{border:1px solid #9EF048;padding:10px;text-align:center;}
th{border:1px solid #9EF048;padding:10px;}



</style>

<table>
<head>

		<script language="javascript" src="js/sha512.js"></script>
		<script language="javascript" src="js/jquery-1.11.2.js"></script>
<script>
function tryLogin(form, password) {
    var hash = document.createElement('input');
    form.appendChild(hash);
    hash.name = 'hash';
	hash.type = 'hidden';
	hash.value = hex_sha512(password.value);
    password.value = '';
	form.submit();
	return true;
}
var isEditReplyMode = false;
function editReply(button, replyId, form) {
	var cell = document.getElementById(replyId);
	if (isEditReplyMode == false) {
		var content = cell.innerHTML;
		cell.innerHTML = '';
		var textarea = document.createElement('textarea');
		textarea.id = replyId + 'textarea';
		cell.appendChild(textarea);
		textarea.value = content;
		textarea.cols = 35;
		isEditReplyMode = true;
		button.value = '수정완료';		
	} else {
		var textarea = document.getElementById(replyId + 'textarea');
		var content = textarea.value;
		if (content == '') {
			alert('댓글은 빈칸 안됨');
			textarea.focus();
			return false;
		}
		//cell.innerHTML = content;
		isEditReplyMode = false;
		button.value = '수정';
		var element = document.createElement('input');
		form.appendChild(element);
		element.name = 'content';
		element.type = 'hidden';
		element.value = content;
		form.submit();
	}
	return false;
}
function deleteRowById(table, rowId) {	
	for (var i = 0; i < table.rows.length; i++) {
		if (table.rows[i].id === rowId) {
			table.deleteRow(i);
			return;
		}
	}
	alert('deleteRowById not found');
}
function deleteReply(replyId) {
	if (confirm('정말 삭제하겟습니까?')) {
		
		ajaxDeleteReply(replyId);
		var table = document.getElementById('table_re');
		deleteRowById(table, 'comment_id' + replyId);
	}	
}
function ajaxAddReply(postId, content) {
	var replyId = '';
	$.ajax({ 
		url: 'ajax_add_reply.php',
		type: 'POST',
		async: false,
		data: { post_id: postId, content: content },
		success: function(result) {
			//alert('result' + result);
			replyId = result;
		},
		error: function(xhr) {
			alert('ajaxEditReply');
		},
		timeout : 1000
	});	
	return replyId;
}
function ajaxDeleteReply(replyId) {		
	$.ajax({ 
		url: 'ajax_delete_reply.php',
		type: 'POST',
		async: false,
		data: { comment_id: replyId },
		success: function(result) {
		},
		error: function(xhr) {
			alert('ajaxDeleteReply');
		},
		timeout : 1000
	});		
}
function ajaxEditReply(replyId, newContent) {
	$.ajax({ 
		url: 'ajax_edit_reply.php',
		type: 'POST',
		async: false,
		data: { comment_id: replyId, content: newContent },
		success: function(result) {
		},
		error: function(xhr) {
			alert('ajaxEditReply');
		},
		timeout : 1000
	});		
}

var currentDisplayedReplies = 0;
var replyBlockSize = 3;
function showMoreReplies(button) {
	var table = document.getElementById('table_re');
	var numTotalReplies = table.rows.length;
	// alert(numTotalReplies);
	var nextDisplayedReplies = Math.min(currentDisplayedReplies + replyBlockSize, numTotalReplies);
	for (var rownum = 0; rownum < numTotalReplies; rownum++) {
		var row = table.rows[rownum];
		if (rownum < nextDisplayedReplies) {
			row.style.display = '';
		} else {
			row.style.display = 'none';
		}
	}
	currentDisplayedReplies = nextDisplayedReplies;
	if (nextDisplayedReplies === numTotalReplies) {
		button.style.display = 'none';
	} 
}
</script>
</head>

<body class="bo">




<div class="wrap">
<body>
<?php
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
			$number = $_GET['number'];
		}
		
	$hostname = 'kocia.cytzyor3ndjk.ap-northeast-2.rds.amazonaws.com';
	$username = 'kimhyekwan';
	$password = 'password';
	$dbname = 'leaftree';
	$conn = mysqli_connect($hostname, $username, $password, $dbname);
	mysqli_query($conn, "SET NAMES 'utf8'");
	if (!$conn) {
		die('Mysql connection failed: '.mysqli_connect_error());
	} 	
	
	$select_query = 'SELECT name, content FROM board';
	// select 쿼리는 mysqli_query 함수의 반환값으로 결과를 받는다.
	$result = mysqli_query($conn, $select_query);
	while($row = mysqli_fetch_assoc($result)){
	
			echo '</table>';
			echo '<table>';
			
			
			echo '<tr>'.'<th>'.'제목 '.'</th>'.'<td>'.$row['name'].'</td>'.'</tr>';
		
			echo '<tr>'.'<th>'.'내용 '.'</th>'.'<td>'.$row['content'].'</td>'.'</tr>';
			echo '</table>';
	}
	
	echo '<br>';
	printf("<a href='board_delete.php?number=%d'><button>글삭제</button></a>", $number);
	printf("<a href='modify_board.php?number=%d'><button>글수정</button></a><br>", $number);
	
	mysqli_free_result($result);
	mysqli_close($conn);
	
?>
</table>
<table>
	<tr><br>
	<form action="board_main.php" method="post">
	<input type="submit" value="게시판으로">
	</form>
	</tr>
</table>

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
	$select_query = 'SELECT post_id,writer,content,comment_id FROM comment ORDER BY comment_id DESC';
	$result = mysqli_query($conn,$select_query);
	echo '<table id="table_re">';
	while($row = mysqli_fetch_assoc($result)){
		if($number === $row['post_id']){
			
		$comment_id = $row['comment_id'];
		echo '<br>';
		
		
		
		echo '<tr id="comment_id'.$comment_id.'">';
		echo '<th>'.$row['writer'].'</th>';
		echo '<th id="'.$comment_id.'">'.$row['content'].'</th>';
		echo '<th>';
		echo "<form action='comment_modify_process.php' method='post'>";
		echo '<input type="hidden" value="'.$comment_id.'" name="comment_id">';
		echo '<input type="hidden" value="'.$row['writer'].'" name="writer">';
		echo '<input type="hidden" value="'.$number.'" name="number">';
		echo '<input type="button" value="댓글수정" onClick="editReply(this,'.$comment_id.', this.form);">';
		echo "</form>";
		
		echo '<input type="button" value="삭제" onClick="deleteReply('.$comment_id.');">';
		echo '</th>';
		echo '</tr>';
		
		}
		
	}
	echo '</table>';
	?>
<table>


<form action="comment_insert.php" method="post">

<?php 
	printf("<input type='hidden' name='post_id' value='%d'>", $number);
?>

<td>댓글쓰기</td>
<td>이름  : <input type="text" name="writer"></td><br>
<td>내용  : <textarea rows = "2" cols = "50%" input type="text" name="content"></textarea></td><br><br>
<td><input class = "r_btn" type="submit" value = '확인'></td>


</form>
<button id="show_more_reply_button" onclick="showMoreReplies(this);">댓글더보기</button><br><br>
<script>
if (currentDisplayedReplies === 0){
	showMoreReplies(document.getElementById('show_more_reply_button'));
}

</script>
</table>


</body>
</html>