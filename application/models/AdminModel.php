<?php 
class AdminModel extends CI_Model
{
	public function __construct()
	{
       	parent::__construct();
    }

    var $auth_key       = "itkRestApi";

    public function check_auth_client(){
        $auth_key  = $this->input->get_request_header('Auth-Key', TRUE);

        if($auth_key == $this->auth_key){
            return true;
        } else {
        	return true;
        }
    }

    public function insertData($tablename,$data)
	{
		$this->db->insert($tablename,$data);
		return $this->db->insert_id();
	}

	public function updateData($tablename,$set,$whr)
	{
		$this->db->set($set)->where($whr)->update($tablename);
		return true;
	}
	
	public function deleteData($tablename,$data)
	{
		$this->db->where($data)->delete($tablename);
		return true;
	}

	public function selectAllWhere($tablename,$data)
	{
		$query = $this->db->where($data)->get($tablename);	
		return $query;
	}

	public function check_userlogin($tableName,$whr)
	{
		$result = array();
		$this->db->select('u.*, ug.name as groupName, ug.slug, ug.permission');
		$this->db->from($tableName);
		$this->db->where($whr);
		$this->db->join('user_group ug','u.group_id=ug.group_id','INNER');
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function getUsersDetails($tableName, $whr)
	{
		$this->db->select('u.*, ug.name as groupName, ug.slug');
		$this->db->from($tableName);
		$this->db->where($whr);
		$this->db->join('user_group ug','u.group_id=ug.group_id','INNER');
		$result = $this->db->get();
		return $result;
	}

	public function geGroupDetails($tableName, $whr)
	{
		$this->db->select('group_id, name, slug, sort_order, status');
		$this->db->from($tableName);
		$this->db->where($whr);
		$result = $this->db->get();
		return $result;
	}

	public function geStoreDetails($tableName, $whr)
	{
		$this->db->select('*');
		$this->db->from($tableName);
		$this->db->where($whr);
		$result = $this->db->get();
		return $result;
	}

	public function geCurrencyList($tableName, $whr)
	{
		$this->db->select('currency_id, title, code');
		$this->db->from($tableName);
		$this->db->where($whr);
		$result = $this->db->get();
		return $result;
	}

	public function geMedicineList($tableName, $whr)
	{
		$this->db->select('m.*, c.category_name, u.unit_name');
		$this->db->from($tableName);
		$this->db->where($whr);
		$this->db->join('categorys c','m.category_id=c.category_id','INNER');
		$this->db->join('units u','m.unit_id=u.unit_id','INNER');
		$result = $this->db->get();
		return $result;
	}

	public function geCategoriesList($tableName, $whr)
	{
		$this->db->select('category_id, category_name, category_slug, created_at');
		$this->db->from($tableName);
		$this->db->where($whr);
		$result = $this->db->get();
		return $result;
	}

	public function geUnitsList($tableName, $whr)
	{
		$this->db->select('unit_id, unit_name, code_name');
		$this->db->from($tableName);
		$this->db->where($whr);
		$result = $this->db->get();
		return $result;
	}

	public function getGroupPermissions($tableName, $whr)
	{
		$this->db->select('group_id, permission');
		$this->db->from($tableName);
		$this->db->where($whr);
		$result = $this->db->get();
		return $result;
	}
}

?>