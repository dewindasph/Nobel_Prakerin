<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Apinobel extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */
	public function index(){	   
	   	$this->db->select('*');
	   	$this->db->from("nobel_mm_uji_hasil");
	  	$data = $this->db->get()->result_array();
	   	die(json_encode($data));
	}

	public function getbyid(){
		$id = $this->input->get("id");
		$this->db->select('*');
		$this->db->where("id", $id);
		$this->db->from("nobel_mm_uji_hasil");
		$data = $this->db->get()->row_array();
		die(json_encode($data));
	}

	public function alluser(){
		$this->db->select('*');
		$this->db->from("prakerin_user");
		$data = $this->db->get()->result_array();
	   	die(json_encode($data));
	}

	public function postuser(){
		$data = array(
			'firstName' => $this->input->post('firstName'),
           	'lastName' => $this->input->post('lastName'),
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password'))
        	);
			
		// cek if duplicate entry
		// $insert = $this->db->insert('prakerin_user', $data);
		$SQL = "SELECT * FROM prakerin_user WHERE username = '". $this->input->post('username') ."' 
				AND password = '". md5($this->input->post('password')) ."'";
		$hasil = $this->db->query($SQL);
		
		
		if($hasil){	
			die("Data dimaksud Sudah ada Sebelumnya");
		}
		
		if($insert){
			$response = array(
				"pesan" => "Data Berhasil disimpan",
				"data"	=> $data
			);
		}
		else{
			$response = array(
				"pesan" => "Data Gagal disimpan"
			);
		}
		die(json_encode($response));
   	}

	public function getbyuser(){
		$id = $this->input->get("id");	   
	   	$this->db->select('*');
		$this->db->where("id", $id);	   	
		$this->db->from("prakerin_user");
	  	$data = $this->db->get()->row_array();
	   	
		if($data){
			$response = array(
				"pesan" => "Data Berhasil ditemukan",
				"data" => $data
			);
		}
		else{
			$response = array(
				"pesan" => "Data Gagal ditemukan"
			);
		}
		die(json_encode($response));
    }

	public function deleteUser(){
		$id = $this->input->get('id');

		$SQL = "DELETE FROM prakerin_user WHERE id = '".$id."'";
		$res = $this->db->query($SQL);

		if($res){
			$response = array(
				"pesan" => "Data Berhasil dihapus"
			);
		}
		else{
			$response = array(
				"pesan" => "Data Gagal dihapus"
			);
		}
		die(json_encode($response));
	 }

	public function loginUser(){
		$this->db->select('*');
		$this->db->from('prakerin_user');	
		$this->db->where('username', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$login = $this->db->get()->row_array();

		$ada = 0;
		if($login){
			foreach($login as $v){
				$ada++;
			}
		}

		if($ada > 0){
			$response = array(
				"pesan" => "Login berhasil"
			);

		}
		else{
			$response = array(
				"pesan" => "Login gagal"
			);
		}
		die(json_encode($response));
   	}
	
}