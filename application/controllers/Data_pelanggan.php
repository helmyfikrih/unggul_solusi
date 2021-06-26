<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Data_pelanggan extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->plugins_path_css = array();
		$this->plugins_path_js = array();
		$this->css_path = array();
		$this->js_path = array();

        // Model
        $this->load->model('pelanggan_model', 'pelanggan');
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
            'pages/pelanggan.js?x='.time(),
            'helper/date.js',
        );
        $data = array(
            'header_title' => "Data Pelanggan",
            'plugins_path_css' => $this->plugins_path_css,
            'plugins_path_js' => $this->plugins_path_js,
            'css_path' => $this->css_path,
            'js_path' => $this->js_path,
        );
		$this->template->load('default', 'pelanggan/index', $data);
	}

	
    public function getList()
    {
		$cond = null;
        $list = $this->pelanggan->getList($cond);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            // $no++;
            $row = array();
            $btnEdit = "";
            $btnDelete = "";
            $btnView = "";

			$btnEdit = '<span><button type="button" class="btn btn-outline-info btn-sm" onclick="edit(\'' . ($field->id_pelanggan) . '\')"><i class="fa fa-edit"></i> Edit</button></span>';
			$btnDelete = '<span><button type="button" class="btn btn-outline-danger btn-sm" onclick="deleteData(\'' . ($field->id_pelanggan) . '\')"><i class="fa fa-trash"></i> Delete</button></span>';
            $btnView = '<span><button type="button" class="btn btn-outline-success btn-sm" onclick="view(\'' . ($field->id_pelanggan) . '\')"><i class="fa fa-eye"></i> View</button></span>';
            $btn = " <div class='d-none d-sm-block d-sm-none d-md-block'>$btnEdit $btnView $btnDelete</div>";
            $btn .= "   <div class='input-group-prepend d-md-none d-lg-none d-xl-none '>
                          <button type='button' class='btn btn-default dropdown-toggle dropdown-icon' data-toggle='dropdown'>
                          </button>
                          <div class='dropdown-menu'>
                            <div class='dropdown-item' href='javasctipy:;'>$btnEdit $btnView $btnDelete</div>
                          </div>
                        </div>";
            $row[] = $btn;
            $row[] = $field->id_pelanggan;
            $row[] = $field->nama;
            $row[] = $field->domisili;
            $row[] = $field->jenis_kelamin;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->pelanggan->count_new($cond),
            "recordsFiltered" => $this->pelanggan->count_filtered_new($cond),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }

	function save()
    {
        $id_pelanggan = $this->input->post('id_pelanggan');
        $nama = $this->input->post('nama');
        $domisili = $this->input->post('domisili');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $data['pelanggan'] = array(
            "nama" => $nama,
            "domisili" => $domisili,
            "jenis_kelamin" => $jenis_kelamin,
        );
        $cond = array(
            'id_pelanggan' => $id_pelanggan
        );
        $this->db->trans_begin();
        if ($id_pelanggan) {
			$this->pelanggan->update($data['pelanggan'], $cond);
        } else {
			$this->pelanggan->insert($data['pelanggan']);
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
            if ($id_pelanggan) {
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
        $id_pelanggan = $this->input->post('id');
		$cond = array(
			'id_pelanggan' => $id_pelanggan
		);
        $data = $this->pelanggan->getOne($cond);
        echo json_encode($data);
    }

	function delete()
    {


        $id_pelanggan = $this->input->post('uid');

        $cond = array(
            "id_pelanggan" => $id_pelanggan,
        );

        if ($this->pelanggan->delete($cond)) {
            $res = array(
                'is_success' => true,
                'message' => "Berhasil Menghapus Data Pelanggan",
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
}
