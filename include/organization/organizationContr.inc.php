<?php
declare(strict_types=1); require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "organization/organizationModel.inc.php";

function addOrganization(object $pdo, string $organization_name, int $info_cache_id) {
	insertOrganization($pdo, $organization_name, $info_cache_id);
}

function modifyOrganization(object $pdo, int $organization_id, string $organization_name, int $info_cache_id) {	
	updateOrganization($pdo, $organization_id, $organization_name, $info_cache_id);
}

function removeOrganization(object $pdo, int $organization_id) {		
	deleteOrganization($pdo, $organization_id);
}

function isOrganizationNameUnique(object $pdo, string $organization_name) {
	if (selectOrganizationFromName($pdo, $organization_name)) {
		return false;
	}
	return true;
}	

function getOrganizationFromId(object $pdo, int $organization_id) {
	return selectOrganizationFromId($pdo, $organization_id);
}

function getAllOrganization(object $pdo) {
	return selectOrganization($pdo);
}

function getOrganizationInputDisplay(object $pdo) {
	return selectOrganizationInfoCache($pdo);
}
