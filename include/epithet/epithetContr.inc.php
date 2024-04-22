<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "epithet/epithetModel.inc.php";

function addEpithet(object $pdo, string $epithet, int $character_id, int $info_cache_id) {
	insertEpithet($pdo, $epithet, $character_id, $info_cache_id);
}

function modifyEpithet(object $pdo, string $original_epithet, string $epithet, int $character_id, int $original_info_cache, int $info_cache_id) {
	updateEpithet($pdo, $original_epithet, $epithet, $character_id, $original_info_cache, $info_cache_id);
}

function removeEpithet(object $pdo, string $epithet, int $character_id, int $info_cache_id) {
	return deleteEpithet($pdo, $epithet, $character_id, $info_cache_id);
}

function isEpithetUnique(object $pdo, string $epithet, int $character_id, int $info_cache_id) {
	if (selectEpithet($pdo, $epithet, $character_id, $info_cache_id)) {
		return true;
	}
	return false;
}

function getEpithet(object $pdo, string $epithet, int $character_id, int $info_cache_id) {
	return (selectEpithet($pdo, $epithet, $character_id, $info_cache_id));
}

function getEpithetFromCharacterId(object $pdo, int $character_id) {
	return selectEpithetFromCharacterId($pdo, $character_id);
}

function getEpithetDisplayFromCharacterId(object $pdo, int $character_id) {
	return selectAdvancedEpithetFromCharacterId($pdo, $character_id);
}
