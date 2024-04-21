<?php declare(strict_types=1); require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function selectCharactersWithMaxChapter(object $pdo, int $max_chapter) {
	$query = "SELECT _character.id
		FROM _character
		WHERE _character._info_cache_introduced IN (SELECT _info_cache.id 
		FROM _info_cache
		WHERE _info_cache.publish_date <= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter)));";	

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":max_chapter", $max_chapter);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function sortQueryIdsByName(object $pdo, int $max_chapter, $ids) {

	$ids_parameters = str_repeat('?,', count($ids) - 1) . '?';	

	$query = "SELECT T1.id
		FROM (SELECT _character.id
		FROM _character
		WHERE _character.id IN (" . $ids_parameters . ")) AS T1
		LEFT JOIN (SELECT _name.name, _name._character_id, T2.publish_date
		FROM _name
		INNER JOIN (SELECT *
		FROM _info_cache
		WHERE _info_cache.publish_date <= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = ?))) AS T2
		ON _name._info_cache_reveal = T2.id
		GROUP BY _name._character_id
		ORDER BY T2.publish_date DESC) AS T3
		ON T1.id = T3._character_id
		ORDER BY T3.name IS NULL, T3.name ASC;";


	$stmt = $pdo->prepare($query);

	$stmt->execute(array_merge($ids, [$max_chapter]));
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $results;
}

function selectSortedCharacterNames(object $pdo, int $character_id, int $max_chapter) {
	$query = "SELECT _name.name
		FROM _name
		INNER JOIN (SELECT *
		FROM _info_cache
		WHERE _info_cache.publish_date <= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter)))  AS T1
		ON _name._info_cache_reveal = T1.id
		WHERE _name._character_id = :character_id
		ORDER BY T1.publish_date DESC;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":max_chapter", $max_chapter);	
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectSortedCharacterEpithets(object $pdo, int $character_id, int $max_chapter) {
	$query = "SELECT _epithet.epithet
		FROM _epithet
		INNER JOIN (SELECT *
		FROM _info_cache
		WHERE _info_cache.publish_date <= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter)))  AS T1
		ON _epithet._info_cache_reveal = T1.id
		WHERE _epithet._character_id = :character_id
		ORDER BY T1.publish_date DESC;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":max_chapter", $max_chapter);	
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectSortedCharacterCurrentOccupations(object $pdo, int $character_id, int $max_chapter) {
	$query = "SELECT occupation_name, organization_name
		FROM (SELECT occupation_name, _organization.name AS organization_name, T3._info_cache_invalid
		FROM (SELECT _occupation_type.name AS occupation_name, T2.*
		FROM (SELECT *
		FROM _occupation
		INNER JOIN (SELECT *
		FROM _info_cache
		WHERE _info_cache.publish_date <= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter))) AS T1
		ON _occupation._info_cache_reveal = T1.id 
		WHERE _occupation._character_id = :character_id
		ORDER BY T1.publish_date DESC) AS T2
		INNER JOIN _occupation_type
		ON _occupation_type.id = T2._occupation_type_id) AS T3
		INNER JOIN _organization
		ON _organization.id = T3._organization_id) AS T4
		LEFT JOIN (SELECT *
		FROM _info_cache
		WHERE _info_cache.publish_date <= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter)))  AS T5
		ON T4._info_cache_invalid = T5.id
		WHERE T5.publish_date IS NULL OR T5.publish_date >= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter));";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":max_chapter", $max_chapter);	
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;

}

function selectSortedCharacterPreviousOccupations(object $pdo, int $character_id, int $max_chapter) {
	$query = "SELECT occupation_name, organization_name
		FROM (SELECT occupation_name, _organization.name AS organization_name, T3._info_cache_invalid
		FROM (SELECT _occupation_type.name AS occupation_name, T2.*
		FROM (SELECT *
		FROM _occupation
		INNER JOIN (SELECT *
		FROM _info_cache
		WHERE _info_cache.publish_date <= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter))) AS T1
		ON _occupation._info_cache_reveal = T1.id 
		WHERE _occupation._character_id = :character_id
		ORDER BY T1.publish_date DESC) AS T2
		INNER JOIN _occupation_type
		ON _occupation_type.id = T2._occupation_type_id) AS T3
		INNER JOIN _organization
		ON _organization.id = T3._organization_id) AS T4
		LEFT JOIN (SELECT *
		FROM _info_cache
		WHERE _info_cache.publish_date <= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter)))  AS T5
		ON T4._info_cache_invalid = T5.id
		WHERE T5.publish_date < (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter));";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":max_chapter", $max_chapter);	
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;

}

function selectSortedCharacterCurrentRelationships(object $pdo, int $character_id, int $max_chapter) {
	$query = "SELECT _relationship_type.name, T3._character_a, T3._character_b
		FROM (SELECT *
		FROM (SELECT _relationship_type_id, _character_a, _character_b, _info_cache_invalid
		FROM _relationship
		INNER JOIN (SELECT *
		FROM _info_cache
		WHERE _info_cache.publish_date <= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter))) AS T1
		ON _relationship._info_cache_reveal = T1.id 
		WHERE _relationship._character_a = :character_id
		ORDER BY T1.publish_date DESC) AS T2
		LEFT JOIN _info_cache
		ON T2._info_cache_invalid = _info_cache.id
		WHERE _info_cache.publish_date IS NULL OR _info_cache.publish_date >= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter))) AS T3
		INNER JOIN _relationship_type
		ON _relationship_type.id = T3._relationship_type_id";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":max_chapter", $max_chapter);	
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;

}

function selectSortedCharacterPreviousRelationships(object $pdo, int $character_id, int $max_chapter) {
	$query = "SELECT _relationship_type.name, T3._character_a, T3._character_b
		FROM (SELECT *
		FROM (SELECT _relationship_type_id, _character_a, _character_b, _info_cache_invalid
		FROM _relationship
		INNER JOIN (SELECT *
		FROM _info_cache
		WHERE _info_cache.publish_date <= (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter))) AS T1
		ON _relationship._info_cache_reveal = T1.id 
		WHERE _relationship._character_a = :character_id
		ORDER BY T1.publish_date DESC) AS T2
		LEFT JOIN _info_cache
		ON T2._info_cache_invalid = _info_cache.id
		WHERE _info_cache.publish_date < (SELECT _info_cache.publish_date
		FROM _info_cache
		WHERE _info_cache.id = (SELECT _chapter._info_cache_id
		FROM _chapter
		WHERE _chapter.number = :max_chapter))) AS T3
		INNER JOIN _relationship_type
		ON _relationship_type.id = T3._relationship_type_id";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":max_chapter", $max_chapter);	
	$stmt->bindParam(":character_id", $character_id);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;

}
