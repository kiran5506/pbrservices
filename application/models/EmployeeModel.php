<?php 

class EmployeeModel extends CI_Model
{
	public function __construct()
	{
        parent::__construct();
		header('Access-Control-Allow-Origin: *');
		header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
    }

    public function check_userlogin($tableName, $emailmobile,$userpassword)
	{
		$result = array();
		$this->db->select('employee_id, main_role_id, name, mobile_number, email, address, education, father_name, mother_name, emergency_contact, medical_history, k_role, k_sub_role, e_role_id, os_type, device_token, otp');
		$this->db->from($tableName);
		$this->db->where("(email = '$emailmobile' OR mobile_number = '$emailmobile')");
		$this->db->where('password',$userpassword);
		$this->db->where('status',1);
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function checkEmployeeExist($tableName,$email,$mobile)
	{
		$res = 0;
		$this->db->select('employee_id');
		$this->db->from($tableName);
		$this->db->where("(email = '$email' OR mobile_number = '$mobile')");
		$result = $this->db->get()->row_array();
		if($result['employee_id'] != ""){
			$res = $result['employee_id'];
		}
		return $res;
	}

	public function getEmployeeDetails($tableName,$whr)
	{
		$this->db->select('e.employee_id, e.name, e.mobile_number, e.email, e.address, e.education, e.father_name, e.mother_name, e.emergency_contact, e.medical_history, e.k_role, e.k_sub_role, e.e_role_id, e.os_type, e.device_token, e.otp, e.status, d.emp_details_id, d.experience, d.pre_company_name, d.pre_salary, d.job_role, d.typing_speed, d.computer_knowledge, d.msoffice_knowledge, d.communication_skills, d.known_languages');
		$this->db->from($tableName);
		$this->db->join('tbl_employee_details d','e.employee_id=d.emp_details_id','LEFT');
		$this->db->where($whr);
		$result = $this->db->get();
		return $result;
	}

	public function getEmployeesList($tableName,$whr)
	{
		$this->db->select('e.employee_id, e.name, e.main_role_id');
		$this->db->from($tableName);
		$this->db->where($whr);
		$result = $this->db->get();
		return $result;
	}

	public function getEmployeesList_dup($tableName, $whr, $empIds)
	{
		$this->db->select('e.employee_id, e.name, e.mobile_number, e.email, e.address, e.education, e.father_name, e.mother_name, e.emergency_contact, e.medical_history, e.k_role, e.k_sub_role, e.e_role_id, e.os_type, e.device_token, e.otp, e.status, d.emp_details_id, d.experience, d.pre_company_name, d.pre_salary, d.job_role, d.typing_speed, d.computer_knowledge, d.msoffice_knowledge, d.communication_skills, d.known_languages');
		$this->db->from($tableName);
		$this->db->join('tbl_employee_details d','e.employee_id=d.emp_details_id','LEFT');
		$this->db->where($whr);
		$this->db->where_in('e.employee_id', $empIds);
		$result = $this->db->get();
		return $result;
	}

}