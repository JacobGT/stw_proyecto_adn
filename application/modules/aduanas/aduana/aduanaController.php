<?php
class aduanaController extends Controller{
	
	public function __construct(){
		parent::__construct();
		$this->modelo=$this->loadModel('aduana','aduanas');
        $this->view->template = 'main';
	}
	
	public function index(){
		
	}

    public function datos_poliza(){

        $data = json_decode(file_get_contents('php://input'), true);
    
        if(!empty($data)){
            echo $this->procesarDatos($data);
        }else{
            echo 'no hay datos';
        }
    
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

    public function procesarDatos($data){
        $poliza = new polizaController();
        $correo = new correoController();

        //Procesamiento de los datos
        $resultado = $data;
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
        $correo->enviar_correo($no_orden);

        return 'Datos Recibidos y Procesados con Exito';
    }
}

$procesard = new aduanaController();
echo $procesard->datos_poliza();

?>