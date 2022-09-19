<?php
/*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase de conexión a la base de datps mysql
*********************************************************************************
*/

Class DB {
	var $conn;

	function __construct(){
		include("../config/global_mysql.php");
		$this->conn = mysqli_connect($dbserver, $dbuser, $passwd);
		mysqli_query($this->conn,'SET NAMES utf8');
		mysqli_query($this->conn,'SET CHARACTER_utf8');
		mysqli_select_db($this->conn,$dbname);
		date_default_timezone_set("America/Mexico_City");
	}
	
	function &Ejecuta($query){

		$result = $this->conn->query($query);
		$error = $this->conn->error;
		
		if($error!="")
			$err = $error;
		$rr = "";
		
		$nrow = $result->num_rows;
		
		if($nrow > 0){
			$rr = array();
			for ($i=0;$row=$result->fetch_array(MYSQLI_ASSOC);$i++){
				foreach($row as $key => $value)
					$rr[$i][$key]=$value;
			}
		}else {
			$rr =0;
		}
		if($error!=""){
			$rr = $error;
		}
		return($rr);

	}
	
	function &Insert($query){
		$result = $this->conn->query($query);
        if ($result == "1"){
            return $result;
        }else{
            return " Error: ".$this->conn->error;
        }
	}
	
	function &EjecutaJSON($query){
			$result = mysqli_query($this->conn, $query);
			$error = mysqli_error($this->conn);
			if($error!="")
				$err = $error;
			$rr = "";
			if($result instanceof mysqli_result){
				$nrow = mysqli_num_rows($result);
				if($nrow>0){
					$rr = array();
					while ($row = mysqli_fetch_assoc($result)){
  						$data[] = $row;
					}
					$rr = json_encode($data);
				}
				else {
					$rr =0;
				}
			}
			else {
				$rr =0;
			}
			return($rr);
	}
    
	function close(){
		mysqli_close($this->conn);
	}
    
}

Class DBmysqli {
	var $conn;

	function __construct(){
		include("../config/global_mysql.php");
		$this->conn = mysqli_connect($dbserver, $dbuser, $passwd);
		mysqli_query($this->conn,'SET NAMES utf8');
		mysqli_query($this->conn,'SET CHARACTER_utf8');
		mysqli_select_db($this->conn,$dbname);
		date_default_timezone_set("America/Mexico_City");
	}
	
	function &Ejecutastore($query){
		if ( !($result = mysqli_query($this->conn, $query)) )
			echo mysqli_error($this->conn);
  		if ($result === true)
     		return true;
		for ($i=0;$row = mysqli_fetch_assoc($result);$i++){
			foreach($row as $key => $value){
				$rr[$i][$key]=$value;
				
			}
		}
  		// Hack for procedures returning second dummy result set
  		while(mysqli_more_results($this->conn)) {
    		mysqli_next_result($this->conn);
    		// echo "* DUMMY RS \n";
  		}
		return($rr);
	}
	
	function close(){
		mysqli_close($this->conn);
	}
}

?>