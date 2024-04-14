function toggleVisibility(checkboxID, toggleFieldsIds) {
	var checkBox = document.getElementById(checkboxID);

	for (i = 0; i < toggleFieldsIds.length; i++) {
		if (checkBox.checked == true) {
			document.getElementById(toggleFieldsIds[i]).style.display = "";	
		}
		else {
			document.getElementById(toggleFieldsIds[i]).style.display = "none";	
		}
	}
}

function toggleRequired(checkboxID, toggleFieldsIds) {
	var checkBox = document.getElementById(checkboxID);

	for (i = 0; i < toggleFieldsIds.length; i++) {
		console.log(document.getElementById(toggleFieldsIds[i]);
		if (checkBox.checked == true) {
			document.getElementById(toggleFieldsIds[i]).setAttribute("required", true);	
		}
		else {
			document.getElementById(toggleFieldsIds[i]).setAttribute("required", false);	
		}
	}
}
