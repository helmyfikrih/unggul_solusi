<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Data Pelanggan</h1>
				</div><!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="#">Home</a></li>
						<li class="breadcrumb-item active">Data Pelanggan</li>
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
							<h3 class="card-title text-left">Data Pelanggan</h3>
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
										<th>ID Pelanggan</th>
										<th>Nama</th>
										<th>Domisili</th>
										<th>Jenis Kelamin</th>
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
					<form role="form" id="form" action="<?= base_url('data_pelanggan/save') ?>">
						<div class="row">
							<div class="col-sm-6">
								<!-- text input -->
								<div class="form-group">
									<label>Nama</label>
									<input type="text" name="id_pelanggan" id="id_pelanggan" class="form-control" placeholder="id_pelanggan" hidden>
									<input type="text" name="nama" id="nama" class="form-control" placeholder="Nama">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="form-group">
									<label>Domisili</label>
									<select name="domisili" id="domisili" class="form-control select2bs4 select-form" style="width: 100%;">
										<option></option>
										<option value="JAK-UT">Jakarta Utara</option>
										<option value="JAK-BAR">Jakarta Barat</option>
										<option value="JAK-SEL">Jakarta Selatan</option>
										<option value="JAK-TIM">Jakarta Timur</option>
									</select>
								</div>

							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Jenis Kelamin</label>
									<select name="jenis_kelamin" id="jenis_kelamin" class="form-control select2bs4 select-form" style="width: 100%;">
										<option></option>
										<option value="PRIA">Pria</option>
										<option value="WANITA">Wanita</option>
									</select>
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
<!-- /.content-wrapper -->
