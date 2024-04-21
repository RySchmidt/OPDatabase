<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "search/searchModel.inc.php";

function extractIds($ids) {
	$temp_ids = [];
	foreach ($ids as $id) {
		array_push($temp_ids, $id["id"]);
	}
	return $temp_ids;
}

function getValidIds(object $pdo, int $max_chapter) {
	return selectCharactersWithMaxChapter($pdo, $max_chapter);
}

function sortIdsByName(object $pdo, int $max_chapter, $ids) {
	return sortQueryIdsByName($pdo, $max_chapter, $ids);
}

function getSortedCharacterNames(object $pdo, int $character_id, int $max_chapter) {
	return selectSortedCharacterNames($pdo, $character_id, $max_chapter);
}

function getSortedCharacterEpithets(object $pdo, int $character_id, int $max_chapter) {
	return selectSortedCharacterEpithets($pdo, $character_id, $max_chapter);
}

function getSortedCharacterCurrentOccupations(object $pdo, int $character_id, int $max_chapter) {
	return selectSortedCharacterCurrentOccupations($pdo, $character_id, $max_chapter);
}

function getSortedCharacterPreviousOccupations(object $pdo, int $character_id, int $max_chapter) {
	return selectSortedCharacterPreviousOccupations($pdo, $character_id, $max_chapter);
}

function getSortedCharacterCurrentRelationships(object $pdo, int $character_id, int $max_chapter) {
	return selectSortedCharacterCurrentRelationships($pdo, $character_id, $max_chapter);
}

function getSortedCharacterPreviousRelationships(object $pdo, int $character_id, int $max_chapter) {
	return selectSortedCharacterPreviousRelationships($pdo, $character_id, $max_chapter);
}
