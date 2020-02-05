<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once APPPATH.'/libraries/REST_Controller.php';

class Admin extends REST_Controller {
	public function __Construct()
	{
		header('Access-Control-Allow-Origin: *');
	    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
	    header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
	    $method = $_SERVER['REQUEST_METHOD'];
	    if($method == "OPTIONS") {
	        die();
	    }
		parent::__construct();
		$this->load->model('AdminModel','am');
		$this->date = date('Y-m-d H:i:s');
	}

	public function mainFunction($method)
	{
		if($method != 'POST'){
			$this->response(['status' => 400,'message' =>'Bad request.']);
		}else{
			$check_auth_client = $this->am->check_auth_client();
			if($check_auth_client == true){
				return true;
			}else{
				return false;
			}
		}
	}

	//super admin login
	public function login_post()
	{
		$method = $_SERVER['REQUEST_METHOD'];
 		$res = $this->mainFunction($method);
     	if($res == 1){
			if(!$this->post('email') && !$this->post('password')){
				$this->response(['status'=> 404,'message' =>"Some Perameters Are Missing!"]);
			}else{
				$result = $this->am->check_userlogin('users u',['u.email' => $this->post('email'), 'u.password' =>  md5($this->post('password'))]);
				if(count($result) > 0){
					$this->response(['status'=> 200,'message' =>"Login Successfully.",'result' => $result]);
				}else{
					$this->response(['status'=> 404,'message' =>"Invalid Details, Please enter proper details"]);
				}
			}
		}else{
			$this->response(['status' => 401,'message' =>'Unauthorized.']);
		}
	}

