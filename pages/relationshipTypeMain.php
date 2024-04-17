<!DOCTYPE html>
<html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "configSession.inc.php";
require_once "relationshipType/relationshipTypeView.inc.php";
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
<form action="/OPDatabase/include/formAction/insertRelationshipType.inc.php" method="POST">

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
<form action="/OPDatabase/include/formAction/populateRelationshipTypeModifyForm.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Modify Relationship Type </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="relationship_type_id"> Relationship Type: </label> </td>
<td class="form">
<?php
relationshipTypeSelection("modify", "relationship_type_id");
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
<form action="/OPDatabase/include/formAction/modifyRelationshipType.inc.php" method="POST">

<?php
hiddenRelationshipTypeField("modify", "relationship_type_id", "relationship_type_id", "-1");
?>

<tbody>
<tr class="form">
<td class="form"> <label name="relationship_type_name"> Name: </label> </td>
<td class="form">
<?php
relationshipTypeField("modify", "relationship_type_name", "text", "relationship_type_name", "invalid_relationship_type_name");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="relationship_type_inverse"> Inverse Relationship Type: </label> </td>
<td class="form">
<?php
relationshipTypeSelection("modify", "relationship_type_inverse");
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
<form action="/OPDatabase/include/formAction/deleteRelationshipType.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete Relationship Type </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="relationship_type_id"> Relationship Type: </label> </td>
<td class="form">
<?php
relationshipTypeSelection("delete", "relationship_type_id");
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
checkRelationshipTypeErrors("insert");
checkRelationshipTypeErrors("modify");
checkRelationshipTypeErrors("delete");
?>
</div>

<div>
<?php
relationshipTypeInputDisplay();
?>
</div>

</body>
</html>
