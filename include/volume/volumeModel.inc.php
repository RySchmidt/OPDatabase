<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertVolume(object $pdo, int $volume_number, string $volume_title, string $volume_publish_date) {

	$query = "INSERT 
		INTO _volume (number, title, publish_date) 
		VALUES (:volume_number, :volume_title, :volume_publish_date);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":volume_number", $volume_number);
	$stmt->bindParam(":volume_title", $volume_title);
	$stmt->bindParam(":volume_publish_date", $volume_publish_date);	

	$stmt->execute();
}

function updateVolume(object $pdo, int $original_volume_number, int $volume_number, string $volume_title, string $volume_publish_date) {

	$query = "UPDATE _volume
		SET _volume.number = :volume_number, _volume.title = :volume_title, _volume.publish_date = :volume_publish_date
		WHERE _volume.number = :original_volume_number;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":volume_number", $volume_number);
	$stmt->bindParam(":volume_title", $volume_title);
	$stmt->bindParam(":volume_publish_date", $volume_publish_date);	
	$stmt->bindParam(":original_volume_number", $original_volume_number);

	$stmt->execute();
}

function deleteVolume(object $pdo, int $volume_number) {
	$query = "DELETE 
		FROM _volume
		WHERE _volume.number = :volume_number;";

	$stmt = $pdo->prepare($query);

	$stmt->bindParam(":volume_number", $volume_number);

	$stmt->execute();
}

function selectAllVolumes(object $pdo) {
	$query = "SELECT *
		FROM _volume
		ORDER BY _volume.number ASC;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectVolumeFromNumber(object $pdo, int $volume_number) {
	$query = "SELECT *
		FROM _volume
		WHERE _volume.number = :volume_number;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":volume_number", $volume_number);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectAdvancedVolumeFromNumber(object $pdo, int $volume_number) {
	updateAdvancedVolumeView($pdo);
	$query = "SELECT *
		FROM _advanced_volume
		WHERE _advanced_volume.volume_number = :volume_number;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":volume_number", $volume_number);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}
function selectVolumeFromTitle(object $pdo, string $volume_title) {

	$query = "SELECT *
		FROM _volume
		WHERE _volume.title = :volume_title;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":volume_title", $volume_title);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}	

function updateAdvancedVolumeView(object $pdo) {
	$query = "CREATE OR REPLACE VIEW _advanced_volume AS
		SELECT T2.*, _sbs.number AS sbs_number
		FROM (SELECT _volume.number AS volume_number, _volume.title AS volume_title, _volume.publish_date, T1.min_chapter, T1.max_chapter
		FROM _volume
		LEFT JOIN (SELECT _chapter._volume_number, MIN(_chapter.number) AS min_chapter, MAX(_chapter.number) AS max_chapter
		FROM _chapter
		GROUP BY _chapter._volume_number) AS T1
		ON _volume.number = T1._volume_number) AS T2
		LEFT JOIN _sbs
		ON T2.volume_number = _sbs._volume_number;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
}

function selectVolumeInputDisplay(object $pdo) {
	updateAdvancedVolumeView($pdo);
	$query = "SELECT *
		FROM _advanced_volume;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}
