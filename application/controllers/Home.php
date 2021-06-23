<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->plugins_path_css = array();
		$this->plugins_path_js = array();
		$this->css_path = array();
		$this->js_path = array();
	}

	public function index()
	{
		$data = array(
			'header_title' => "Home",
			'css_path' => $this->css_path,
			'plugins_path_css' => $this->plugins_path_css,
			'plugins_path_js' => $this->plugins_path_js,
			'js_path' => $this->js_path,
		);
		$this->template->load('default', 'home/index', $data);
	}
}
