<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "name/nameModel.inc.php";

function addName(object $pdo, string $name, int $character_id, int $info_cache_id) {
	insertName($pdo, $name, $character_id, $info_cache_id);
}

function modifyName(object $pdo, string $original_name, string $name, int $character_id, int $original_info_cache_id, int $info_cache_id) {
	updateName($pdo, $original_name, $name, $character_id, $original_info_cache_id, $info_cache_id);
}

function removeName(object $pdo, string $name, int $character_id, int $info_cache_id) {
	return deleteName($pdo, $name, $character_id, $info_cache_id);
}

function isNameUnique(object $pdo, string $name, int $character_id, int $info_cache_id) {
	if (selectName($pdo, $name, $character_id, $info_cache_id)) {
		return true;
	}
	return false;
}

function getNameFromCharacterId(object $pdo, int $character_id) {
	return selectNameFromCharacterId($pdo, $character_id);
}

function getNameDisplayFromCharacterId(object $pdo, int $character_id) {
	return selectAdvancedNameFromCharacterId($pdo, $character_id);
}
