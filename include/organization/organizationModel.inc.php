<?php declare(strict_types=1);
require_once $_SERVER["DOCUMENT_ROOT"] . '/OPDatabase/config.php';

function insertOrganization(object $pdo, string $organization_name, int $info_cache_id) {

	$query = "INSERT 
		INTO _organization (name, _info_cache_introduced) 
		VALUES (:organization_name, :info_cache_id);";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":organization_name", $organization_name);
	$stmt->bindParam(":info_cache_id", $info_cache_id);

	$stmt->execute();
}

function updateOrganization(object $pdo, int $organization_id, string $organization_name, int $info_cache_id) {

	$query = "UPDATE _organization
		SET _organization.name = :organization_name, _organization._info_cache_introduced= :info_cache_id
		WHERE _organization.id = :organization_id;";

	$stmt = $pdo->prepare($query);	
	$stmt->bindParam(":organization_id", $organization_id);
	$stmt->bindParam(":organization_name", $organization_name);
	$stmt->bindParam(":info_cache_id", $info_cache_id);

	$stmt->execute();
}

function deleteOrganization(object $pdo, int $organization_id) {

	$query = "DELETE
		FROM _organization 
		WHERE _organization.id = :organization_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":organization_id", $organization_id);

	$stmt->execute();
}

function selectOrganizationFromId(object $pdo, int $organization_id) {
	$query = "SELECT *
		FROM _organization 
		WHERE _organization.id = :organization_id;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":organization_id", $organization_id);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}

function selectOrganizationFromName(object $pdo, string $organization_name) {
	$query = "SELECT *
		FROM _organization
		WHERE _organization.name = :organization_name;";

	$stmt = $pdo->prepare($query);
	$stmt->bindParam(":organization_name", $organization_name);

	$stmt->execute();
	$results = $stmt->fetch(PDO::FETCH_ASSOC);
	return $results;
}	

function selectOrganization(object $pdo) {
	$query = "SELECT *
		FROM _organization
		ORDER BY _organization.name ASC;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}

function selectOrganizationInfoCache(object $pdo) {
	$query = "SELECT _organization.id AS organization_id, _organization.name AS organization_name, _info_cache_selection.*
		FROM _organization
		INNER JOIN  _info_cache_selection
		ON _organization._info_cache_introduced = _info_cache_selection.id
		ORDER BY _info_cache_selection.publish_date;";

	$stmt = $pdo->prepare($query);

	$stmt->execute();
	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $results;
}
