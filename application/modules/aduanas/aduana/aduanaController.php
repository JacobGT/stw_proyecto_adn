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

    public function generar_poliza($array_resultado){
        /*$this->modelo->id_tabla = 'id_producto';
        $this->modelo->tabla = 'opr_carrito';
        $params=array('operacion'=>'consultar_productos_carrito');
        $resultado =$this->modelo->ejecutar_sql($params);
        */
        $datos = $array_resultado;            
        $nurmeroDatos = sizeof($datos);

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetTitle('Poliza ADUANERA');
        $pdf->SetFont('Arial','B',16);
        
        //Header
        // Arial bold 15
        $pdf->SetFont('Arial','B',20);
        // Movernos a la derecha
        $pdf->Cell(70);
        // Título
        $pdf->Cell(58,10,'Detalles de la POLIZA',0,0,'C');
        // Salto de línea
        $pdf->Ln(20);
        $fechaactual = 'Fecha: '.date('d/m/Y');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,10,$fechaactual,0,0,'');
        //$pdf->Image(BASE_URL.'layout/store/assets/img/logo/logo.png',150,35,40);
        $pdf->Ln(5);
        $pdf->Cell(0,10,'email: info@uspgcoders.site',0,0,'');
        $pdf->Ln(5);

        $poliza_no = 'generarPoliza';
        $pdf->Cell(0,10,'No. Orden: '.$poliza_no,0,0,'');

        $pdf->Ln(20);
        $pdf->SetFont('Arial','B',15);
        // Colores de los bordes, fondo y texto
        $pdf->SetDrawColor(0,80,180);
        $pdf->SetFillColor(189,236,182);
        $pdf->Cell(160,10,'Nombre del Producto',1,0,'C',true);
        $pdf->Cell(30,10,'Precio',1,1,'C',true);
        



        $total_prodcutos = 0;
        $pdf->SetFont('Arial','',12);
        $pdf->SetFillColor(226,240,251);
        /*for ($x = 0; $x < $nurmeroDatos; $x++) {
            $datosProducto = $datos[$x];
            
            $pdf->Cell(160,10,$datosProducto['descripcion'],1,0,'',true);
            $pdf->Cell(30,10,'$ '.$datosProducto['precio'],1,1,'C',true);
            $total_prodcutos = $total_prodcutos + floatval($datosProducto['precio']);
        }*/
        $pdf->SetFont('Arial','B',15);
        $pdf->Cell(160,10,'Total',1,0,'R',0);
        $pdf->SetFillColor(253,238,238);
        $pdf->Cell(30,10,'$ '.sprintf('%0.2f',$total_prodcutos),1,1,'C',true);
        
        
        // Posición: a 1,5 cm del final
        $pdf->SetY(266);
        // Arial italic 8
        $pdf->SetFont('Arial','I',8);
        // Número de página
        $pdf->Cell(0,10,'Gracias por tu compra!',0,0,'C');
        
        $pdf->Output();
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
        //$this->generar_poliza($manifiesto_procesado);
  
        return $manifiesto_procesado;
    }
}

$procesard = new aduanaController();
echo json_encode($procesard -> procesarDatos());

?>