<?php
declare(strict_types=1); require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "occupationType/occupationTypeModel.inc.php";

function addOccupationType(object $pdo, string $occupation_type_name) {
	insertOccupationType($pdo, $occupation_type_name);
}

function modifyOccupationType(object $pdo, int $occupation_type_id, string $occupation_type_name) {	
	updateOccupationType($pdo, $occupation_type_id, $occupation_type_name);
}

function removeOccupationType(object $pdo, int $occupation_type_id) {		
	deleteOccupationType($pdo, $occupation_type_id);
}

function isOccupationTypeNameUnique(object $pdo, string $occupation_type_name) {
	if (selectOccupationTypeFromName($pdo, $occupation_type_name)) {
		return false;
	}
	return true;
}	

function getOccupationTypeFromId(object $pdo, int $occupation_type_id) {
	return selectOccupationTypeFromId($pdo, $occupation_type_id);
}

function getAllOccupationType(object $pdo) {
	return selectOccupationType($pdo);
}
