<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
?>

<!DOCTYPE html>
<html>

<head>
<title> One Piece Unspoiled - Chapters </title>
<link rel="stylesheet" href="/OPDatabase/css/tableStyle.css">
</head>

<body>
<div>
<a href="/OPDatabase/index.php">Return to Main Page</a>
</div>

<!-- Data Entry -->
<div class="row">

<div class="column">
<h2> Insert Chapter </h2>

<form action="/OPDatabase/include/insertChapter.inc.php" method="POST">
<label> Chapter # </label> <br>
<input type="number" name="chapter_number"> <br>
<label> Title </label> <br>
<input type="text" name="chapter_title"> <br>
<label> Publish Date </label> <br>
<input type="date" name="chapter_publish_date"> <br> <br>
<input type="submit" value="Submit">
</form>

</div>

<div class="column">
<h2> Update Chapter </h2>
</div>

<div class="column">
<h2> Delete Chapter </h2>
</div>

</div>


<?php
require 'display/displayChapters.inc.php'
?>

</body>
</html>
