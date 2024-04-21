<?php
declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';
require_once "infoCache/infoCacheModel.inc.php";

function getInfoCacheFromId(object $pdo, int $info_cache_id) {
	return selectInfoCacheFromId($pdo, $info_cache_id);
}

function getAllInfoCacheSelection(object $pdo) {
	return selectAllInfoCacheSelection($pdo);
}

function getRestrictedInfoCacheSelection(object $pdo, int $min_info_cache_id = -1, int $max_info_cache_id = -1) {
	return selectRestrictedInfoCacheSelection($pdo, $min_info_cache_id, $max_info_cache_id);
}

function isCacheRestricted(object $pdo, int $info_cache_id, int $min_info_cache_id = -1, int $max_info_cache_id = -1) {
	if (!(selectRestrictedInfoCacheSelection($pdo, $info_cache_id, $min_info_cache_id)
		|| selectRestrictedInfoCacheSelection($pdo, $max_info_cache_id, $info_cache_id))) {
		return false;
	}
	return true;
}

