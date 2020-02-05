<?php  
if (!defined('BASEPATH')) exit('No direct script access allowed');
class Settemplate 
{   
    var $CI ,$ID='',$TYPE;
    public function __Construct()
	{   
		$this->CI = & get_instance();
		$this->CI->load->library("template");
	}
   
    public function login($view, $data="", $title="")
  	{
		$this->CI->template->set_template("login");
		
		//$content = $this->CI->load->view($view, $data, true);
		//$this->CI->template->write ('content',$content);
		
		$this->CI->template->write ('title',$title);
		
		/* $menu = $this->CI->load->view("templates/menu",$data, true);
		$this->CI->template->write ('menu',$menu);
		
		$header = $this->CI->load->view("templates/header",$data, true);
		$this->CI->template->write ('header',$header);
		
		$footer = $this->CI->load->view("templates/footer",$data, true);
		$this->CI->template->write ('footer',$footer); */
		
		$this->CI->template->render();
  	}
	
	public function dashboard($view, $data="", $title="")
	{
		$this->CI->template->set_template("dashboard");

		$this->CI->template->write ('title',$title);
		
		$header = $this->CI->load->view("templates/header",$data, true);
		$this->CI->template->write ('header',$header);
		
		$menu = $this->CI->load->view("templates/leftmenu",$data, true);
		$this->CI->template->write ('leftmenu',$menu);
		
		$content = $this->CI->load->view($view, $data, true);
		$this->CI->template->write ('content',$content);
		
		$footer = $this->CI->load->view("templates/footer",$data, true);
		$this->CI->template->write ('footer',$footer);
		
		$this->CI->template->render();
	}	
	
	/* public function truckowner($view, $data="", $title="")
	{
		$this->CI->template->set_template("dashboard");

		$this->CI->template->write ('title',$title);
		
		$header = $this->CI->load->view("templates/header",$data, true);
		$this->CI->template->write ('header',$header);
		
		$menu = $this->CI->load->view("templates/leftmenu",$data, true);
		$this->CI->template->write ('leftmenu',$menu);
		
				
		$content = $this->CI->load->view($view, $data, true);
		$this->CI->template->write ('content',$content);
		
		
		$footer = $this->CI->load->view("templates/footer",$data, true);
		$this->CI->template->write ('footer',$footer);
		
		$this->CI->template->render();
	}	 */
	/*Added by Rushi*/
	public function dashboardtemp($view, $data="", $title="")
	{
		$this->CI->template->set_template("dashboardtemp");

		$this->CI->template->write ('title',$title);

		$header = $this->CI->load->view("templates/headertemp",$data, true);
		$this->CI->template->write ('header',$header);
		
		//$menu = $this->CI->load->view("templates/leftmenu",$data, true);
		//$this->CI->template->write ('leftmenu',$menu);
		
				
		$content = $this->CI->load->view($view, $data, true);
		$this->CI->template->write ('content',$content);
		
		
		$footer = $this->CI->load->view("templates/footer",$data, true);
		$this->CI->template->write ('footer',$footer);
		
		$this->CI->template->render();
	}	
	
	public function livemaptemp($view, $data="", $title="")
	{
		$this->CI->template->set_template("livemaptemp");

		$this->CI->template->write ('title',$title);

		$header = $this->CI->load->view("templates/livemapheader",$data, true);
		$this->CI->template->write ('livemapheader',$header);
				
		$content = $this->CI->load->view($view, $data, true);
		$this->CI->template->write ('content',$content);
		
		
		$footer = $this->CI->load->view("templates/footer",$data, true);
		$this->CI->template->write ('footer',$footer);
		
		$this->CI->template->render();
	}	
	
	//end
}
?>