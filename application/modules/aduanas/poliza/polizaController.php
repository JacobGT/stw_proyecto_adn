<?php
class polizaController extends Controller{
	
	public function __construct(){
		parent::__construct();
		$this->modelo=$this->loadModel('poliza','aduanas');
        $this->view->template = 'main';
	}
	
	public function index(){
		
	}

    public function generar_poliza($array_resultado, $tipo){

        $datos = $array_resultado;            
        $nurmeroDatos = sizeof($datos);
        
        $pdf = new FPDF('L');
        $pdf->AddPage();
        $pdf->SetTitle('Poliza ADUANERA');
        $pdf->SetFont('Arial','B',16);
        
        //Header
        // Arial bold 15
        $pdf->SetFont('Arial','B',20);
        // Movernos a la derecha
        $pdf->Cell(70);
        // Título
        $pdf->Cell(140,10,'POLIZA ADUANERA '.$tipo,0,0,'C');
        // Salto de línea
        $pdf->Ln(10);
        $fechaactual = 'Fecha: '.date('d/m/Y');
        $pdf->SetFont('Arial','',12);
        $pdf->Cell(0,10,$fechaactual,0,0,'');
        //$pdf->Image(BASE_URL.'layout/store/assets/img/logo/logo.png',150,35,40);
        $pdf->Ln(5);
        $pdf->Cell(0,10,'email: info@uspgcoders.site',0,0,'');
        $pdf->Ln(5);

        $poliza_no = $datos[0]['no_orden'];
        $pdf->Cell(0,10,'No. Orden: '.$poliza_no,0,0,'');
        $pdf->Ln(5);
        $comprador = $datos[0]['nombre_comprador'];
        $pdf->Cell(0,10,'Comprador: '.$comprador,0,0,'');

        $pdf->Ln(10);
        $pdf->SetFont('Arial','B',12);
        // Colores de los bordes, fondo y texto
        $pdf->SetDrawColor(0,80,180);
        $pdf->SetFillColor(189,236,182);
        $pdf->Cell(10,6,'ID',1,0,'C',true);
        $pdf->Cell(95,6,utf8_decode('Descripción del Producto'),1,0,'C',true);
        $pdf->Cell(30,6,'Precio',1,0,'C',true);
        $pdf->Cell(15,6,'%',1,0,'C',true);
        $pdf->Cell(30,6,'Arancel',1,0,'C',true);
        $pdf->Cell(30,6,'Precio Final',1,0,'C',true);
        $pdf->Cell(35,6,'Color Paquete',1,0,'C',true);
        $pdf->Cell(33,6,'Tipo',1,0,'C',true);
        $pdf->Ln(10);

        $pdf->SetFont('Arial','',10);
        $pdf->SetFillColor(226,240,251);
        for ($x = 0; $x < $nurmeroDatos; $x++) {
            $datosProducto = $datos[$x];
            
            $pdf->Cell(10,5,$datosProducto['id_manifiesto'],1,0,'C',true);
            $pdf->Cell(95,5,$datosProducto['descripcion_producto'],1,0,'L',true);
            $pdf->Cell(30,5,$datosProducto['valor_producto'],1,0,'C',true);
            $pdf->Cell(15,5,$datosProducto['porcentaje_arancel']*100 .' %',1,0,'C',true);
            $pdf->Cell(30,5,round($datosProducto['valor_producto']*$datosProducto['porcentaje_arancel'],2),1,0,'C',true);
            $pdf->Cell(30,5,round($datosProducto['valor_producto']+($datosProducto['valor_producto']*$datosProducto['porcentaje_arancel']),2),1,0,'C',true);
            $pdf->Cell(35,5,$datosProducto['color_paquete'],1,0,'C',true);
            $pdf->Cell(33,5,$datosProducto['tipo_producto'],1,0,'C',true);
            $pdf->Ln();
            //$total_prodcutos = $total_prodcutos + floatval($datosProducto['precio']);
        }
        $pdf->SetFont('Arial','B',15);
        //$pdf->Cell(160,10,'Total',1,0,'R',0);
        $pdf->SetFillColor(253,238,238);
        //$pdf->Cell(30,10,'$ '.sprintf('%0.2f',$total_prodcutos),1,2,'C',true);
        
        
        // Posición: a 1,5 cm del final
        $pdf->SetY(266);
        // Arial italic 8
        $pdf->SetFont('Arial','I',8);
        // Número de página
        //$pdf->Cell(0,10,'Gracias por tu compra!',0,0,'C');
        
        $pdf->Output('F', 'application/modules/aduanas/poliza/reportes/'.$datos[0]['no_orden'].$tipo.'.pdf');
    } 
   
}

?>