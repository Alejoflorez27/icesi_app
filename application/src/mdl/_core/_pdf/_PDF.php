<?php

require_once dirname(__FILE__, 5) . '/vendor/fpdf182/fpdf.php';
require_once dirname(__FILE__, 5) . '/vendor/autoload.php';
use setasign\Fpdi\Fpdi;

class PDF extends Fpdi
{
    public $margen_izq = 10;
    public $v_posX = 10;
    public $v_posY = 10;

    var $legends;
    var $wLegend;
    var $sum;
    var $NbVal;


    public function __construct($orientation = 'P', $unit = 'mm', $size = 'A4', $margen_izq = 10, $margen_sup = 10, $margen_der = 10)
    {
        parent::__construct($orientation, $unit, $size);
        $this->SetLeftMargin($margen_izq);
        $this->SetTopMargin($margen_sup);
        $this->SetRightMargin($margen_der);
        $this->margen_izq = $margen_izq;
        $this->v_posX = $margen_izq;
    }

    public function Cell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '', $utf8_decode = false)
    {
        parent::Cell($w, $h, ($utf8_decode ? utf8_decode($txt) : $txt), $border, $ln, $align, $fill, $link);
    }

    public function Ln($h = null, $real = true)
    {
        if ($real === true)
            parent::Ln($h);

        $this->v_posX = $this->margen_izq;
        $this->v_posY = $this->getY();
    }


    public function Celda($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $posX = null, $posY = null)
    {

        $this->SetXY(
            ($posX != null) ? $posX : $this->v_posX,
            ($posY != null) ? $posY : $this->v_posY
        );

        $this->MultiCell($w, $h, str_replace("<br>", "\n", $txt), $border, $align, $fill);

        // $this->v_posY = $this->getY();
        if ($ln == 0) {
            $this->v_posX += $w;
        } elseif ($ln == 1) {
            $this->v_posY += $h;
        } else {
            $this->v_posX += $w;
            $this->v_posY = $ln;
        }
    }

    public function XY($x, $y)
    {
        $this->v_posX = $x;
        $this->v_posY = $y;

        // Set x and y positions
        $this->SetXY($x, $y);
    }

    function BarDiagram($w, $h, $data, $format, $color=null, $maxVal=0, $nbDiv=4)
    {
        //$XPage = 0;
        $this->SetFont('Arial', 'B', 9);
        $this->SetLegends($data,$format);

        $XPage = $this->GetX();
        $YPage = $this->GetY();
        $margin = 2;
        $YDiag = $YPage + $margin;
        $hDiag = floor($h - $margin * 2);
        $XDiag = $XPage + $margin * 2 + $this->wLegend;
        $lDiag = floor($w - $margin * 3 - $this->wLegend);
        if($color == null)
            $color=array(155,155,155);
        if ($maxVal == 0) {
            $maxVal = max($data);
        }
        $valIndRepere = ceil($maxVal / $nbDiv);
        $maxVal = 100;  //$valIndRepere * $nbDiv;
        $lRepere = floor($lDiag / $nbDiv);
        $lDiag = $lRepere * $nbDiv;
        $unit = $lDiag / $maxVal;
        $hBar = floor($hDiag / ($this->NbVal + 1));
        $hDiag = $hBar * ($this->NbVal + 1);
        $eBaton = floor($hBar * 80 / 100);

        $this->SetLineWidth(0.1);
        $this->Rect($XDiag, $YDiag, $lDiag, $hDiag);

        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor($color[0],$color[1],$color[2]);
        $i=0;
        foreach($data as $val) {
            //Bar
            $xval = $XDiag;
            $lval = (int)($val * $unit);
            $yval = $YDiag + ($i + 1) * $hBar - $eBaton / 2;
            $hval = $eBaton ;
            $this->Rect($xval, $yval, $lval, $hval, 'DF');
            //Legend
            $this->SetXY(12, $yval);
            $this->Cell($xval - $margin, $hval, utf8_decode($this->legends[$i]),0,0,'L');
            $i++;
        }

        //Scales
        for ($i = 0; $i <= $nbDiv; $i++) {
            $xpos = $XDiag + $lRepere * $i;
            $this->Line($xpos, $YDiag, $xpos, $YDiag + $hDiag);
            $val = $i * $valIndRepere;
            $xpos = $XDiag + $lRepere * $i - $this->GetStringWidth($val) / 2;
            $ypos = $YDiag + $hDiag - $margin;
            $this->Text($xpos, $ypos, $val);
        }
    }

    function SetLegends($data, $format)
    {
        $this->legends=array();
        $this->wLegend=0;
        $this->sum=array_sum($data);
        $this->NbVal=count($data);
        foreach($data as $l=>$val)
        {
            $p=sprintf('%.2f',$val/$this->sum*100).'%';
            $legend=str_replace(array('%l','%v','%p'),array($l,$val,$p),$format);
            $this->legends[]=$legend;
            $this->wLegend=max($this->GetStringWidth($legend),$this->wLegend);
        }
    }

