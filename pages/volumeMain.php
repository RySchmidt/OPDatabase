<!DOCTYPE html>
<html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "configSession.inc.php";
require_once "volume/volumeView.inc.php";
require_once "chapter/chapterView.inc.php";
require_once "sbs/sbsView.inc.php";
?>

<head>
<title> One Piece Unspoiled - Volumes </title>
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
<form action="/OPDatabase/include/formAction/insertVolume.inc.php" method="POST">

<thead>
<th class="form" colspan="2"> <h2> Insert Volume/SBS </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="volume_number"> Volume Number: </label> </td>
<td class="form">
<?php
volumeField("insert", "volume_number", "number", "volume", "invalid_volume_number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="volume_title"> Volume Title: </label> </td>
<td class="form">
<?php
volumeField("insert", "volume_title", "text", "volume", "invalid_volume_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="volume_publish_date"> Publish Date: </label> </td>
<td class="form">
<?php
volumeField("insert", "volume_publish_date", "date");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label> Chapter Range: </label> </td>
<td class="form">

<?php
chapterSelection("insert", "min_chapter_number");
?>
<br> to <br>
<?php
chapterSelection("insert", "max_chapter_number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="sbs_number"> SBS Number: </label> </td>
<td class="form">
<?php
sbsField("insert", "sbs_number", "number", "sbs", "invalid_sbs_number");
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
<form action="/OPDatabase/include/formAction/populateVolumeModifyForm.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Modify Volume/SBS </h2> <th>
</tr>
</thead>

<tr class="form">
<td class="form"> <label name="volume_number"> Volume Number: </label> </td>
<td class="form">
<?php
volumeSelection("modify", "volume_number");
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
<form action="/OPDatabase/include/formAction/modifyVolume.inc.php" method="POST">

<tbody>
<?php
hiddenVolumeField("modify", "volume_number", "original_volume_number", "-1");
?>

<tr class="form">
<td class="form"> <label name="volume_number"> Volume Number: </label> </td>
<td class="form">
<?php
volumeField("modify", "volume_number", "number", "volume", "invalid_volume_number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="volume_title"> Volume Title: </label> </td>
<td class="form">
<?php
volumeField("modify", "volume_title", "text", "volume", "invalid_volume_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="volume_publish_date"> Publish Date: </label> </td>
<td class="form">
<?php
volumeField("modify", "volume_publish_date", "date");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label> Chapter Range: </label> </td>
<td class="form">

<?php
chapterSelection("modify", "min_chapter_number");
?>
<br> to <br>
<?php
chapterSelection("modify", "max_chapter_number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="sbs_number"> SBS Number: </label> </td>
<td class="form">
<?php
sbsField("modify", "sbs_number", "number", "sbs", "invalid_sbs_number");
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
<form action="/OPDatabase/include/formAction/deleteVolume.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete Volume </h2> <th>
</tr>
</thead>

<tbody>

<tr class="form">
<td class="form"> <label name="volume_number"> Volume Number: </label> </td>
<td class="form">
<?php
volumeSelection("delete_volume", "volume_number");
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
<form action="/OPDatabase/include/formAction/deleteSBS.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete SBS</h2> <th>
</tr>
</thead>

<tbody>

<tr class="form">
<td class="form"> <label name="sbs_number"> SBS Number: </label> </td>
<td class="form">
<?php
sbsSelection("delete_sbs", "sbs_number");
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
checkVolumeErrors("insert");
checkSBSErrors("insert");

checkVolumeErrors("modify");
checkSBSErrors("modify");

checkVolumeErrors("delete");
checkSBSErrors("delete");
?>
</div>

<div>
<?php
volumeInputDisplay();
?>
</div>

</body>
</html>
