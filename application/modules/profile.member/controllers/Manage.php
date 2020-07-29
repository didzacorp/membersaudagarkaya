<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manage extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('users.login/member_model');
		$this->load->model('users.login/users_model');
		$this->load->model('profile_model');
		
	}

	public function index()
	{
		$data = array();
		$data['content'] = 'manage';
		$data['title'] = 'Profile';
		$data['profile'] = $this->profile_model->get($this->session->userdata('id'));
		
		$this->load->view($data['content'],$data);
	}

	function saveLead()
	{
		error_reporting(0);
		$alamat = $this->input->post('alamat');
		$telpn = $this->input->post('telpn');

		if (!$alamat) {
			$this->error('Nama Wajib diisi');
		}

		if (!$telpn) {
			$this->error('No Telpn Wajib diisi');
		}
			$dataMember = array();
			$dataMember['id'] = $this->session->userdata('id'); 
			$dataMember['alamat'] = $alamat; 
			$dataMember['nomor_telepon'] = $telpn; 
			$saveMember = $this->member_model->save($dataMember);

		if ($saveMember) {
			$this->success('Behasil Prossess');
		}else{
			$this->error('Gagal Prossess');
		}
	}

	function saveProfile()
	{
		error_reporting(0);
		$alamat = $this->input->post('alamat');
		$telpn = $this->input->post('telpn');

		if (!$alamat) {
			$this->error('Nama Wajib diisi');
		}

		if (!$telpn) {
			$this->error('No Telpn Wajib diisi');
		}

		$ekstensi_diperbolehkan	= array('png','jpg','gif');
		$nama = $_FILES['file']['name'];
		$x = explode('.', $nama);
		$ekstensi = strtolower(end($x));
		$ukuran	= $_FILES['file']['size'];
		$file_tmp = $_FILES['file']['tmp_name'];	
		$dataMember = array();
		// echo move_uploaded_file($file_tmp, 'assets/images/profile/'.$nama);exit;
		if(in_array($ekstensi, $ekstensi_diperbolehkan) === true){
		    if($ukuran < 90440700){			
				move_uploaded_file($file_tmp, 
					'assets/images/profile/'.$this->session->userdata('id').'_'.$this->session->userdata('username').'.'.$ekstensi
				);								
				$dataMember['foto'] = $this->session->userdata('id').'_'.$this->session->userdata('username').'.'.$ekstensi; 							
			// if($query){
			// 	echo 'FILE BERHASIL DI UPLOAD';
			// }else{
			// 	echo 'GAGAL MENGUPLOAD GAMBAR';
			// }
		    }else{
				$this->error('UKURAN FILE TERLALU BESAR');
		    }
       }else{
			$this->error('EKSTENSI FILE YANG DI UPLOAD TIDAK DI PERBOLEHKAN');
       }
       	$dataMember['id'] = $this->session->userdata('id'); 
		$dataMember['alamat'] = $alamat; 
		$dataMember['nomor_telepon'] = $telpn;
		$saveMember = $this->member_model->save($dataMember);
		if ($saveMember) {
			$this->success('Behasil Prossess');
		}else{
			$this->error('Gagal Prossess');
		} 
			
	}

	function saveBank()
	{
		error_reporting(0);
		$nama_rekening = $this->input->post('nama_rekening');
		$nama_bank = $this->input->post('nama_bank');
		$nomor_rekening = $this->input->post('nomor_rekening');

		if (!$nama_rekening) {
			$this->error('Nama rekening Wajib diisi');
		}

		if (!$nama_bank) {
			$this->error('Nama bank Wajib diisi');
		}

		if (!$nomor_rekening) {
			$this->error('Nomor rekening Wajib diisi');
		}
			$dataMember = array();
			$dataMember['id'] = $this->session->userdata('id'); 
			$dataMember['nama_rekening'] = $nama_rekening; 
			$dataMember['nama_bank'] = $nama_bank; 
			$dataMember['nomor_rekening'] = $nomor_rekening; 
			$saveMember = $this->member_model->save($dataMember);

		if ($saveMember) {
			$this->success('Behasil Prossess');
		}else{
			$this->error('Gagal Prossess');
		}
	}

	function savePassword()
	{
		error_reporting(0);
		$old_pass = $this->input->post('old_pass');
		$new_pass = $this->input->post('new_pass');
		$kon_pass = $this->input->post('kon_pass');
		$checkPass  =  $this->users_model->get(array('id_member' =>  $this->session->userdata('id')));
		if ($old_pass =='' || $new_pass =='' || $kon_pass =='') {
			$this->error('Semua inputan wajib diisi!');
		}
		if (md5($old_pass) != $checkPass['password']) {
			// echo md5($checkPass['password']).' (database) | (input)'.md5($old_pass) ;
			$this->error('Password Lama Salah');
		}
		if ($new_pass != $kon_pass) {
			$this->error('Password Baru Tidak Sama');
		}

		

			$dataMember = array();
			$dataMember['id'] = $checkPass['id']; 
			$dataMember['password'] = $kon_pass; 
			$saveMember = $this->users_model->save($dataMember);

		if ($saveMember) {
			$this->success('Behasil Prossess');
		}else{
			$this->error('Gagal Prossess');
		}
	}
	
	
}