<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Penjualan_model extends CI_Model
{
	var $column_order = array(
		'id_nota',
		'id_nota',
		'pelanggan.nama',
		'tanggal',
		'subtotal',
	);
	var $column_search = array(
		'id_nota',
		'id_nota',
		'pelanggan.nama',
		'tanggal',
		'subtotal',
	);

	var $order = array('id_nota' => 'asc'); // default order


	function getList($cond = null)
	{
		$this->_get_datatables_query($cond);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query($cond = null)
	{

		$this->db->select(array(
			'penjualan.*, pelanggan.nama'
		));
		$this->db->from('penjualan');
		$this->db->join('pelanggan', 'pelanggan.id_pelanggan=penjualan.id_pelanggan', 'left');
		if ($cond) {
			$this->db->where($cond);
		}
		// $whereSess = "(bast.created_by_2w='$username' OR bast.created_by_4w='$username')";
		// $this->db->where($whereSess);

		$i = 0;

		foreach ($this->column_search as $item) // lojoining awal
		{
			if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
			{

				if ($i === 0) // lojoining awal
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function count_new($cond = null)
	{
		if ($cond) {
			$this->db->where($cond);
		}
		$this->db->select(array(
			'penjualan.*, pelanggan.nama'
		));
		$this->db->from('penjualan');
		$this->db->join('pelanggan', 'pelanggan.id_pelanggan=penjualan.id_pelanggan', 'left');
		return $this->db->count_all_results();
	}

	function count_filtered_new($cond = null)
	{
		$this->_get_datatables_query($cond);
		if ($cond) {
			$this->db->where($cond);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	function insert($data)
	{
		return $this->db->insert('penjualan', $data);
	}

	function insertItemPenjualan($data)
	{
		return $this->db->insert_batch('item_penjualan', $data);
	}

	function update($data, $cond)
	{
		$this->db->where($cond);
		return $this->db->update('penjualan', $data);
	}


	function getOne($cond = null)
	{
		$this->db->select(array(
			'penjualan.*',
			'pelanggan.nama'
		));
		if ($cond) {
			$this->db->where($cond);
		}
		$this->db->from('penjualan');
		$this->db->join('pelanggan', 'pelanggan.id_pelanggan=penjualan.id_pelanggan', 'left');
		return $this->db->get()->result_array();
	}

	function getItemPenjualan($cond = null)
	{
		$this->db->select(array(
			'item_penjualan.*',
			'barang.nama',
			'barang.harga'
		));
		if ($cond) {
			$this->db->where($cond);
		}
		$this->db->from('item_penjualan');
		$this->db->join('barang', 'barang.kode=item_penjualan.kode', 'left');
		return $this->db->get()->result_array();
	}

	function delete($cond)
	{
		if($cond) {
			$this->db->where($cond);
			return $this->db->delete('penjualan');
		} else {
			return false;
		}
	}

	function deleteItemPenjualan($cond)
	{
		if($cond) {
			$this->db->where($cond);
			return $this->db->delete('item_penjualan');
		} else {
			return false;
		}
	}

	function get_barang($cond = null) {
		if($cond) {
			$this->db->where($cond);
		}
		return $this->db->get("barang")->result_array();
	}

	function get_pelanggan() {
		return $this->db->get("pelanggan")->result_array();
	}
}
