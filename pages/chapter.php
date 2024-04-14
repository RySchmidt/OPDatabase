<!DOCTYPE html>
<html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "configSession.inc.php";
require_once "query/chapterView.inc.php";
?>

<head>
<title> One Piece Unspoiled - Chapters </title>
<link rel="stylesheet" href="/OPDatabase/css/formAlignment.css">
</head>

<body>
<div>
<a href="/OPDatabase/index.php">Return to Main Page</a>
</div>


<div class="formsRow">

<div class="formsColumn">
<?php
require "forms/insertChapterForm.inc.php";
?>
</div>

<div class="formsColumn">
<?php
require "forms/updateChapterForm.inc.php";
?>
</div>

<div class="formsColumn">
<?php
require "forms/deleteChapterForm.inc.php";
?>
</div>

</div>

<?php
checkInsertChapterErrors();
?>

<div>
<?php
require 'display/displayChapters.inc.php';
?>
</div>

</body>
</html>
