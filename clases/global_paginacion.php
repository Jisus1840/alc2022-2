<?
 /*
*********************************************************************************
* EVOTEK
* Todos los derechos reservados. 2019
* DESARROLLADOR: MONICA SOFIA RODRIGUEZ GARCIA
* Clase de Paginación Mysql
*********************************************************************************
*/

class Paginator {
 
     private $_conn;
     private $_limit;
     private $_page;
     private $_query;
     private $_total;

 	public function __construct( $conn, $query ) {
     
		$this->_conn = $conn;
		$this->_query = $query;
	 	$this->_conn->query("SET NAMES 'utf8'");
		$rs= $this->_conn->query( $this->_query );
		if (isset($rs->num_rows))
			$this->_total = $rs->num_rows;
	}
	
	public function getData( $limit = 10, $page = 1 ) {
     
		$this->_limit   = $limit;
		$this->_page    = $page;
	 
		if ( $this->_limit == 'todos' ) {
			$query      = $this->_query;
		} else {
			$query      = $this->_query . " LIMIT " . ( ( $this->_page - 1 ) * $this->_limit ) . ", $this->_limit";
		}
		$rs             = $this->_conn->query( $query );
		
		if ($rs <> ''){
			while ( $row = $rs->fetch_assoc() ) {
				$results[]  = $row;
			}
		 
			$result         = new stdClass();
			$result->page   = $this->_page;
			$result->limit  = $this->_limit;
			$result->total  = $this->_total;
			if (isset($results)){
				$result->data   = $results;
			}else{
				$result = '';
			}
		}else{
			$result = '';
		}
		return $result;
	}
	
	public function createLinks( $links, $list_class,$morelink) {
		
		if ( $this->_limit == 'todos' ) {
			return '';
		}
	 
		$last       = ceil( $this->_total / $this->_limit );
	 
		$start      = ( ( $this->_page - $links ) > 0 ) ? $this->_page - $links : 1;
		$end        = ( ( $this->_page + $links ) < $last ) ? $this->_page + $links : $last;
	 
		$html       = '<ul class="' . $list_class . '">';
	 
		$class      = ( $this->_page == 1 ) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit .$morelink. '&page=' . ( $this->_page - 1 ) . '">&laquo;</a></li>';
	 
		if ( $start > 1 ) {
			$html   .= '<li><a href="?limit=' . $this->_limit .$morelink.'&page=1">1</a></li>';
			$html   .= '<li class="disabled"><span>...</span></li>';
		}
	 
		for ( $i = $start ; $i <= $end; $i++ ) {
			$class  = ( $this->_page == $i ) ? "active" : "";
			$html   .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit .$morelink. '&page=' . $i . '">' . $i . '</a></li>';
		}
	 
		if ( $end < $last ) {
			$html   .= '<li class="disabled"><span>...</span></li>';
			$html   .= '<li><a href="?limit=' . $this->_limit .$morelink. '&page=' . $last . '">' . $last . '</a></li>';
		}
	 
		$class      = ( $this->_page == $last ) ? "disabled" : "";
		$html       .= '<li class="' . $class . '"><a href="?limit=' . $this->_limit .$morelink.'&page=' . ( $this->_page + 1 ) . '">&raquo;</a></li>';
	 
		$html       .= '</ul>';
	 
		return $html;
	}
}



?>