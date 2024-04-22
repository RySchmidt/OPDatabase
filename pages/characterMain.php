<!DOCTYPE html> <html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "configSession.inc.php";
require_once "character/characterView.inc.php";
require_once "infoCache/infoCacheView.inc.php";
?>

<head>
<title> One Piece Unspoiled - Characters </title>
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
<form action="/OPDatabase/include/formAction/insertCharacter.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Insert Character </h2> <th>
</tr>
</thead>


<tbody>
<tr class="form">
<td class="form"> <label name="character_name"> Character Name: </label> </td>
<td class="form">
<?php
characterField("insert", "character_name", "text");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="character_epithet"> Character Epithet: </label> </td>
<td class="form">
<?php
characterField("insert", "character_epithet", "text");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="info_cache_id"> Introduced In: </label> </td>
<td class="form">
<?php
infoCacheSelection("insert", "info_cache_id");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="character_notes"> Notes: </label> </td>
<td class="form">
<?php
characterField("insert", "character_notes", "text");
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
<form action="/OPDatabase/include/formAction/populateCharacterInformationForm.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Insert Character Information </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="character_id"> Select Character: </label> </td>
<td class="form">
<?php
characterSelection("insert", "character_id");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="info_type"> Information Type: </label> </td>
<td class="form">
<select class='form' name='info_type'>
<option value='1'> Name </option>
<option value='2'> Epithet </option>
<option value='3'> Occupation </option>
<option value='4'> Relationship </option>
</select>
</td>
</tr>

<tr class="form">
<td class="form"> <input type="submit" value="Submit"> </td>

</form>
</tbody>
</table>

<br>

<?php
informationTypeDisplay("insert");
?>

</div>

<div class="formsColumn">

<table class="form">
<form action="/OPDatabase/include/formAction/populateCharacterModifyInformationForm.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Modify Character Information </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="character_id"> Select Character: </label> </td>
<td class="form">
<?php
characterSelection("modify", "character_id");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="info_type"> Information Type: </label> </td>
<td class="form">
<select class='form' name='info_type'>
<option value='1'> Name </option>
<option value='2'> Epithet </option>
<option value='3'> Occupation </option>
<option value='4'> Relationship </option>
</select>
</td>
</tr>

<tr class="form">
<td class="form"> <input type="submit" value="Submit"> </td>

</form>
</tbody>
</table>

<br>

<table class="form">
<form action="/OPDatabase/include/formAction/insertCharacter.inc.php" method="POST">

<tbody>
<tr class="form">
<td class="form"> <label name="info_cache_id_reveal"> Introduced In: </label> </td>
<td class="form">
<?php
infoCacheSelection("modify", "info_cache_id_reveal");
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

<br>

<?php
informationModifyDisplay("modify");
?>

<br>

<?php
informationModify("modify");
?>

</div>

<div class="formsColumn">

<table class="form">
<form action="/OPDatabase/include/formAction/deleteCharacter.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete Character </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="character_id"> Select Character: </label> </td>
<td class="form">
<?php
characterSelection("delete_information", "character_id");
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
<form action="/OPDatabase/include/formAction/populateCharacterDeleteInformationForm.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete Character Information </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="character_id"> Select Character: </label> </td>
<td class="form">
<?php
characterSelection("delete", "character_id");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="info_type"> Information Type: </label> </td>
<td class="form">
<select class='form' name='info_type'>
<option value='1'> Name </option>
<option value='2'> Epithet </option>
<option value='3'> Occupation </option>
<option value='4'> Relationship </option>
</select>
</td>
</tr>

<tr class="form">
<td class="form"> <input type="submit" value="Submit"> </td>

</form>
</tbody>
</table>

<br>

<?php
informationDeleteDisplay("delete");
?>

</div>

</div>

<div>
<?php
checkCharacterErrors("insert");
checkCharacterErrors("modify");
checkCharacterErrors("delete");
?>

</div>
<div>
<?php
characterInputDisplay();
?>
</div>

</body>
</html>
