<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include 'application/libraries/SimpleEmailService.php';

class Manage extends MY_Controller {

	function __construct()
	{
		parent::__construct();

		$this->load->model('transaksi_model');
		$this->load->model('users.login/users_model');
		$this->load->model('users.login/member_model');

	}

	public function index()
	{
		$data = array();
		$data['content'] = 'manage';
		$data['title'] = 'My Lead';

		$this->load->view($data['content'],$data);
	}

	function page($pg=1)
	{
		$limit = 10;
		$where = array();
		$where['tbl.upline_level_1'] = $this->session->userdata('id');
		// $where['tbl.jenis_transaksi'] = "PENDAFTARAN MEMBER (BASIC)";
		$this->member_model->set_order(array('id' => 'DESC'));
		$this->member_model->set_where($where);
		//
		// order by
		$orderBy = array();
		// if($filter['shortby']){
			// $orderBy[$filter['shortby']] = $filter['orderby'];
		// }
		// $orderBy['tbl.Lokasi'] = 'DESC';
		$this->member_model->set_order($orderBy);
		//
		$list = $this->member_model->get_list();
		$this->member_model->set_limit($limit);
		$this->member_model->set_offset($limit * ($pg - 1));
		// echo $this->db->last_query();exit;
		//
		$page = array();
		$page['limit'] 		= $limit;
		$page['count_row'] 	= $list->num_rows();
		$page['current'] 	= $pg;
		$page['load_func_name'] = 'pageLoadLead';
		$page['list'] 		= $this->gen_paging($page);
		//
		$data = array();
		$data['content'] = 'list';
		$data['list'] = $this->member_model->get_list();
		// $data['key'] = $filter;
		$data['paging'] = $page;
		$this->load->view($data['content'],$data);
	}

	public function inputLead()
	{
		$data = array();
		$data['content'] = 'input';
		$data['title'] = 'My Lead';

		$this->load->view($data['content'],$data);
	}

	function saveLead()
	{
		error_reporting(0);
		$nama = $this->input->post('nama');
		$email = $this->input->post('email');
		$telpn = $this->input->post('telpn');

		if (!$nama) {
			$this->error('Nama Wajib diisi');
		}

		if (!$email) {
			$this->error('Email Wajib diisi');
		}

		if (!$telpn) {
			$this->error('Nomor Telpn Wajib diisi');
		}

		// $this->update['idTrans'] = $this->transaksi_model->getLastID();



			$subject = 'Pendaftaran Saudagar kaya';
			$html_body =  "<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Pearl UI</title>
    <link rel='stylesheet' href='<?= base_url();?>assets/ui-member/css/style.css'>
</head>

<body>
    <div class='container-scroller'>

        <div class='container-fluid page-body-wrapper'>

            <div class='main-panel' style='width: 100%;'>
                <div class='content-wrapper' style='padding: 1%;'>
                    <div class='row'>
                        <div class='col-12 grid-margin'>
                            <div class='card'>
                                <h4 class='card-title ' style='text-align: center;background: #529fef;color: white;padding: 1%;'>
                   Pendaftaran Saudagar Kaya
                </h4>
                                <div class='card-body' style='padding: 1%;'>
                                    <p class='card-description' style='text-align: center;'>
                                        <img src='http://member.saudagarkaya.com/assets/ui-member/images/logo/logo.png' style='width: 245px;'>
                                    </p>
                                    <hr>
                                    <h3>Hallo ".$nama." , selamat bergabung dengan kami berikut akun member anda</h3>
									<table>
										<tr>
											<td>Email </td>
											<td>:</td>
											<td>".$email."</td>
										</tr>
										<tr>
											<td>Password </td>
											<td>:</td>
											<td>membersaudagar</td>
										</tr>
										<tr>
											<td colspan='3'>Silahkan login <a href='http://member.saudagarkaya.com'>disini</a></td>
										</tr>
									</table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</html>";

			// $email =  'support@saudagarkaya.com';

			// //---------------------
			// $m = new SimpleEmailServiceMessage();
			// // $m->addTo($data['transaksi']['email_pembeli']);
			// $m->addTo($email);
			// $m->setFrom('support@saudagarkaya.com');
			// $m->setSubject($subject);
			// $m->setMessageFromString('',$html_body);

			// $ses = new SimpleEmailService('AKIAQBXG7F42UTEVWIJW', 'BIcZplisnAwqjmJ0n2tmU9+0E6n0FPZcAshEhYeoZ2c5');
			// $ses->sendEmail($m);

			$dataMember = array();
			$dataMember['id'] = 0;
			$dataMember['nama'] = $nama;
			$dataMember['username'] = substr($email,0,6).$this->session->userdata('id');
			$dataMember['email'] = $email;
			$dataMember['nomor_telepon'] = $telpn;
			$dataMember['lisensi'] = 'FREE';
			$dataMember['upline_level_1'] = $this->session->userdata('id');
			$dataMember['tanggal_join'] = date('Y-m-d H:i:s');
			$saveMember = $this->member_model->save($dataMember);

			$data = array();
			$data['id'] = 	 0;
			$data['id_member'] = $this->member_model->getLastID();
			$data['email'] = $email;
			$data['password'] = md5('membersaudagar');
			$data['status'] = 	'AKTIF';
			$data['hak_akses'] = 	 'MEMBER';
			$data['create_date'] = 	 date('Y-m-d H:i:s');

			$save = $this->users_model->save($data);

			// $email =  'support@saudagarkaya.com';

			$data = array('email_penerima' => $email , 'subjek_email' => $subject, "body_email" => $html_body);
			$curl = curl_init('http://admin.saudagarkaya.com/sendEmail.php') ;
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_exec($curl);

			$data = array('email_penerima' => "admin@saudagarkaya.com" , 'subjek_email' => "MEMBER BARU", "body_email" => "
			<html>
				<body>
				 <h4> NAMA : $nama <br>
				 	EMAIL : $email <br>
					NOMOR WA : $telpn
					</h4>
				 <h5> Segera follow up </h6>
				</body>

			</html>
			");
			$curl = curl_init('http://admin.saudagarkaya.com/sendEmail.php') ;
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_exec($curl);

			$getMember =  $this->member_model->get(array('id' => $this->session->userdata('id')));
			$data = array('email_penerima' => $getMember['email'] , 'subjek_email' => "MEMBER BARU", "body_email" => "
			<html>
				<body>
				<body>
				<h4> NAMA : $nama <br>
				 EMAIL : $email <br>
				 NOMOR WA : $telpn
				 </h4>
				<h5> Segera follow up </h6>
			 </body>
				</body>

			</html>
			");
			$curl = curl_init('http://admin.saudagarkaya.com/sendEmail.php') ;
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_exec($curl);


		if ($save) {
			$this->success('Behasil Prossess');
		}else{
			$this->error('Gagal Prossess');
		}
	}

}
