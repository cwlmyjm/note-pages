<!doctype html>
<html>
	<head>
		<meta charset="utf8" />
		<title>Content</title>
	</head>
	<body>
		<h1><b>Content</b></h1>
		<?php foreach ($notes as $note): ?>
			<hr />
			<h1><b><?php echo $note['title']; ?></b></h1>
		<?php endforeach; ?>
	</body>
<html>