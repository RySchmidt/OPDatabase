function sortTable(tableId, sortItem, isNumber) {

	var keepSorting, swap;
	var flipSort = true;
	var sortAssending = true;
	var table = document.getElementById(tableId);

	do {

		keepSorting = false;
		var rows = table.rows;

		for (var i = 1; i < (rows.length - 1); i++) {
			swap = false;

			var x = rows[i].getElementsByTagName("TD")[sortItem];
			var y = rows[i + 1].getElementsByTagName("TD")[sortItem];

			if (sortAssending) {

				if (x.innerHTML == "" || y.innerHTML == "") {
					if (y.innerHTML != "") {
						swap = true;	
						break;
					}
				}
				else if (!isNumber) {
					if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
						swap = true;
						break;
					}
				}
				else {
					if (parseInt(x.innerHTML) > parseInt(y.innerHTML)) {
						swap = true;
						break;
					}
				}
			}
			else {
				if (x.innerHTML == "" || y.innerHTML == "") {
					if (y.innerHTML != "") {
						swap = true;	
						break;
					}
				}
				//Sort non-numbers z to a
				else if (!isNumber) {
					if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
						swap = true;
						break;
					}
				}

				//Sort numbers greatest to least
				else {
					if (parseInt(x.innerHTML) < parseInt(y.innerHTML)) {
						swap = true;
						break;
					}
				}
			}
		}
		if (swap) {
			rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);	
			flipSort = false;
			keepSorting = true;
		}
		else if (flipSort && sortAssending) {
			flipSort = sortAssending = false;
			keepSorting = true;
		}
	} while (keepSorting);
}

