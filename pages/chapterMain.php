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
chapterNumberField("insert");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_title"> Chapter Title: </label> </td>
<td class="form">
<?php
chapterTitleField("insert");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_publish_date"> Publish Date: </label> </td>
<td class="form">
<?php
chapterPublishDateField("insert");
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
coverStoryTitleField("insert");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="cover_story_arc_id"> Cover Story Arc: </label> </td>
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
hiddenChapterInfoCacheId("modify");
hiddenChapterNumber("modify");
hiddenChapterTitle("modify");
hiddenCoverStoryTitle("modify");
?>


<tbody>
<tr class="form">
<td class="form"> <label name="chapter_number"> Chapter Number: </label> </td>
<td class="form">
<?php
chapterNumberField("modify");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_title"> Chapter Title: </label> </td>
<td class="form">
<?php
chapterTitleField("modify");
?>
</td>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_publish_date"> Publish Date: </label> </td>
<td class="form">
<?php
chapterPublishDateField("modify");
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
coverStoryTitleField("modify");
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
checkChapterErrors();
checkCoverStoryErrors();
?>
</div>

<div>
<?php
displayAllChapters();
?>
</div>

</body>
</html>
