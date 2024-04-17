<!DOCTYPE html>
<html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "configSession.inc.php";
require_once "occupationType/occupationTypeView.inc.php";
?>

<head>
<title> One Piece Unspoiled - Occupation Type </title>
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
<form action="/OPDatabase/include/formAction/insertOccupationType.inc.php" method="POST">

<thead>
<th class="form" colspan="2"> <h2> Occupation Type </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="occupation_type_name"> Name: </label> </td>
<td class="form">
<?php
occupationTypeField("insert", "occupation_type_name", "text", "occupation_type", "invalid_occupation_type_name");
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
<form action="/OPDatabase/include/formAction/populateOccupationTypeModifyForm.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Modify Occupation Type </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="occupation_type_id"> Occupation Type: </label> </td>
<td class="form">
<?php
occupationTypeSelection("modify", "occupation_type_id");
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
<form action="/OPDatabase/include/formAction/modifyOccupationType.inc.php" method="POST">

<?php
hiddenOccupationTypeField("modify", "occupation_type_id", "occupation_type_id", "-1");
?>

<tbody>
<tr class="form">
<td class="form"> <label name="occupation_type_name"> Name: </label> </td>
<td class="form">
<?php
occupationTypeField("modify", "occupation_type_name", "text", "occupation_type_name", "invalid_occupation_type_name");
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
<form action="/OPDatabase/include/formAction/deleteOccupationType.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete Occupation Type </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="occupation_type_id"> Occupation Type: </label> </td>
<td class="form">
<?php
occupationTypeSelection("delete", "occupation_type_id");
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
checkOccupationTypeErrors("insert");
checkOccupationTypeErrors("modify");
checkOccupationTypeErrors("delete");
?>
</div>

<div>
<?php
occupationTypeInputDisplay();
?>
</div>

</body>
</html>
