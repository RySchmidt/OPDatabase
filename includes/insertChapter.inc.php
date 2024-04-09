<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	
	//Required Data
	$chapter_number = $_POST["chapter_number"];
	$chapter_title = $_POST["chapter_title"];
	$publish_date = $_POST["publish_date"];

	//Optional Data
	$cover_story_id = $_POST["cover_story_id"];
	$volume_number = $_POST["volume_number"];
	$story_arc_id = $_POST["story_arc_id"];

	try {
		require_once "dbh.inc.php";

		//Data Insertion
		$info_cache_query = "INSERT INTO _info_cache (release_date) VALUES (?);";	
		$info_cache_stmt = $pdo->prepare($info_cache_query);
		$info_cache_stmt->execute([$publish_date]);
		
		$info_cache_id = $pdo->lastInsertId("id");
		
		try {
		$chapter_query = "INSERT INTO _chapter (number, title, _info_cache_id, _cover_story_id, _volume_number, _story_arc_id) VALUES (?, ?, ?, ?, ?, ?);";
		$chapter_stmt = $pdo->prepare($chapter_query);
		$chapter_stmt->execute([$chapter_number, $chapter_title, $info_cache_id, $cover_story_id, $volume_number, $story_arc_id]);
		} catch (PDOException $e) {
	
			echo "Query Falied: " . $e->getMessage() . "\n";

			try {
			
			//Delete the unused info_cache truple
			$delete_query = "DELETE FROM _info_cache WHERE _info_cache.id = ?;";
			$delete_stmt = $pdo->prepare($delete_query);
			$delete_stmt->execute([$info_cache_id]);

			echo "Test 1 : " . $info_cache_id . " ";

			$reset_index_query = "ALTER TABLE _info_cache AUTO_INCREMENT = ?;";
			$reset_index_stmt = $pdo->prepare($reset_index_query);
			$reset_index_stmt->execute([$info_cache_id]);

			echo"Test 2";
			die("Killed");

			} catch (PDOException $e) {
	
			die("Sub Query Failed: " . $e->getMessage());
			
			}
		}

		$pdo = null;
		$info_cache_stmt = null;
		$chapter_stmt = null;

		header("Location: ../dataEntry.php");

		die();

	} catch (PDOException $e) {

		die("Query failed: " . $e->getMessage());
	}	
}
else {
	header("Location: ../dataEntry.php");
}
