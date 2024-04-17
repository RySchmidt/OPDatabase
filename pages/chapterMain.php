<!DOCTYPE html>
<html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "configSession.inc.php";
require_once "chapter/chapterView.inc.php";
require_once "volume/volumeView.inc.php";
require_once "coverStory/coverStoryView.inc.php";
require_once "storyArc/storyArcView.inc.php";
require_once "coverStory/coverStoryContr.inc.php";
?>

<head>
<title> One Piece Unspoiled - Chapters </title>
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
<form action="/OPDatabase/include/formAction/insertChapter.inc.php" method="POST">

<thead>
<th class="form" colspan="2"> <h2> Insert Chapter/Cover Story </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="chapter_number"> Chapter Number: </label> </td>
<td class="form">
<?php
chapterField("insert", "chapter_number", "number", "chapter", "invalid_chapter_number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_title"> chapter title: </label> </td>
<td class="form">
<?php
chapterfield("insert", "chapter_title", "text", "chapter", "invalid_chapter_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_publish_date"> Publish Date: </label> </td>
<td class="form">
<?php
chapterField("insert", "chapter_publish_date", "date");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_volume_number"> Volume Number: </label> </td>
<td class="form">
<?php
volumeSelection("insert", "chapter_volume_number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_story_arc_id"> Story Arc: </label> </td>
<td class="form">
<?php
storyArcSelection("insert", "chapter_story_arc_id");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="cover_story_title"> Cover Story Title: </label> </td>
<td class="form">
<?php
coverStoryField("insert", "cover_story_title", "text", "cover_story", "invalid_cover_story_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="cover_story_arc_id"> Cover Story Arc: </label> </td>
<td class="form">
<?php
storyArcSelection("insert", "cover_story_arc_id");
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
<form action="/OPDatabase/include/formAction/populateChapterModifyForm.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Modify Chapter/Cover Story </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="chapter_number"> Select Chapter: </label> </td>
<td class="form">
<?php
chapterSelection("modify", "chapter_number");
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

<form action="/OPDatabase/include/formAction/modifyChapter.inc.php" method="POST">

<?php
hiddenChapterField("modify", "chapter_info_cache_id", "chapter_info_cache_id", "-1");
?>


<tbody>
<tr class="form">
<td class="form"> <label name="chapter_number"> Chapter Number: </label> </td>
<td class="form">
<?php
chapterField("modify", "chapter_number", "number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_title"> Chapter Title: </label> </td>
<td class="form">
<?php
chapterField("modify", "chapter_title", "text");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_publish_date"> Publish Date: </label> </td>
<td class="form">
<?php
chapterField("modify", "chapter_publish_date", "date");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_volume_number"> Volume Number: </label> </td>
<td class="form">
<?php
volumeSelection("modify", "chapter_volume_number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_story_arc_id"> Story Arc: </label> </td>
<td class="form">
<?php
storyArcSelection("modify", "chapter_story_arc_id");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="cover_story_title"> Cover Story Title: </label> </td>
<td class="form">
<?php
coverStoryField("modify", "cover_story_title", "text", "invalid_cover_story_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="cover_story_arc_id"> Cover Story Arc: </label> </td>
<td class="form">
<?php
storyArcSelection("modify", "cover_story_arc_id");
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
<form action="/OPDatabase/include/formAction/deleteChapter.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete Chapter </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="chapter_number"> Select Chapter: </label> </td>
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
<form action="/OPDatabase/include/formAction/deleteCoverStory.inc.php" method="POST">

<thead>
<tr>
<th class="form" colspan="2"> <h2> Delete Cover Story </h2> <th>
</tr>
</thead>

<tbody>
<tr class="form">
<td class="form"> <label name="chapter_number"> Select Cover Story: </label> </td>
<td class="form">

<?php
coverStorySelection("delete_cover_story", "chapter_number");
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
checkChapterErrors("insert");
checkCoverStoryErrors("insert");

checkChapterErrors("modify");
checkCoverStoryErrors("modify");

checkChapterErrors("delete");
checkCoverStoryErrors("delete");
?>
</div>

<div>
<?php
chapterInputDisplay();
?>
</div>

</body>
</html>
