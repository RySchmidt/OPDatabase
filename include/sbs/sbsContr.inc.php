<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "sbs/sbsModel.inc.php";

function addSBS(object $pdo, int $sbs_number, string $publish_date, int $volume_number) {
	insertSBS($pdo, $sbs_number, $publish_date, $volume_number);
}

function modifySBS(object $pdo, int $sbs_info_cahce_id, int $sbs_number, string $publish_date) {
	updateSBS($pdo, $sbs_info_cahce_id, $sbs_number, $publish_date);
}

function removeSBS(object $pdo, int $sbs_number) {		
	deleteSBS($pdo, $sbs_number);
}

function isSBSNumberUnique(object $pdo, int $sbs_number) {
	if (selectSBSFromNumber($pdo, $sbs_number)) {
		return false;
	}
	return true;
}	

function getSBSFromVolumeNumber(object $pdo, int $volume_number) {
	return selectSBSFromVolumeNumber($pdo, $volume_number);
}

function getSBSFromInfoCacheId(object $pdo, int $sbs_info_cache_id) {
	return selectSBSFromInfoCacheId($pdo, $sbs_info_cach_id);
}

function viewInfoCacheSBS(object $pdo) {
	updateInfoCacheSBS($pdo);
}

function getAllSBSs(object $pdo) {
	return selectAllInfoCacheSBSs($pdo);
}
