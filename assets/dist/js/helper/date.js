function formatDate(format, string) {
	var d = new Date(string);
	var dd = d.getDate();

	var mm = d.getMonth() + 1;
	var yyyy = d.getFullYear();
	if (dd < 10) {
		dd = "0" + dd;
	}

	if (mm < 10) {
		mm = "0" + mm;
	}
	switch (format) {
		case "dd-mm-yyyy":
		case "DD-MM-YYYY":
		case "D-M-Y":
			return `${dd}-${mm}-${yyyy}`;
			break;
		case "dd/mm/yyyy":
		case "DD/MM/YYYY":
		case "D/M/Y":
			return `${dd}/${mm}/${yyyy}`;
			break;
		default:
			return `${yyyy}-${mm}-${ddd}`;
	}
}
