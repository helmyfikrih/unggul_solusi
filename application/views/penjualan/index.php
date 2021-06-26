<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Data Penjualan</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Penjualan</li>
					</ol>
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<!-- Main content -->
	<div class="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					<div class="card">
						<div class="card-header">
							<h3 class="card-title text-left">Data Penjualan</h3>
							<div class="text-right">
								<button type="button" class="btn btn-sm btn-primary" onclick="addNew()">
									<i class="fas fa-plus"></i> Add New
								</button>
							</div>
						</div>
						<!-- /.card-header -->
						<div class="card-body">
							<table id="datatables" class="table table-bordered table-hover">
								<thead>
									<tr>
										<th>Action</th>
										<th>ID Nota</th>
										<th>Nama Pelanggan</th>
										<th>Tanggal Penjualan</th>
										<th>Sub Total</th>
									</tr>
								</thead>
							</table>
						</div>
						<!-- /.card-body -->
					</div>
				</div>
			</div>
			<!-- /.row -->
		</div><!-- /.container-fluid -->
	</div>

	<!-- Modals -->
	<div class="modal fade" id="modalAddEdit" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><span class="modalHeaderText"></span></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="modalBody">
					<form role="form" id="form" action="<?= base_url('penjualan/save') ?>">
						<div class="row">
							<div class="col-sm-6">
								<!-- text input -->
								<div class="form-group">
									<label>Nama Pelanggan</label>
									<input type="text" name="id_nota" id="id_nota" class="form-control" placeholder="id_nota" hidden>
									<select name="id_pelanggan" id="id_pelanggan" class="form-control select2bs4 select-form" style="width: 100%;">
										<option></option>
										<?php foreach ($data_pelanggan as $pelanggan) : ?>
											<option value="<?= $pelanggan['id_pelanggan'] ?>"><?= $pelanggan['nama'] ?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Tanggal</label>
									<input type="date" name="tanggal" id="tanggal" class="form-control" placeholder="Tanggal" value="<?= date('Y-m-d'); ?>">
								</div>
							</div>
						</div>
						<div class="barang_container">
							<div class="append_barang">
								<div class="row row_barang" id="row_0">
									<div class="col-sm-4">
										<div class="form-group">
											<label>Nama Barang</label>
											<select name="id_barang[]" id="id_barang_0" data-id_row="0" class="form-control select2bs4 select_barang select-form" style="width: 100%;">
												<option></option>
												<?php foreach ($data_barang as $barang) : ?>
													<option value="<?= $barang['kode'] ?>"><?= $barang['nama'] ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Harga</label>
											<input type="text" name="harga_barang[]" data-id_row="0" id="harga_barang_0" class="form-control harga_barang" placeholder="harga barang" readonly>
										</div>
									</div>
									<div class="col-sm-1">
										<div class="form-group">
											<label>Quantity</label>
											<input type="number" name="qty[]" data-id_row="0" id="qty_0" min="0" class="form-control qty" placeholder="Quantity">
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label>Sub Total</label>
											<input type="text" name="sub_total[]" data-id_row="0" id="sub_total_0" class="form-control sub_total" placeholder="Sub Total" readonly>
										</div>
									</div>
									<div class="col-sm-1" hidden>
										<div class="form-group">
											<label></label>
											<a class="btn btn-default btn-sm add_button">Tambah Barang</a>
										</div>
									</div>
								</div>
							</div>
							<div class="col-sm-6">
								<a class="btn btn-default btn-sm add_button">Tambah Barang</a>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Total</label>
									<input type="number" min="0" name="total" id="total" class="form-control" placeholder="Total" readonly>
								</div>
							</div>
						</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Save</button>
				</div>
				</form>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" id="modalView" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true">
		<div class="modal-dialog modal-dialog-scrollable modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><span class="modalHeaderText"></span></h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body" id="modalBody">
					<div id="body-view">

					</div>
				</div>
				<div class="modal-footer justify-content-between">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<!-- /.content -->
</div>