function Header()
{   
    $id_solicitud = $_GET['id_sl'];
    $id_servicio = $_GET['id_sv'];
    $nomInforme = CtrSrvServicio::findByIdServicio($id_servicio);

    $this->SetFillColor(255,255,255);
    $this->Ln(5);

    $solicitud = CtrSolSolicitud::qry_solicitudSinSrv($id_solicitud);
    $empresa = CtrTrcEmpresa::findById($solicitud['data'][0]['id_empresa']);
    $id_empresa = $empresa['data']['id_empresa'];

    // ✅ Logo en la parte izquierda según la empresa
    if ($id_empresa != 27) {
        // Logo Prohumanos
        $this->Image(
            'upload/image/sitio/logoedsalud.png',
            10, 7, 30, 30,
            substr(strrchr('upload/image/sitio/logoedsalud.png', "."), 1)
        );
    } else {
        // Logo de la empresa (si existe)
        $logo_empresa = $empresa['data']['directorio'].$empresa['data']['nombre_encr'];
        if (!empty($empresa['data']['nombre_encr']) && file_exists($logo_empresa)) {
            $this->Image(
                $logo_empresa,
                10, 7, 30, 30,
                substr(strrchr($logo_empresa, "."), 1)
            );
        }
    }

    // ✅ Título del informe
    $this->Ln(18);
    $this->SetFont('Arial', 'B', 12);
    $this->Cell(190, 10, utf8_decode($nomInforme['data']['nomReporte']), 0, 0, 'C', 0);
    $this->Ln(12);
    $this->SetFont('Arial','B',14);

    // ✅ Logo secundario (derecha)
    if ($id_empresa != 27) { 
        // Solo si NO es Prohumanos, porque ya pintamos su logo
        $logo_empresa = $empresa['data']['directorio'].$empresa['data']['nombre_encr'];
        if (!empty($empresa['data']['nombre_encr']) && file_exists($logo_empresa)) {
            $this->Image(
                $logo_empresa,
                165, // X
                10,  // Y
                35,  // width
                25,  // height
                substr(strrchr($logo_empresa, "."), 1)
            );
        }
    }

    $this->Ln(-4);
}


//Pie de pagina
function Footer()
    {
        $this->SetFillColor(255,255,255);
        $this->SetFont('Arial','',7);
        $this->SetY(-5); 
        $this->MultiCell(0,0,utf8_decode('Este documento es de uso exclusivo de la empresa contratante. Queda estrictamente prohibida su reproducción total o parcial sin autorización previa por escrito.'),0,0,'L');
    }

    protected $widths;
    protected $aligns;
    protected $fills;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }
    

    function Row($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 4*$nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h);
            // Print the text
            $this->MultiCell($w,4,$data[$i],0,$a);
            
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }

function RowBold($data)
{
    // Calculate the height of the row
    $nb = 0;
    for($i=0;$i<count($data);$i++)
        $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h = 4*$nb;
    // Issue a page break first if needed
    $this->CheckPageBreak($h);
    // Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w = $this->widths[$i];
        $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

        // Save the current position
        $x = $this->GetX();
        $y = $this->GetY();
        // Draw the border
        $this->Rect($x,$y,$w,$h);

        // ✅ Poner en negrilla solo el primer campo
        if($i == 0){
            $this->SetFont('Arial','B',8); // Negrilla
        } else {
            $this->SetFont('Arial','',8); // Normal
        }

        // Print the text
        $this->MultiCell($w,4,$data[$i],0,$a);
        
        // Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    // Go to the next line
    $this->Ln($h);
}


    function Row3($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 4*$nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';

            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h);
            // Print the text
            $this->MultiCell($w,4,$data[$i],0,$a);
            
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }


    function Row2($data)
    {
        // Calculate the height of the row
        $nb = 0;
        for($i=0;$i<count($data);$i++)
            $nb = max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h = 4*$nb;
        // Issue a page break first if needed
        $this->CheckPageBreak($h);
        // Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';

            // Save the current position
            $x = $this->GetX();
            $y = $this->GetY();
            // Draw the border
            $this->Rect($x,$y,$w,$h);
            // Print the text
            $this->MultiCell($w,4,$data[$i],1,$a,1);
            
            // Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        // Go to the next line
        $this->Ln($h);
    }



    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

    // Custom method to draw multi-cell with line divisions
    function MultiCellWithLines($w, $h, $text, $border=0, $align='J', $fill=false) {
        $lines = explode("\n", $text);
        foreach ($lines as $line) {
            $this->Cell($w, $h, $line, $border, 1, $align, $fill);
        }
    }


}
