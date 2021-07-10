$(function () {
	$("#user_birth_date").datepicker({
		format: "dd-mm-yyyy",
		autoclose: true,
	});
	$(".select2bs4").select2({
		theme: "bootstrap4",
		placeholder: "Pilih salah satu...",
		allowClear: true,
	});
	var myTable = $("#datatables").DataTable({
		autoWidth: false,
		responsive: false,
		bServerSide: true,
		scrollX: true,
		columnDefs: [
			{
				targets: 0,
				className: "text-center",
				// width: "15%",
			},
		],
		ajax: {
			url: `${base_url}data_barang/getList`,
			type: "POST",
			data: function (d) {
				// d.id_region = $('#region').val();
			},
		},
		initComplete: function (settings, json) {
			$("#datatables_filter input").unbind();
			$("#datatables_filter input").bind("keyup", function (e) {
				if (e.keyCode == 13) {
					myTable.search(this.value).draw();
				}
			});
		},
	});

	$("#accordion3 input:checkbox").click(function () {
		var e = $(this).attr("id");
		var t = $(this).val();

		if ($(this).is(":checked")) {
			$(".down_" + t + " :checkbox").prop("checked", true);
		} else {
			$(".down_" + t + " :checkbox").prop("checked", false);
		}
	});

	$.validator.setDefaults({
		submitHandler: function (form) {
			Swal.fire({
				title: "Apakah Anda Yakin?",
				text: "",
				icon: "question",
				showCancelButton: true,
				confirmButtonColor: "#3085d6",
				cancelButtonColor: "#d33",
				confirmButtonText: "Yes",
			}).then((result) => {
				if (result.value) {
					var myForm = $("#form")[0];
					$.ajax({
						url: $(myForm).attr("action"),
						type: "POST",
						data: new FormData(myForm),
						contentType: false,
						cache: false,
						processData: false,
						dataType: "json",
						success: function (data) {
							response = jQuery.parseJSON(JSON.stringify(data));
							if (response.is_success === true) {
								Swal.fire({
									title: response.message,
									// text: response.message,
									icon: "success",
								});
								$("#form").trigger("reset");
								hideModal();
							} else {
								Swal.fire({
									title: "Warning",
									text: response.message,
									icon: "warning",
								});
							}
							$("#datatables").DataTable().ajax.reload(null, false);
						},
						error: function (xhr, status, error) {
							Swal.fire({ title: "Error", text: error, icon: "error" });
							$("#datatables").DataTable().ajax.reload(null, false);
						},
					});
				}
			});
		},
	});

	$("#form").validate({
		ignore: [],
		rules: {
			nama: {
				required: true,
			},
			kategori: {
				required: true,
			},
			harga: {
				required: true,
			},
		},
		// messages: {
		// 	email: {
		// 		required: "Please enter a email address",
		// 		email: "Please enter a vaild email address",
		// 	},
		// 	password: {
		// 		required: "Please provide a password",
		// 		minlength: "Your password must be at least 5 characters long",
		// 	},
		// },
		errorElement: "span",
		errorPlacement: function (error, element) {
			error.addClass("invalid-feedback");
			element.closest(".form-group").append(error);
		},
		highlight: function (element, errorClass, validClass) {
			$(element).addClass("is-invalid");
		},
		unhighlight: function (element, errorClass, validClass) {
			$(element).removeClass("is-invalid");
		},
	});
});
function addNew() {
	$("#form").trigger("reset");
	$(".modalHeaderText").html("Add New Barang");
	showModal();
	$("#user_password").attr("required", true);
}

function showModal() {
	$("#form").trigger("reset");
	$("#user_password").attr("placeholder", "Password");
	$("#modalAddEdit").modal("show");
}
function hideModal() {
	$("#modalAddEdit").modal("hide");
}

function ngeklik() {
	var e = [];
	$("#accordion3 input:checked").each(function () {
		e.push($(this).val());
	});
	$("#imenu").html(e.toString());
}

