<!DOCTYPE html>
<html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "configSession.inc.php";
require_once "organization/organizationView.inc.php";
require_once "infoCache/infoCacheView.inc.php";
?>

<head>
<title> One Piece Unspoiled - Organization </title>
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
<form action="/OPDatabase/include/formAction/insertOrganization.inc.php" method="POST">

<thead>
<th class="form" colspan="2"> <h2> Create Organization </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="organization_name"> Name: </label> </td>
<td class="form">
<?php
organizationField("insert", "organization_name", "text", "organization", "invalid_organization_name");
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
<td class="form"> <input type="submit" value="Submit"> </td>

</form>
</tbody>
</table>

</div>

<div class="formsColumn">

<table class="form">
<form action="/OPDatabase/include/formAction/populateOrganizationModifyForm.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Modify Organization </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="organization_id"> Organization: </label> </td>
<td class="form">
<?php
organizationSelection("modify", "organization_id");
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
<form action="/OPDatabase/include/formAction/modifyOrganization.inc.php" method="POST">

<?php
hiddenOrganizationField("modify", "organization_id", "organization_id", "-1");
?>

<tbody>
<tr class="form">
<td class="form"> <label name="organization_name"> Name: </label> </td>
<td class="form">
<?php
organizationField("modify", "organization_name", "text", "organization", "invalid_organization_name");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="info_cache_id"> Introduced In: </label> </td>
<td class="form">
<?php
infoCacheSelection("modify", "info_cache_id");
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
<form action="/OPDatabase/include/formAction/deleteOrganization.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete Organization </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="organization_id"> Organization: </label> </td>
<td class="form">
<?php
organizationSelection("delete", "organization_id");
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
checkOrganizationErrors("insert");
checkOrganizationErrors("modify");
checkOrganizationErrors("delete");
?>
</div>

<div>
<?php
organizationInputDisplay();
?>
</div>

</body>
</html>
