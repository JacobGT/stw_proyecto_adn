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
        $poliza = new polizaController();

        //Procesamiento de los datos
        $resultado = $this->consultarPoliza();
        $arancel = $this->consultar_arancel();
        $manifiesto_procesado_verde = array();// Array que contendra la informacion ya procesada
        $manifiesto_procesado_rojo = array();// Array que contendra la informacion ya procesada

        $t_array = sizeof($arancel);

        $no_orden = strtotime("now").rand(1, 999);

        foreach($resultado as $clave => $item){

            $procentaje_arancel = 0.00;

            for ($x = 0; $x < $t_array; $x++) {
                if (strtolower($arancel[$x]["descripcion"]) == strtolower($resultado[$clave]["tipo_producto"])){//cambiar "cpu" por ]
                    $procentaje_arancel = $arancel[$x]["porcentaje_arancel"];
                    break;
                }
            }


            $color = $this->marcar_color(rand(0,1)); // Se asgina un color aleatorio al paquete

            
            if($color == "verde"){

                $manifiesto_procesado_verde[$clave]["id_manifiesto"] = $resultado[$clave]["id_manifiesto"];
                $manifiesto_procesado_verde[$clave]["id_detalle"] = $resultado[$clave]["id_detalle"];
                $manifiesto_procesado_verde[$clave]["nombre_comprador"] = $resultado[$clave]["nombre_comprador"];
                $manifiesto_procesado_verde[$clave]["descripcion_producto"] = $resultado[$clave]["descripcion_producto"];
                $manifiesto_procesado_verde[$clave]["valor_producto"] = floatval($resultado[$clave]["valor_producto"]);
                $manifiesto_procesado_verde[$clave]["no_orden"] = $no_orden;
                $manifiesto_procesado_verde[$clave]["porcentaje_arancel"] = floatval($procentaje_arancel);
                $manifiesto_procesado_verde[$clave]["color_paquete"] = $color;
                $manifiesto_procesado_verde[$clave]["tipo_producto"] = $resultado[$clave]["tipo_producto"];

            }else{
                $manifiesto_procesado_rojo[$clave]["id_manifiesto"] = $resultado[$clave]["id_manifiesto"];
                $manifiesto_procesado_rojo[$clave]["id_manifiesto"] = $resultado[$clave]["id_detalle"];
                $manifiesto_procesado_rojo[$clave]["nombre_comprador"] = $resultado[$clave]["nombre_comprador"];
                $manifiesto_procesado_rojo[$clave]["descripcion_producto"] = $resultado[$clave]["descripcion_producto"];
                $manifiesto_procesado_rojo[$clave]["valor_producto"] = floatval($resultado[$clave]["valor_producto"]);
                $manifiesto_procesado_rojo[$clave]["no_orden"] = $no_orden;
                $manifiesto_procesado_rojo[$clave]["porcentaje_arancel"] = floatval($procentaje_arancel);
                $manifiesto_procesado_rojo[$clave]["color_paquete"] = $color;
                $manifiesto_procesado_rojo[$clave]["tipo_producto"] = $resultado[$clave]["tipo_producto"];
            }
            //Se agrega la info al nuevo array
            
        }
        
        $poliza->generar_poliza(array_values($manifiesto_procesado_verde),'[VERDE]');
        $poliza->generar_poliza(array_values($manifiesto_procesado_rojo),'[ROJO]');
  
        return 'Datos Procesados Con Exito';
    }
}

$procesard = new aduanaController();
echo json_encode($procesard -> procesarDatos());
//var_dump($procesard -> procesarDatos());

?>