<?php
defined('BASEPATH') or exit('No direct script access allowed');

class penjualan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->plugins_path_css = array();
		$this->plugins_path_js = array();
		$this->css_path = array();
		$this->js_path = array();

		// Model
		$this->load->model('penjualan_model', 'penjualan');
	}

	public function index()
	{
		$this->plugins_path_css = array(
			'datatables-bs4/css/dataTables.bootstrap4.min.css',
			'datatables-responsive/css/responsive.bootstrap4.min.css',
			'sweetalert2-theme-bootstrap-4/bootstrap-4.min.css',
			'datepicker/css/bootstrap-datepicker.min.css',
			'select2/css/select2.min.css',
			'select2-bootstrap4-theme/select2-bootstrap4.min.css',
		);
		$this->plugins_path_js = array(
			'datatables/jquery.dataTables.min.js',
			'datatables-bs4/js/dataTables.bootstrap4.min.js',
			'datatables-responsive/js/dataTables.responsive.min.js',
			'datatables-responsive/js/responsive.bootstrap4.min.js',
			'sweetalert2/sweetalert2.min.js',
			'jquery-validation/jquery.validate.min.js',
			'jquery-validation/additional-methods.min.js',
			'moment/moment.min.js',
			'datepicker/js/bootstrap-datepicker.min.js',
			'select2/js/select2.full.min.js',
		);
		$this->js_path = array(
			'pages/penjualan.js?x=' . time(),
			'helper/date.js',
		);
		$data_barang = $this->penjualan->get_barang();
		$data_pelanggan = $this->penjualan->get_pelanggan();
		$data = array(
			'header_title' => "Data Penjualan",
			'plugins_path_css' => $this->plugins_path_css,
			'plugins_path_js' => $this->plugins_path_js,
			'css_path' => $this->css_path,
			'js_path' => $this->js_path,
			'data_barang' => $data_barang,
			'data_pelanggan' => $data_pelanggan,
		);
		$this->template->load('default', 'penjualan/index', $data);
	}


	public function getList()
	{
		$cond = null;
		$list = $this->penjualan->getList($cond);
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $field) {
			// $no++;
			$row = array();
			$btnEdit = "";
			$btnDelete = "";
			$btnView = "";

			$btnEdit = '<span><button type="button" class="btn btn-outline-info btn-sm" onclick="edit(\'' . ($field->id_nota) . '\')"><i class="fa fa-edit"></i> Edit</button></span>';
			$btnDelete = '<span><button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteData(\'' . ($field->id_nota) . '\')"><i class="fa fa-trash"></i> Delete</button></span>';
			$btnView = '<span><button type="button" class="btn btn-outline-success btn-sm" onclick="view(\'' . ($field->id_nota) . '\')"><i class="fa fa-eye"></i> View</button></span>';
			$btn = " <div class='d-none d-sm-block d-sm-none d-md-block'>$btnEdit $btnView $btnDelete</div>";
			$btn .= "   <div class='input-group-prepend d-md-none d-lg-none d-xl-none '>
                          <button type='button' class='btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                          </button>
                          <div class='dropdown-menu'>
                            <div class='dropdown-item' href='javasctipy:;'>$btnEdit $btnView $btnDelete</div>
                          </div>
                        </div>";
			$row[] = $btn;
			$row[] = $field->id_nota;
			$row[] = $field->nama;
			$row[] = $field->tanggal;
			$row[] = $field->subtotal;
			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->penjualan->count_new($cond),
			"recordsFiltered" => $this->penjualan->count_filtered_new($cond),
			"data"            => $data,
		);
		//output dalam format JSON

		echo json_encode($output);
	}

	function save()
	{
		$id_nota = $this->input->post('id_nota');
		$id_pelanggan = $this->input->post('id_pelanggan');
		$tanggal = $this->input->post('tanggal');
		$kode = $this->input->post('id_barang');
		$qty = $this->input->post('qty');
		$total = $this->input->post('total');


		$data['penjualan'] = array(
			"id_pelanggan" => $id_pelanggan,
			"tanggal" => $tanggal,
			"subtotal" => $total,
		);
		$cond = array(
			'id_nota' => $id_nota
		);
		$this->db->trans_begin();
		if ($id_nota) {
			for ($i = 0; $i < count($kode); $i++) {
				$item_penjualan[] = array(
					'id_nota' => $id_nota,
					'kode' => $kode[$i],
					'qty' => $qty[$i],
				);
			}

			$this->penjualan->deleteItemPenjualan(array('id_nota' => $id_nota));
			$this->penjualan->update($data['penjualan'], $cond);
			$this->penjualan->insertItemPenjualan($item_penjualan);
		} else {
			$this->penjualan->insert($data['penjualan']);
			$id_nota = $this->db->insert_id();
			for ($i = 0; $i < count($kode); $i++) {
				$item_penjualan[] = array(
					'id_nota' => $id_nota,
					'kode' => $kode[$i],
					'qty' => $qty[$i],
				);
			}
			
			$this->penjualan->insertItemPenjualan($item_penjualan);
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$err = $this->db->error();
			$msg = $err["code"] . "-" . $err["message"];
			$res = array(
				'is_success' => false,
				'message' =>  $msg
			);
		} else {
			$this->db->trans_commit();
			if ($id_nota) {
				$res = array(
					'is_success' => true,
					'message' => "Berhasil Update Data",
				);
			} else {
				$res = array(
					'is_success' => true,
					'message' => "Berhasil Menambahkan Data",
				);
			}
		}
		echo json_encode($res);
	}

	public function getOne()
	{
		$id_nota = $this->input->post('id');
		$cond = array(
			'id_nota' => $id_nota
		);

		$data = $this->penjualan->getOne($cond);
		$item_penjualan = $this->penjualan->getItemPenjualan($cond);
		echo json_encode(array(
			"penjualan" => isset($data[0]) ? $data[0] : null,
			"item_penjualan" => isset($item_penjualan[0]) ? $item_penjualan : null,
		));
	}

	function delete()
	{


		$id_nota = $this->input->post('uid');

		$cond = array(
			"id_nota" => $id_nota,
		);

		if ($this->penjualan->delete($cond)) {
			$res = array(
				'is_success' => true,
				'message' => "Berhasil Menghapus Data Penjualan",
			);
		} else {
			$err = $this->db->error();
			$msg = $err["code"] . "-" . $err["message"];
			$res = array(
				'is_success' => false,
				'message' =>  $err
			);
		}
		echo json_encode($res);
	}

	function getHarga()
	{
		$kode = $this->input->post('id');
		$cond = array(
			'kode' => $kode
		);
		$data_barang = $this->penjualan->get_barang($cond);
		$output = array(
			'data' => isset($data_barang[0]) ? $data_barang[0] : null
		);
		echo json_encode($output);
	}
}
