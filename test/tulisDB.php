<?php
	require "errorHD.php";

	class bacaDB 
	{
		protected $link;
		public function __construct(){
			$this->connect();
		}
		private function connect(){
		//	$this->link = mysql_connect("localhost","root","bks123") or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),0)));
			$this->link = mysql_connect("localhost","root","") or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),0)));
			mysql_select_db("pdam_wmmr",$this->link);
		}
		public function tutup(){
			mysql_close($this->link);
		}
	}
	
	class tulisDB 
	{
		protected $link;
		public function __construct(){
			$this->connect();
		}
		private function connect(){
			//$this->link = mysql_connect("localhost","root","bks123") or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),0)));
			$this->link = mysql_connect("localhost","root","") or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),0)));
			mysql_select_db("pdam_wmmr",$this->link);
		}
		public function tutup(){
			mysql_close($this->link);
		}
	}

	class bacaDB2 
	{
		protected $link2;
		public function __construct(){
			$this->connect();
		}
		private function connect(){
			$this->link2 = mysql_connect("localhost","root","") or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),0)));
			mysql_select_db("mmr_entry",$this->link2);
		}
		public function tutup(){
			mysql_close($this->link2);
		}
	}
	
	class tulisDB2 
	{
		protected $link2;
		public function __construct(){
			$this->connect();
		}
		private function connect(){
			$this->link2 = mysql_connect("localhost","root","") or die(errorHD::salahDB(array(mysql_errno(),mysql_error(),0)));
			mysql_select_db("mmr_entry",$this->link2);
		}
		public function tutup(){
			mysql_close($this->link2);
		}
	} 

	class bacaSQL1 
	{
		protected $link;
		public function __construct(){
			$this->connect();
		}
		private function connect(){
		$this->link = mssql_connect("192.200.200.12:1433\MSSQLSERVER","sa","pde-pst-bks-08");
		//$this->link = mssql_connect("192.200.200.12","sa","pde-pst-bks-08");
		mssql_select_db("Jerbee",$this->link);
		}
		public function tutup(){
			//mysql_close($this->link2);
		}
	}
?> 
