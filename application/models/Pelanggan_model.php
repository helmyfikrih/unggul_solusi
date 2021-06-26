<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class pelanggan_model extends CI_Model
{
	var $column_order = array(
		'id_pelanggan',
		'id_pelanggan',
		'nama',
		'jenis_kelamin',
		'domisili',
	);
	var $column_search = array(
		'id_pelanggan',
		'id_pelanggan',
		'nama',
		'jenis_kelamin',
		'domisili',
	);

	var $order = array('id_pelanggan' => 'asc'); // default order


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
			'*'
		));
		$this->db->from('pelanggan');
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
			'*'
		));
		$this->db->from('pelanggan');
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
		return $this->db->insert('pelanggan', $data);
	}

	function update($data, $cond)
	{
		$this->db->where($cond);
		return $this->db->update('pelanggan', $data);
	}


	function getOne($cond = null)
	{
		$this->db->select(array(
			'*'
		));
		if ($cond) {
			$this->db->where($cond);
		}
		$this->db->from('pelanggan');
		return $this->db->get()->result_array();
	}

	function delete($cond)
	{
		if($cond) {
			$this->db->where($cond);
			return $this->db->delete('pelanggan');
		} else {
			return false;
		}
	}
}
