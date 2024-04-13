<?php
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require 'dbh.inc.php';
?>

<link rel="stylesheet" href="/OPDatabase/css/formTable.css">

<table class="form">
<form action="/OPDatabase/include/query/deleteChapter.inc.php" method="POST">

<tr class="form">
<th class="form" colspan="2"> <h2> Delete Chapter </h2> <th>
</tr>

<tr class="form">
<td class="form"> <label name="chapter_number"> Volume Number: </label> </td> 
<td class="form"> <select name="chapter_number">
<?php
try {

	$select_query = "SELECT *
		FROM _chapter;";

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
else {
	echo "<option value='NULL'> No Chapter </option>";
}
?>

</select> </td>
</tr>

<tr class="form">
<td class="form"> <input type="submit" value="Submit"> </td>
</form>

</table>