	// get Group Roles List
	public function getGroups_get()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->response(['status' => 400,'message' =>'Bad request.']);
		} else {
			$check_auth_client = $this->am->check_auth_client();
			if($check_auth_client == true){
				$result = $this->am->geGroupDetails("user_group", ['user_type' => 0])->result_array();
				$this->response(['status'=> 200,'message' =>"Users Groups",'result' => $result]);
			}else{
				$this->response(['status' => 401,'message' =>'Unauthorized.']);
			}
		}
	}

	//get Entity Users List (Admin)
	public function getUsers_get()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->response(['status' => 400,'message' =>'Bad request.']);
		} else {
			$check_auth_client = $this->am->check_auth_client();
			if($check_auth_client == true){
				$result = $this->am->getUsersDetails("users u", ['u.group_id' => 1])->result_array();
				$this->response(['status'=> 200,'message' =>"Users List",'result' => $result]);
			}else{
				$this->response(['status' => 401,'message' =>'Unauthorized.']);
			}
		}
	}

	//Create Entity Users
	public function inserAdmin_post()
	{
		$method = $_SERVER['REQUEST_METHOD'];
 		$res = $this->mainFunction($method);
     	if($res == 1){
			if(!$this->post('email') && !$this->post('mobile') && !$this->post('password')){
				$this->response(['status'=> 404,'message' =>"Some Perameters Are Missing!"]);
			}else{
				$userObj = [
					'group_id' => $this->post('group_id'),
					'username' => $this->post('username'),
					'email' => $this->post('email'),
					'mobile' => $this->post('mobile'),
					'dob' => $this->post('dob'),
					'sex' => 'M',
					'password' => md5($this->post('password')),
					'raw_password' => $this->post('password'),
					'last_login' => $this->date,
					'ip' => "",
					'address' => "",
					'created_at' => $this->date,
					'updated_at' => $this->date
				];

				$inserid = $this->am->insertData("users", $userObj);
				if($inserid){
					$this->response(['status'=> 200,'message' =>"User Created Successfully.",'result' => true]);
				}else{
					$this->response(['status'=> 209,'message' =>"Oops! Somthing went wrong."]);
				}
			}
		}else{
			$this->response(['status' => 401,'message' =>'Unauthorized.']);
		}
	}

	//currency
	public function getCurrencyList_get()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->response(['status' => 400,'message' =>'Bad request.']);
		} else {
			$check_auth_client = $this->am->check_auth_client();
			if($check_auth_client == true){
				$result = $this->am->geCurrencyList("currency", [])->result_array();
				$this->response(['status'=> 200,'message' =>"Currency List",'result' => $result]);
			}else{
				$this->response(['status' => 401,'message' =>'Unauthorized.']);
			}
		}
	}

	// get Stores list
	public function getStoresList_post()
	{
		$method = $_SERVER['REQUEST_METHOD'];
 		$res = $this->mainFunction($method);
     	if($res == 1){
			if(!$this->post('user_id')){
				$this->response(['status'=> 404,'message' =>"Some Perameters Are Missing!"]);
			}else{
				//get Store list based on Entity user
				$result = $this->am->geStoreDetails("stores", ['user_id' => $this->post('user_id')])->result_array();
				$this->response(['status'=> 200,'message' =>"Stores List",'result' => $result]);
			}
		}else{
			$this->response(['status' => 401,'message' =>'Unauthorized.']);
		}
	}

	//create Store
	public function insertStore_post()
	{
		$method = $_SERVER['REQUEST_METHOD'];
 		$res = $this->mainFunction($method);
     	if($res == 1){
			if(!$this->post('user_id') && !$this->post('name') && !$this->post('code_name') && !$this->post('mobile') && !$this->post('email')){
				$this->response(['status'=> 404,'message' =>"Some Perameters Are Missing!"]);
			}else{
				//get Store list based on Entity user
				$store = [
					'user_id' => $this->post('user_id'), 
					'name' => $this->post('name'), 
					'code_name' => $this->post('code_name'), 
					'mobile' => $this->post('mobile'), 
					'email' => $this->post('email'), 
					'country' => $this->post('country'), 
					'zip_code' => $this->post('zip_code'), 
					'currency' => $this->post('currency'), 
					/*'vat_reg_no' => , 
					'cashier_id' => , */
					'address' => $this->post('address'), 
					/*'receipt_printer' => , 
					'cash_drawer_codes' => , 
					'char_per_line' => , 
					'remote_printing' => , 
					'printer' => , 
					'order_printers' => , 
					'auto_print' => , 
					'local_printers' => , 
					'logo' => , 
					'favicon' => , 
					'preference' => , 
					'sound_effect' => , 
					'sort_order' => , 
					'feedback_status' => , 
					'feedback_at' => , 
					'deposit_account_id' => ,*/ 
					'thumbnail' => "", 
					'status' => 1, 
					'created_at' => $this->date
				];

				$inserid = $this->am->insertData("stores", $store);
				if($inserid){
					$this->response(['status'=> 200,'message' =>"Store Created Successfully.",'result' => $inserid]);
				}else{
					$this->response(['status'=> 209,'message' =>"Oops! Somthing went wrong."]);
				}
			}
		}else{
			$this->response(['status' => 401,'message' =>'Unauthorized.']);
		}
	}

	// Medicine List
	public function getMedicineList_get()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->response(['status' => 400,'message' =>'Bad request.']);
		} else {
			$check_auth_client = $this->am->check_auth_client();
			if($check_auth_client == true){
				$result = $this->am->geMedicineList("medicine m", [])->result_array();
				$this->response(['status'=> 200,'message' =>"Medicines List",'result' => $result]);
			}else{
				$this->response(['status' => 401,'message' =>'Unauthorized.']);
			}
		}
	}

	//Create Medicine
	public function createMedicine_post()
	{
		$method = $_SERVER['REQUEST_METHOD'];
 		$res = $this->mainFunction($method);
     	if($res == 1){
			if(!$this->post('name') && !$this->post('generic_name') && !$this->post('medicine_type_id') && !$this->post('category_id')){
				$this->response(['status'=> 404,'message' =>"Some Perameters Are Missing!"]);
			}else{
				$medicineObj = [
					'name'=> $this->post('name'),
					'generic_name'=> $this->post('generic_name'),
					'box_size'=> $this->post('box_size'), 
					'unit_id'=> $this->post('unit_id'),
					'medicine_shelf'=> $this->post('medicine_shelf'),
					'details'=> $this->post('details'),
					'barcode'=> $this->post('barcode'),
					'medicine_type_id'=> $this->post('medicine_type_id'),
					'image'=> $this->post('image'),
					'category_id'=> $this->post('category_id'),
					'created_at' => $this->date
				];
				
				$inserId = $this->am->insertData('medicine', $medicineObj);
				if($inserId > 0){
					$this->response(['status'=> 200,'message' =>"Medicine Created Successfully.",'result' => $inserId]);
				}else{
					$this->response(['status'=> 209,'message' =>"Oops! Somthing went wrong."]);
				}
			}
		}else{
			$this->response(['status' => 401,'message' =>'Unauthorized.']);
		}
	}

	// GET Categories list 
	public function getCategories_get()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->response(['status' => 400,'message' =>'Bad request.']);
		} else {
			$check_auth_client = $this->am->check_auth_client();
			if($check_auth_client == true){
				$result = $this->am->geCategoriesList("categorys", [])->result_array();
				$this->response(['status'=> 200,'message' =>"Categories List",'result' => $result]);
			}else{
				$this->response(['status' => 401,'message' =>'Unauthorized.']);
			}
		}
	}

	// GET Units list
	public function getUnits_get()
	{
		$method = $_SERVER['REQUEST_METHOD'];
		if($method != 'GET'){
			$this->response(['status' => 400,'message' =>'Bad request.']);
		} else {
			$check_auth_client = $this->am->check_auth_client();
			if($check_auth_client == true){
				$result = $this->am->geUnitsList("units", [])->result_array();
				$this->response(['status'=> 200,'message' =>"Categories List",'result' => $result]);
			}else{
				$this->response(['status' => 401,'message' =>'Unauthorized.']);
			}
		}
	}
}
