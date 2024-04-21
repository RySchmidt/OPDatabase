<!DOCTYPE html>
<html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "configSession.inc.php";
require_once "search/searchView.inc.php";
?>

<head>
<title> One Piece Unspoiled - Search </title>
<link rel="stylesheet" href="/OPDatabase/css/formAlignment.css">
<link rel="stylesheet" href="/OPDatabase/css/formTable.css">
<link rel="stylesheet" href="/OPDatabase/css/searchResults.css">
</head>

<body>
<div>
<a href="/OPDatabase/index.php">Return to Main Page</a>
</div>

<div class="formsRow">

<div class="searchResults">
<h1> Search Results </h1>
<?php
displayCharacterSearch("character_search_ids");
?>
</div>

<div class="formsColumn">

<?php
searchTable();
?>

</div>
</div>

</body>
</html>
