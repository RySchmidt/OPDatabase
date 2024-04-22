<?php
declare(strict_types=1); require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "occupation/occupationModel.inc.php";

function addOccupation(object $pdo, int $occupation_type_id, int $character_id, int $organization_id, int $info_cache_reveal, int $info_cache_invalid) {
	insertOccupation($pdo, $occupation_type_id, $character_id, $organization_id, $info_cache_reveal, $info_cache_invalid);
}

function modifyOccupation(object $pdo, int $original_occupation_type_id, int $original_character_id, int $original_organization_id, int $original_info_cache_reveal, int $occupation_type_id, int $character_id, int $organization_id, int $info_cache_reveal, int $info_cache_invalid) {
	updateOccupation($pdo, $original_occupation_type_id, $original_character_id, $original_organization_id, $original_info_cache_reveal, $occupation_type_id, $character_id, $organization_id, $info_cache_reveal, $info_cache_invalid);
}

function removeOccupation(object $pdo, int $occupation_type_id, int $character_id, int $organization_id, int $info_cache_reveal) {		
	deleteOccupation($pdo, $occupation_type_id, $character_id, $organization_id, $info_cache_reveal);
}

function isUniqueOccupation(object $pdo, int $occupation_type_id, int $character_id, int $organization_id, int $info_cache_reveal) {
	if (selectOccupation($pdo, $occupation_type_id, $character_id, $organization_id, $info_cache_reveal)) {
		return true;
	}
	return false;	
}

function getOccupation(object $pdo, int $occupation_type_id, int $character_id, int $organization_id, int $info_cache_reveal) {
	return selectOccupation($pdo, $occupation_type_id, $character_id, $organization_id, $info_cache_reveal);
}

function getAllOccupation(object $pdo) {
	return selectAllOccupation($pdo);
}

function getAdvancedOccupationFromCharacterId(object $pdo, int $character_id) {
	return selectAdvancedOccupationFromCharacterId($pdo, $character_id);
}

function getOccupationDisplayFromCharacterId(object $pdo, int $character_id) {
	return selectAdvancedOccupationFromCharacterId($pdo, $character_id);
}
