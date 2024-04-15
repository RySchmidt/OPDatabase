<!DOCTYPE html>
<html>

<?php 
require_once $_SERVER["DOCUMENT_ROOT"] . "/OPDatabase/config.php";
require_once "configSession.inc.php";
require_once "chapter/chapterView.inc.php";
require_once "coverStory/coverStoryView.inc.php";
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
chapterField("insert", "chapter_number", "number", "chapter_number", "chapter", "invalid_chapter_number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_title"> Chapter Title: </label> </td>
<td class="form">
<?php
chapterField("insert", "chapter_title", "text", "chapter_title", "chapter", "invalid_chapter_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_publish_date"> Publish Date: </label> </td>
<td class="form">
<?php
chapterField("insert", "chapter_publish_date", "date", "chapter_publish_date", "chapter");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_volume_number"> Volume Number: </label> </td>
<td class="form">
<?php
chapterVolumeNumberSelection("insert");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_story_arc"> Story Arc: </label> </td>
<td class="form">
<?php
chapterStoryArcSelection("insert");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="cover_story_title"> Cover Story Title: </label> </td>
<td class="form">
<?php
coverStoryField("insert", "cover_story_title", "text", "cover_story_title", "cover_story", "invalid_cover_story_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="cover_story_arc"> Cover Story Arc: </label> </td>
<td class="form">
<?php
coverStoryArcSelection("insert");
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
<form action="/OPDatabase/include/formAction/populateModifyForm.inc.php" method="POST">

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
chapterSelection("modify");
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
hiddenChapterField("modify", "chapter_number", "original_chapter_number", "-1");
hiddenChapterField("modify", "chapter_title", "original_chapter_title");
hiddenCoverStoryField("modify", "cover_story_title", "original_cover_story_title");
?>


<tbody>
<tr class="form">
<td class="form"> <label name="chapter_number"> Chapter Number: </label> </td>
<td class="form">
<?php
chapterField("modify", "chapter_number", "number", "chapter_number");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_title"> Chapter Title: </label> </td>
<td class="form">
<?php
chapterField("modify", "chapter_title", "text", "chapter_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_publish_date"> Publish Date: </label> </td>
<td class="form">
<?php
chapterField("modify", "chapter_publish_date", "date", "chapter_publish_date");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_volume_number"> Volume Number: </label> </td>
<td class="form">
<?php
chapterVolumeNumberSelection("modify");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_story_arc"> Story Arc: </label> </td>
<td class="form">
<?php
chapterStoryArcSelection("modify");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="cover_story_title"> Cover Story Title: </label> </td>
<td class="form">
<?php
coverStoryField("insert", "cover_story_title", "text", "cover_story_title");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="cover_story_arc"> Cover Story Arc: </label> </td>
<td class="form">
<?php
coverStoryArcSelection("modify");
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
chapterSelection("delete");
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
coverStorySelection("delete");
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
displayAllChapters();
?>
</div>

</body>
</html>
