<!DOCTYPE html>
<html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "storyArc/storyArcView.inc.php";
require_once "chapter/chapterView.inc.php";
?>

<head>
<title> One Piece Unspoiled - Story Arcs </title>
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
<form action="/OPDatabase/include/formAction/insertStoryArc.inc.php" method="POST">

<thead>
<th class="form" colspan="2"> <h2> Insert Story Arc</h2> <th>
</tr>
</thead>


<tr class="form">
<td class="form"> <label name="story_arc_title"> Story Arc Title: </label> </td>
<td class="form">
<?php
storyArcField("insert", "story_Arc_title", "text", "story_Arc", "invalid_storyArc_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="story_arc_id"> Parent Story Arc: </label> </td>
<td class="form">
<?php
storyArcSelection("insert", "parent_story_arc_id");
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
<th class="form" colspan="2"> <h2> Modify Story Arc </h2> <th>
</tr>
</thead>

<tr class="form">
<td class="form"> <label name="story_arc_id"> Story Arc: </label> </td>
<td class="form">
<?php
storyArcSelection("insert", "story_arc_id");
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


<tr class="form">
<td class="form"> <label name="story_arc_title"> Story Arc Title: </label> </td>
<td class="form">
<?php
storyArcField("modify", "story_Arc_title", "text", "story_Arc", "invalid_storyArc_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="story_arc_id"> Parent Story Arc: </label> </td>
<td class="form">
<?php
storyArcSelection("modify", "parent_story_arc_id");
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
chapterSelection("insert", "max_chapter_number");
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
<th class="form" colspan="2"> <h2> Delete Story Arc</h2> <th>
</tr>
</thead>

<tbody>

<tr class="form">
<td class="form"> <label name="story_arc_id"> Story Arc: </label> </td>
<td class="form">
<?php
storyArcSelection("delete", "story_arc_id");
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
storyArcsInputDisplay();
?>
</div>

</body>
</html>
