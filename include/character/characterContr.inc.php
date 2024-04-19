<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "character/characterModel.inc.php";

function addCharacter(object $pdo, int $info_cache_id, string $notes) {
	return insertCharacter($pdo, $info_cache_id, $notes);
}

function modifyCharacter(object $pdo, int $character_id, int $info_cache_id, string $notes) {
	updateCharacter($pdo, $character_id, $info_cache_id, $notes);
}

function removeCharacter(object $pdo, int $character_id) {		
	deleteCharacter($pdo, $character_id);
}

function getCharacterSelection(object $pdo) {
	return selectCharacterSelection($pdo);
}

function getCharacterFromId(object $pdo, int $character_id) {
	return selectCharacterFromId($pdo, $character_id);
}
