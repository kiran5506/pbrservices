<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

	if(!function_exists('is_logged_in'))
	{
		function is_logged_in()
		{
			// Get current CodeIgniter instance
			$CI =& get_instance();
			// We need to use $CI->session instead of $this->session
			$user = $CI->session->userdata('itk_logged');
			if ($CI->session->userdata('itk_logged')) 
			{ 
				return true;
			} 
			else 
			{ 
				redirect('/');
			}
		}
	}

	if(!function_exists('is_emp_logged_in'))
	{
		function is_emp_logged_in()
		{
			// Get current CodeIgniter instance
			$CI =& get_instance();
			// We need to use $CI->session instead of $this->session
			$user = $CI->session->userdata('emp_logged');
			if ($CI->session->userdata('emp_logged')) 
			{ 
				return true;
			} 
			else 
			{ 
				redirect('/');
			}
		}
	}

	if(!function_exists('ProcessCurl'))
	{
		function ProcessCurl($url,$method)
		{
			$headers = array(
			    'Content-Type: application/json',
			    'Auth-Key: itkRestApi',
			);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$result=curl_exec($ch);
			if (curl_errno($ch)) {
				print curl_error($ch);
			} else {
				curl_close($ch);
			}
			return json_decode($result);
		}
	}


	if(!function_exists('ProcessCurlPost'))
	{
		function ProcessCurlPost($url,$method,$data_string)
		{
			$headers = array(
			    'Content-Type: application/json',
			    'Auth-Key: itkRestApi',
			);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$resultk=curl_exec($ch);
			if (curl_errno($ch)) {
				print curl_error($ch);
			} else {
				curl_close($ch);
			}
			return json_decode($resultk);
		}
	}

	if(!function_exists('ProcessCurlPostImage'))
	{
		function ProcessCurlPostImage($url,$method,$data_string)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$url);
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array( 
				    'Content-Length: ' . strlen($data_string))
				);
			$resultk=curl_exec($ch);
			if (curl_errno($ch)) {
				print curl_error($ch);
			} else {
				curl_close($ch);
			}
			return json_decode($resultk);
		}
	}
?>