var x = 1; //Initial field counter is 1
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
			url: `${base_url}penjualan/getList`,
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
			var valid = true;
			$(".select_barang").each(function () {
				if (!$(this).val()) {
					$(this).addClass("is-invalid");
					valid = false;
				}
			});
			$(".qty").each(function () {
				if (!$(this).val() || $(this).val() == "0") {
					$(this).addClass("is-invalid");
					valid = false;
				}
			});
			if (!valid) {
				return false;
			}
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
			id_pelanggan: {
				required: true,
			},
			tanggal: {
				required: true,
			},
			id_barang: {
				required: true,
			},
			qty: {
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
	$(".modalHeaderText").html("Add New Penjualan");
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
		url: `${base_url}penjualan/getOne`,
		dataType: "json",
		success: function (e) {
			$(".modalHeaderText").html(`Detail Penjualan ${e.penjualan.id_nota}`);
			var d = new Date();
			var t = d.getTime();
			var tr_barang = ``;
			$.each( e.item_penjualan, function( key, obj ) {
				tr_barang += `
				<tr>
				<td>${obj.nama}</td>
				<td>${obj.qty}</td>
				</tr>`;
			  });
			  
			var table_barang = `<table>
			<tbody>
			<tr>
			<td>Nama Barang</td>
			<td>Quantity</td>
			</tr>
			${tr_barang}
			</tbody>
			</table>`;
			$("#body-view").html(
				`<div class="row">
				<div class="col-md-6 col-sm-12">
					<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<th style="width:50%">Id Nota :</th>
								<td>${e.penjualan.id_nota}</td>
							</tr>
							<tr>
								<th>Nama Pelanggan:</th>
								<td>${e.penjualan.nama}</td>
							</tr>
							<tr>
								<th>Tanggal:</th>
								<td>${e.penjualan.tanggal}</td>
							</tr>
							<tr>
								<th>Total:</th>
								<td>${e.penjualan.subtotal}</td>
							</tr>
							<tr>
								<th>Barang:</th>
								<td>${table_barang}</td>
							</tr>
						</tbody>
					</table>
				</div>
				 </div>
				 <div class="col-md-6 col-sm-12">
				 <div class="text-center">
				 <a href="${ base_url + "assets/dist/img/avatar04.png"
					}?x=${t}" class="profile-img-clickable">
					<img class="rounded img-fluid" src="${
						base_url + "assets/dist/img/avatar04.png"
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
	$(".modalHeaderText").html("Edit Penjualan");
	showModal();
	jQuery.ajax({
		type: "post",
		data: {
			id: e,
		},
		url: `${base_url}penjualan/getOne`,
		dataType: "json",
		success: function (e) {
			if (e.penjualan) {
				jQuery("#id_nota").val(e.penjualan.id_nota);
				jQuery("#id_pelanggan").val(e.penjualan.id_pelanggan).trigger("change");
				jQuery("#tanggal").val(e.penjualan.tanggal);
				var row_barang = $('.row_barang').length;
				for (i = 0; i < e.item_penjualan.length; i++) {
					if (i <= 0) {
						$(`#id_barang_${i}`)
						.val(e.item_penjualan[i].kode)
						.trigger("change");
						$(`#qty_${i}`).val(e.item_penjualan[i].qty).trigger("change");
					} else if (i > 0) {
						if(row_barang<=i) {
							addForm();
						}
						$(`#id_barang_${i}`)
							.val(e.item_penjualan[i].kode)
							.trigger("change");
						$(`#qty_${i}`).val(e.item_penjualan[i].qty).trigger("change");
					}
				}
			}
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
				url: `${base_url}penjualan/delete`,
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
	// $(".select2bs4").val("").trigger("change");
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

var maxField = 10; //Input fields increment limitation
var addButton = $(".add_button"); //Add button selector
var wrapper = $(".append_barang"); //Input field wrapper
var barang_option = $("#id_barang_0").html();

function addForm() {
	var fieldHTML = `<div class="row row_barang" id="row_${x}">
					<div class="col-sm-4">
						<div class="form-group">
							<label>Nama Barang</label>
							<select name="id_barang[]" id="id_barang_${x}" data-id_row="${x}" class="form-control select2bs4 select-form select_barang" style="width: 100%;">
								${barang_option}
							</select>
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>Harga</label>
							<input type="text" name="harga_barang[]" id="harga_barang_${x}" data-id_row="${x}" class="form-control harga_barang" placeholder="harga barang" readonly>
						</div>
					</div>
					<div class="col-sm-1">
						<div class="form-group">
							<label>Quantity</label>
							<input type="number" name="qty[]" id="qty_${x}" data-id_row="${x}" min="0" class="form-control qty" placeholder="Quantity">
						</div>
					</div>
					<div class="col-sm-3">
						<div class="form-group">
							<label>Sub Total</label>
							<input type="text" name="sub_total[]" id="sub_total_${x}" data-id_row="${x}" class="form-control sub_total" placeholder="Sub Total" readonly>
						</div>
					</div>
					<div class="col-sm-1">
						<div class="form-group">
							<label></label>
							<a class="btn btn-default btn-sm remove_button" id="remove_button_${x}">Hapus Barang</a>
						</div>
					</div>
				</div>`; //New input field html
	//Check maximum number of input fields
	if (x < maxField) {
		x++; //Increment field counter
		$(wrapper).append(fieldHTML); //Add field html
		$(".select2bs4").select2({
			theme: "bootstrap4",
			placeholder: "Pilih salah satu...",
			allowClear: true,
		});
	}
}
$(addButton).click(function () {
	console.log(x)
	addForm();
});

//Once remove button is clicked
$(wrapper).on("click", ".remove_button", function (e) {
	e.preventDefault();
	$(this).closest(".row").remove(); //Remove field html
	x--; //Decrement field counter
});

$(wrapper).on("change", ".select_barang", function (e) {
	e.preventDefault();
	var row_id = $(this).attr("data-id_row");
	var is_added = (function () {
		var is_added = false;
		var curr_id = $(`#id_barang_${row_id}`).val();
		var same_id = 0;
		$(".select_barang").each(function () {
			if (curr_id == $(this).val() && curr_id) {
				same_id++;
			}
		});
		if (same_id > 1) {
			is_added = true;
		}
		return is_added;
	})();
	if (is_added) {
		$(`#id_barang_${row_id}`).val("").trigger("change");
		Swal.fire({
			title: "Warning",
			text: "Barang Yang Di Pilih Sudah Ada Dalam List",
			icon: "warning",
		});
		return;
	}
	var harga = (function () {
		var harga = 0;
		jQuery.ajax({
			type: "POST",
			global: true,
			async: false,
			data: {
				id: $(`#id_barang_${row_id}`).val(),
			},
			url: `${base_url}penjualan/getHarga`,
			dataType: "json",
			success: function (res) {
				if (res.data) {
					harga = res.data.harga;
				}
			},
			error: function (xhr, status, error) {
				Swal.fire({ title: "Error", text: error, icon: "error" });
			},
		});
		return harga;
	})();
	$(`#harga_barang_${row_id}`).val(harga);
});

$(wrapper).on("change", ".qty", function (e) {
	var row_id = $(this).attr("data-id_row");
	var qty = $(this).val();
	var harga = $(`#harga_barang_${row_id}`).val();
	$(`#sub_total_${row_id}`)
		.val(qty * harga)
		.trigger("change");
});

$(wrapper).on("change", ".sub_total", function (e) {
	calculateTotal();
});

function calculateTotal() {
	var sum = 0;
	$(".sub_total").each(function () {
		sum += +$(this).val();
	});
	$("#total").val(sum);
}