function view(e) {
	$("#modalView").modal("show");
	jQuery.ajax({
		type: "post",
		data: {
			id: e,
		},
		url: `${base_url}data_barang/getOne`,
		dataType: "json",
		success: function (e) {
			$(".modalHeaderText").html(`Detail Barang ${e[0].nama}`);
			var d = new Date();
			var t = d.getTime();
			$("#body-view").html(
				`<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<th style="width:50%">Nama :</th>
								<td>${e[0].nama}</td>
							</tr>
							<tr>
								<th>Kategiru:</th>
								<td>${e[0].kategori}</td>
							</tr>
							<tr>
								<th>Keterangan:</th>
								<td>${e[0].keterangan ? e[0].keterangan : '-'}</td>
							</tr>
						</tbody>
					</table>
				</div>
				 </div>
				 <div class="col-md-6 col-sm-12">
				 <div class="text-center">
				 <a href="${
						e[0].ud_img_url
							? e[0].ud_img_url
							: base_url + "assets/dist/img/avatar04.png"
					}?x=${t}" class="profile-img-clickable">
					<img class="rounded img-fluid" src="${
						e[0].ud_img_url
							? e[0].ud_img_url
							: base_url + "assets/dist/img/avatar04.png"
					}?x=${t}" alt="Photo">	
				 </a>
				 </div>
				 </div>
				 </div>
				`
			);
			$(".profile-img-clickable").colorbox({
				rel: "profile-img-clickable",
				transition: "fade",
				scalePhotos: true,
				maxWidth: "100%",
				maxHeight: "100%",
			});
		},
		error: function (xhr, status, error) {
			Swal.fire({ title: "Error", text: error, icon: "error" });
		},
	});
}

function edit(e) {
	$(".modalHeaderText").html("Edit Barang");
	showModal();
	jQuery.ajax({
		type: "post",
		data: {
			id: e,
		},
		url: `${base_url}data_barang/getOne`,
		dataType: "json",
		success: function (e) {
			console.log(e);
			jQuery("#kode").val(e[0].kode);
			jQuery("#nama").val(e[0].nama);
			jQuery("#keterangan").val(e[0].keterangan);
			jQuery("#kategori").val(e[0].kategori).trigger("change");
			jQuery("#harga").val(e[0].harga).trigger("change");
		},
		error: function (xhr, status, error) {
			Swal.fire({ title: "Error", text: error, icon: "error" });
		},
	});
}

function deleteData(uid) {
	Swal.fire({
		title: "Apakah Anda Yakin?",
		text: "Data akan dihapus secara permanen dan tidak dapat dikembalikan.",
		icon: "question",
		showCancelButton: true,
		confirmButtonColor: "#d33",
		cancelButtonColor: "#3085d6",
		confirmButtonText: "Yes",
	}).then((result) => {
		if (result.value) {
			var myForm = $("#form")[0];
			$.ajax({
				url: `${base_url}data_barang/delete`,
				type: "POST",
				data: {
					uid: uid,
				},
				dataType: "json",
				success: function (data) {
					response = jQuery.parseJSON(JSON.stringify(data));
					if (response.is_success === true) {
						Swal.fire({
							title: response.message,
							// text: response.message,
							icon: "success",
						});
					} else {
						Swal.fire({
							title: "Warning",
							text: response.message,
							icon: "warning",
						});
					}
					$("#datatables").DataTable().ajax.reload(null, false);
				},
				error: function (xhr, status, error) {
					Swal.fire({ title: "Error", text: error, icon: "error" });
					$("#datatables").DataTable().ajax.reload(null, false);
				},
			});
		}
	});
}

$("#form").on("reset", function (e) {
	$("#user_birth_date").datepicker("update", "");
	$(".select2bs4").val("").trigger("change");
	$(".is-invalid").removeClass("is-invalid");
});

// Vorm Validation
$(".select-form").on("change", function (e) {
	// Do something
	var is_invalid = $(".is-invalid");
	if (is_invalid.hasClass("is-invalid")) {
		$("#form").valid();
	}
});
$(".date-form").on("change", function (e) {
	// Do something
	var is_invalid = $(".is-invalid");
	if (is_invalid.hasClass("is-invalid")) {
		$("#form").valid();
	}
});
