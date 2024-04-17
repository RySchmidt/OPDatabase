<!DOCTYPE html>
<html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "configSession.inc.php";
?>

<head>
<title> One Piece Unspoiled - Relationship Type </title>
<link rel="stylesheet" href="/OPDatabase/css/formAlignment.css">
<link rel="stylesheet" href="/OPDatabase/css/formTable.css">
</head>

<body>
<div>
<a href="/OPDatabase/index.php">Return to Main Page</a>
</div>

<div class="formsRow">
<div class="formsColumn">

<table class="form">
<form action="" method="POST">

<thead>
<th class="form" colspan="2"> <h2> Relationship Type </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="relationship_type_name"> Name: </label> </td>
<td class="form">
<?php
relationshipTypeField("insert", "relationship_type_name", "text", "relationship_type", "invalid_relationship_type_name");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="relationship_type_inverse"> Inverse Relationship Type: </label> </td>
<td class="form">
<?php
relationshipTypeSelection("insert", "relationship_type_inverse");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <input type="submit" value="Submit"> </td>

</form>
</tbody>
</table>

</div>

<div class="formsColumn">

<table class="form">
<form action="" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Modify Relationship Type </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="relationship_type"> Relationship Type: </label> </td>
<td class="form">
<?php
relationshipTypeSelection("insert", "relationship_type");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <input type="submit" value="Submit"> </td>

</form>
</tbody>
</table>

<br>

<table class="form">

<form action="" method="POST">

<?php
hiddenRelationshipTypeField("modify", "relationsship_type_id", "chapter_info_cache_id", "-1");
?>


<tbody>
<tr class="form">
<td class="form"> <label name="relationship_type_name"> Name: </label> </td>
<td class="form">
<?php
relationshipTypeField("insert", "relationship_type_name", "text", "relationship_type", "invalid_relationship_type_name");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="relationship_type_inverse"> Inverse Relationship Type: </label> </td>
<td class="form">
<?php
relationshipTypeSelection("insert", "relationship_type_inverse");
?>
</td>
</tr>

<tr class="form">
<td class="form" colspan="2"> 
<input type="reset" value="Reset">
<input type="submit" value="Submit">
</td>
</tr>

</form>
</tbody>
</table>
</div>


<div class="formsColumn">

<table class="form">
<form action="" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete Relationship Type </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="chapter_number"> Relationship Type: </label> </td>
<td class="form">
<?php
chapterSelection("delete_chapter", "chapter_number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <input type="submit" value="Submit"> </td>
</tr>

</form>
</tbody>
</table>

<br>

<table class="form">
<form action="" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete Cover Story </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="relationship_type"> Relationship Type: </label> </td>
<td class="form">
<?php
relationshipTypeSelection("insert", "relationship_type");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <input type="submit" value="Submit"> </td>
</tr>

</form>
</tbody>
</table>
</div>

</div>
<div>
<?php

?>
</div>

<div>
<?php
relationshipTypeDisplay();
?>
</div>

</body>
</html>
