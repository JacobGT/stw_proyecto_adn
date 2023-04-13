<?php
class aduanaController extends Controller{
	
	public function __construct(){
		parent::__construct();
		$this->modelo=$this->loadModel('aduana','aduanas');
        $this->view->template = 'main';
	}
	
	public function index(){
		
	}
	
	public function consultarPoliza(){
        
        $ch = curl_init(); //Inicializa la sesión cURL

        // Se establecen los parametros para el cURL
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'http://www.chevsko.kevin.syswebgroup.online/webservice_01.php',
            CURLOPT_RETURNTRANSFER => true
        ));

        // Elimnar Lineas: -----------------------------
        /*/Nomas para que no joda con el SSL en el localhost del WAMP >:v
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
         ---------------------------------------------*/

        $response = curl_exec($ch); //Se ejecuta el cURL

        if (curl_errno($ch)) 
            echo curl_error($ch); //Comprobacion de errores
        else 
            curl_close($ch);
            return json_decode($response, true); //Transforma el JSON en un Array, para retornarlo

    }

    public function marcar_color($a_valor){
        if ($a_valor == 0){
            return "verde";
        }else{
            return "rojo";
        }
    }

    public function consultar_arancel(){
		$this->modelo->tabla = 'sys_producto';
        $params=array('operacion'=>'consultar_arancel');
        $resultado =$this->modelo->ejecutar_sql($params);
        $datos = $resultado['datos'];
        //var_dump($datos);
        return $datos;
    }

    public function procesarDatos(){
        //$consulta = new webServices_consulta();

        //Procesamiento de los datos
        $resultado = $this->consultarPoliza();
        $arancel = $this->consultar_arancel();
        $manifiesto_procesado = array();// Array que contendra la informacion ya procesada

        foreach($resultado as $clave => $item){

            $contador = 0;
            $procentaje_arancel = 0.00;

            //var_dump($arancel[$contador]["descripcion"]);

            while (current($arancel)) {
                
                if (strtolower($arancel[$contador]["descripcion"]) == "cpu"){//cambiar "cpu" por $resultado[$clave]["categoria_producto"]
                    $procentaje_arancel = $arancel[$contador]["porcentaje_arancel"];
                    break;
                }else{
                    $contador = $contador + 1;
                }

                next($arancel);
            }

            $color = $this->marcar_color(rand(0,1)); // Se asgina un color aleatorio al paquete
            //Se agrega la info al nuevo array
            $manifiesto_procesado[$clave]["id_manifiesto"] = $resultado[$clave]["id_manifiesto"];
            $manifiesto_procesado[$clave]["nombre_comprador"] = $resultado[$clave]["nombre_comprador"];
            $manifiesto_procesado[$clave]["descripcion_producto"] = $resultado[$clave]["descripcion_producto"];
            $manifiesto_procesado[$clave]["valor_producto"] = floatval($resultado[$clave]["valor_producto"]);
            $manifiesto_procesado[$clave]["porcentaje_arancel"] = floatval($procentaje_arancel);
            $manifiesto_procesado[$clave]["valor_total"] = $resultado[$clave]["valor_producto"] + ($resultado[$clave]["valor_producto"] * $procentaje_arancel);
            $manifiesto_procesado[$clave]["color_paquete"] = $color;
        }

        return $manifiesto_procesado;

    }
}

    $procesard = new aduanaController();
    var_dump($procesard -> procesarDatos());
?>