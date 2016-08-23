<!DOCTYPE html>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<html>
<head>
	<title>MY LEAF TREE</title>
	<link rel="stylesheet" type="text/css" href="/style/css/mystyle.css">

</head>
<h1>MY Tree</h1>

<body>  

	<div class="wrap">
	<?php 
		$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];
		
		require_once($DOCUMENT_ROOT . "/index/header.php");
	?>
		
		<div class="content_wrap">		
		<?php 
			require_once($DOCUMENT_ROOT . "/menu2.php");
		?>	
		<div id="main">
			
			
				
			</div>
			
		</div>
		
	<?php
		require_once($DOCUMENT_ROOT . "/index/footer.php");
	?>		
	</div>

<?php



?>
</body>
</html>