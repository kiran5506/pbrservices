<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
	

	if(!function_exists('print_recpt'))
	{
		function print_recpt()
		{
			
			//exit;
			//require __DIR__ . '\..\..\autoload.php';
			require_once APPPATH.'\libraries\autoload.php';

			//require __DIR__ . '/vendor/autoload.php';
			use Mike42\Escpos\PrintConnectors\FilePrintConnector;
			use Mike42\Escpos\Printer;

			/* Open file */
			$tmpdir = sys_get_temp_dir();
			$file =  tempnam($tmpdir, 'ctk');

			/* Do some printing */
			$connector = new FilePrintConnector($file);
			$printer = new Printer($connector);
			$printer -> text("Hello World!\n");
			$printer -> cut();

			$printer -> close();

			/* Copy it over to the printer */
			copy($file, "http://localhost/order");
		}
	}
	
?>