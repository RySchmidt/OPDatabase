<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require 'dbh.inc.php';
?>

<link rel="stylesheet" href="/OPDatabase/css/formTable.css">

<table class="form">
<form action="/OPDatabase/include/query/insertChapter.inc.php" method="POST">

<tr class="form">
<th class="form" colspan="2"> <h2> Insert Chapter </h2> <th>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_number"> Chapter Number: </label> </td>
<td class="form"> <input type="number" name="chapter_number">  </td>
</tr>

<tr class="form">
<td class="form"> <label> Title: </label> </td>
<td class="form"> <input type="text" name="chapter_title">  </td>
</tr>

<tr class="form">
<td class="form"> <label> Publish Date: </label> </td>
<td class="form"> <input type="date" name="chapter_publish_date">  </td> 
</tr>

<tr class="form">
<td class="form"> <label name="volume_number"> Volume Number: </label> </td> 
<td class="form"> <select name="volume_number">
<option value="NULL"> No Volume </option>
<?php
try {

	$select_query = "SELECT *
		FROM _volume;";

	$select_stmt = $pdo->prepare($select_query);
	$select_stmt->execute();

	$query_results = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

	$select_query = NULL;
	$select_stmt = NULL;

} catch (PDOException $e) {
	echo "You should not be here!<br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}	

if (!empty($query_results)) {
	foreach ($query_results as $result) {
		echo "<option value='" . htmlspecialchars($result["number"]) . "'> " . htmlspecialchars($result["number"]) . " </option>";	
	}
}	
?>
</select> </td>
</tr>

<tr class="form">
<td class="form"> <label name="story_arc"> Story Arc: </label> </td>
<td class="form"> <select name="story_arc">
<option value="NULL"> No Arc </option>

<?php
try {

	$select_query = "SELECT *
		FROM _story_arc;";

	$select_stmt = $pdo->prepare($select_query);
	$select_stmt->execute();

	$query_results = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

	$select_query = NULL;
	$select_stmt = NULL;

} catch (PDOException $e) {
	echo "You should not be here!<br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}	

if (!empty($query_results)) {
	foreach ($query_results as $result) {
		echo "<option value='" . htmlspecialchars($result["id"]) . "'> " . htmlspecialchars($result["title"]) . " </option>";	
	}
}	
?>

</select> </td>
</tr>

<tr class="form">
<td class="form"> <label> Cover Story Title: </label> </td> 
<td class="form"> <input type="text" name="cover_story_title">  </td> 
</tr>
</div>

<tr class="form">
<td class="form"> <label name="cover_story_arc"> Cover Story Arc: </label> </td>
<td class="form"> <select name="cover_story_arc">
<option value="NULL"> No Arc </option>
</div>

<?php
try {

	$select_query = "SELECT *
		FROM _story_arc;";

	$select_stmt = $pdo->prepare($select_query);
	$select_stmt->execute();

	$query_results = $select_stmt->fetchAll(PDO::FETCH_ASSOC);

	$select_query = NULL;
	$select_stmt = NULL;

} catch (PDOException $e) {
	echo "You should not be here!<br>";
	die("MySQL query failed: " . $e->getMessage() . "<br>");
}	

if (!empty($query_results)) {
	foreach ($query_results as $result) {
		echo "<option value='" . htmlspecialchars($result["id"]) . "'> " . htmlspecialchars($result["title"]) . " </option>";	
	}
}	
?>

</select> </td>
</tr>

<tr class="form">
<td class="form"> <input type="submit" value="Submit"> </td>
</form>

</table>
