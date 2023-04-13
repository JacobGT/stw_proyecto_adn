<?php
class aduanaModel extends Model{
	function __construct() {
		parent::__construct();
		$this->tabla='sys_producto';
	}
	
	function generar_sql($parametros){
		if($parametros['operacion'] == 'consultar_arancel'){
			$sql = "select * from ";
			$sql .= $this->tabla;
		}
		return $sql;	
	}
}
?>