<?php
// FPDF 1.85 - PHP 8 compatible (https://www.fpdf.org)
// License: Freeware

if (!defined('FPDF_VERSION')) define('FPDF_VERSION','1.85');

class FPDF
{
protected $page;               // current page number
protected $n;                  // current object number
protected $offsets;            // array of object offsets
protected $buffer;             // buffer holding in-memory PDF
protected $pages;              // array containing pages
protected $state;              // current document state
protected $compress;           // compression flag
protected $k;                  // scale factor (number of points in user unit)
protected $DefOrientation;     // default orientation
protected $CurOrientation;     // current orientation
protected $PageFormats;        // available page formats
protected $DefPageFormat;      // default page format
protected $CurPageFormat;      // current page format
protected $PageSizes;          // array storing non-default page sizes
protected $wPt, $hPt;          // dimensions of current page in points
protected $w, $h;              // dimensions of current page in user unit
protected $lMargin;            // left margin
protected $tMargin;            // top margin
protected $rMargin;            // right margin
protected $bMargin;            // page break margin
protected $cMargin;            // cell margin
protected $x, $y;              // current position in user unit
protected $lasth;              // height of last printed cell
protected $LineWidth;          // line width in user unit
protected $fontpath;           // path containing fonts
protected $CoreFonts;          // array of core font names
protected $fonts;              // array of used fonts
protected $FontFiles;          // array of font files
protected $encodings;          // array of encodings
protected $cmaps;              // array of ToUnicode CMaps
protected $FontFamily;         // current font family
protected $FontStyle;          // current font style
protected $underline;          // underlining flag
protected $CurrentFont;        // current font info
protected $FontSizePt;         // current font size in points
protected $FontSize;           // current font size in user unit
protected $DrawColor;          // commands for drawing color
protected $FillColor;          // commands for filling color
protected $TextColor;          // commands for text color
protected $ColorFlag;          // indicates whether fill and text colors are different
protected $WithAlpha;          // indicates alpha channel
protected $ws;                 // word spacing
protected $images;             // array of used images
protected $PageLinks;          // array of links in pages
protected $links;              // array of internal links
protected $AutoPageBreak;      // automatic page breaking
protected $PageBreakTrigger;   // threshold used to trigger page breaks
protected $InHeader;           // flag set when processing header
protected $InFooter;           // flag set when processing footer
protected $ZoomMode;           // zoom display mode
protected $LayoutMode;         // layout display mode
protected $metadata;           // document properties
protected $PDFVersion;         // PDF version number

function __construct($orientation='P', $unit='mm', $size='A4')
{
	$this->_dochecks();
	// Scale factor
	switch ($unit) {
		case 'pt': $this->k = 1; break;
		case 'mm': $this->k = 72/25.4; break;
		case 'cm': $this->k = 72/2.54; break;
		case 'in': $this->k = 72; break;
		default: $this->Error('Incorrect unit: '.$unit);
	}
	// Page format
	$this->PageFormats = array('a3'=>array(841.89,1190.55),'a4'=>array(595.28,841.89),'a5'=>array(420.94,595.28),
		'letter'=>array(612,792),'legal'=>array(612,1008));
	$this->DefPageFormat = $this->_getpageformat($size);
	$this->CurPageFormat = $this->DefPageFormat;
	// Page orientation
	$orientation = strtolower($orientation);
	if ($orientation=='p' || $orientation=='portrait')
		$this->DefOrientation = 'P';
	elseif ($orientation=='l' || $orientation=='landscape')
		$this->DefOrientation = 'L';
	else
		$this->Error('Incorrect orientation: '.$orientation);
	$this->CurOrientation = $this->DefOrientation;
	$this->w = $this->DefPageFormat[0]/$this->k;
	$this->h = $this->DefPageFormat[1]/$this->k;
	// Page margins (1 cm)
	$margin = 28.35/$this->k;
	$this->SetMargins($margin,$margin);
	// Interior cell margin (1 mm)
	$this->cMargin = $margin/10;
	// Line width (0.2 mm)
	$this->LineWidth = .567/$this->k;
	// Automatic page break
	$this->SetAutoPageBreak(true,2*$margin);
	// Default display mode
	$this->SetDisplayMode('default');
	// Enable compression
	$this->SetCompression(true);
	// Set default PDF version number
	$this->PDFVersion = '1.3';
	$this->fontpath = __DIR__;
	$this->CoreFonts = array('courier','helvetica','times','symbol','zapfdingbats');
	$this->fonts = array();
	$this->FontFiles = array();
	$this->encodings = array();
	$this->cmaps = array();
	$this->images = array();
	$this->links = array();
	$this->metadata = array();
}

function SetMargins($left, $top, $right=null)
{
	$this->lMargin = $left;
	$this->tMargin = $top;
	if ($right===null)
		$right = $left;
	$this->rMargin = $right;
}

function SetAutoPageBreak($auto, $margin=0)
{
	$this->AutoPageBreak = $auto;
	$this->bMargin = $margin;
	$this->PageBreakTrigger = $this->h-$margin;
}

function SetDisplayMode($zoom, $layout='default')
{
	$this->ZoomMode = $zoom;
	$this->LayoutMode = $layout;
}

function SetCompression($compress)
{
	$this->compress = $compress && function_exists('gzcompress');
}

function AddPage($orientation='', $size='')
{
	if ($this->state==0)
		$this->Open();
	$family = $this->FontFamily;
	$style = $this->FontStyle.($this->underline ? 'U' : '');
	$fontsize = $this->FontSizePt;
	$lw = $this->LineWidth;
	$dc = $this->DrawColor;
	$fc = $this->FillColor;
	$tc = $this->TextColor;
	$cf = $this->ColorFlag;

	// Page
	$this->_beginpage($orientation,$size);
	// Set line width
	$this->LineWidth = $lw;
	$this->_out(sprintf('%.2F w',$lw*$this->k));
	// Set font
	if ($family)
		$this->SetFont($family,$style,$fontsize);
	// Set colors
	$this->DrawColor = $dc;
	if ($dc!='0 G')
		$this->_out($dc);
	$this->FillColor = $fc;
	if ($fc!='0 g')
		$this->_out($fc);
	$this->TextColor = $tc;
	$this->ColorFlag = $cf;
}

function Header()
{
}

function Footer()
{
}

function SetFont($family, $style='', $size=0)
{
	$family = strtolower($family);
	$style = strtoupper($style);
	if (strpos($style,'U')!==false) {
		$this->underline = true;
		$style = str_replace('U','',$style);
	} else {
		$this->underline = false;
	}
	if ($size==0)
		$size = $this->FontSizePt;
	if ($this->FontFamily==$family && $this->FontStyle==$style && $this->FontSizePt==$size)
		return;
	$this->FontFamily = $family;
	$this->FontStyle = $style;
	$this->FontSizePt = $size;
	$this->FontSize = $size/$this->k;

	// Try core font only
	if (!in_array($family,$this->CoreFonts))
		$family = 'helvetica';
	$fontkey = $family.$style;
	if (!isset($this->fonts[$fontkey]))
		$this->_AddFont($family,$style);
	$this->CurrentFont = $this->fonts[$fontkey];
	$this->_out(sprintf('BT /F%d %.2F Tf ET',$this->CurrentFont['i'],$this->FontSizePt));
}

protected function _AddFont($family, $style)
{
	$family = strtolower($family);
	$style = strtoupper($style);
	if ($family=='helvetica')
		$family = 'arial';
	$fontkey = $family.$style;
	if (isset($this->fonts[$fontkey]))
		return;
	$i = count($this->fonts)+1;
	$this->fonts[$fontkey] = array('i'=>$i, 'type'=>'core', 'name'=>$family.$style, 'up'=>-100, 'ut'=>50, 'cw'=>$this->_GetCoreFontWidths($family));
}

protected function _GetCoreFontWidths($family)
{
	// Widths taken from original FPDF
	$fontpath = __DIR__.'/font/';
	$fn = $fontpath.$family.'.php';
	if (file_exists($fn)) {
		return include($fn);
	}
	// Fallback: basic width table for helvetica
	return array(" "=>278,"!"=>278,'"'=>355,"#"=>556,"$"=>556,"%"=>889,"&"=>667,"'"=>191,"("=>333,")"=>333,"*"=>389,"+"=>584,","=>278,"-"=>333,"."=>278,"/"=>278,"0"=>556,"1"=>556,"2"=>556,"3"=>556,"4"=>556,"5"=>556,"6"=>556,"7"=>556,"8"=>556,"9"=>556,":"=>278,";"=>278,"<"=>584,"="=>584,">"=>584,"?"=>556,"@"=>1015,"A"=>667,"B"=>667,"C"=>722,"D"=>722,"E"=>667,"F"=>611,"G"=>778,"H"=>722,"I"=>278,"J"=>500,"K"=>667,"L"=>556,"M"=>833,"N"=>722,"O"=>778,"P"=>667,"Q"=>778,"R"=>722,"S"=>667,"T"=>611,"U"=>722,"V"=>667,"W"=>944,"X"=>667,"Y"=>667,"Z"=>611,"["=>278,"\\"=>278,"]"=>278,"^"=>469,"_"=>556,"`"=>333,"a"=>556,"b"=>556,"c"=>500,"d"=>556,"e"=>556,"f"=>278,"g"=>556,"h"=>556,"i"=>222,"j"=>222,"k"=>500,"l"=>222,"m"=>833,"n"=>556,"o"=>556,"p"=>556,"q"=>556,"r"=>333,"s"=>500,"t"=>278,"u"=>556,"v"=>500,"w"=>722,"x"=>500,"y"=>500,"z"=>500,"{"=>334,"|"=>260,"}"=>334,"~"=>584);
}

function AddLink()
{
	$n = count($this->links)+1;
	$this->links[$n] = array(0, 0);
	return $n;
}

function SetLink($link, $y=0, $page=-1)
{
	if ($y==-1)
		$y = $this->y;
	if ($page==-1)
		$page = $this->page;
	$this->links[$link] = array($page, $y);
}

function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false, $link='')
{
	$k = $this->k;
	$s = '';
	if ($fill || $border==1)
	{
		$op = $fill ? ($border==1 ? 'B' : 'f') : 'S';
		$s = sprintf('%.2F %.2F %.2F %.2F re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
	}
	if (is_string($border))
	{
		$x = $this->x;
		$y = $this->y;
		if (strpos($border,'L')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
		if (strpos($border,'T')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
		if (strpos($border,'R')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
		if (strpos($border,'B')!==false)
			$s .= sprintf('%.2F %.2F m %.2F %.2F l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
	}
	if ($txt!=='')
	{
		$txt = str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt)));
		$s .= sprintf('BT %.2F %.2F Td (%s) Tj ET',($this->x)*$k,($this->h-($this->y+$h-0.3*$h))*$k,$txt);
		if ($link)
		{
			$this->Link($this->x,$this->y,$w,$h,$link);
		}
	}
	if ($s)
		$this->_out($s);
	$this->lasth = $h;
	if ($ln>0)
	{
		$this->y += $h;
		if ($ln==1)
			$this->x = $this->lMargin;
	}
	else
		$this->x += $w;
}

function Ln($h=null)
{
	$this->x = $this->lMargin;
	if($h===null)
		$this->y += $this->lasth;
	else
		$this->y += $h;
}

function Output($name='', $dest='')
{
	if ($this->state==0)
		$this->Close();
	if ($dest=='')
		$dest = 'I';
	if ($name=='')
		$name = 'doc.pdf';
	$dest = strtoupper($dest);
	switch($dest)
	{
		case 'I':
			header('Content-Type: application/pdf');
			header('Content-Disposition: inline; filename="'.$name.'"');
			echo $this->buffer;
			break;
		case 'D':
			header('Content-Type: application/x-download');
			header('Content-Disposition: attachment; filename="'.$name.'"');
			header('Cache-Control: private, max-age=0, must-revalidate');
			header('Pragma: public');
			echo $this->buffer;
			break;
		default:
			$this->Error('Incorrect output destination: '.$dest);
	}
	return '';
}

function Close()
{
	if ($this->state==3)
		return;
	$this->_endpage();
	$this->_enddoc();
}

// Protected / Internal methods
protected function _begindoc()
{
	$this->state = 1;
	$this->_out('%PDF-'.$this->PDFVersion);
}

protected function _enddoc()
{
	$this->_putpages();
	$this->_putresources();
	// Catalog
	$this->_newobj(1);
	$this->_out('<<');
	$this->_out('/Type /Catalog');
	$this->_out('/Pages 2 0 R');
	if ($this->ZoomMode=='fullpage')
		$this->_out('/OpenAction [3 0 R /Fit]');
	elseif ($this->ZoomMode=='fullwidth')
		$this->_out('/OpenAction [3 0 R /FitH null]');
	elseif ($this->ZoomMode=='real')
		$this->_out('/OpenAction [3 0 R /XYZ null null 1]');
	elseif (!is_string($this->ZoomMode))
		$this->_out('/OpenAction [3 0 R /XYZ null null '.sprintf('%.2F',$this->ZoomMode/100).']');
	if ($this->LayoutMode=='single')
		$this->_out('/PageLayout /SinglePage');
	elseif ($this->LayoutMode=='continuous')
		$this->_out('/PageLayout /OneColumn');
	elseif ($this->LayoutMode=='two')
		$this->_out('/PageLayout /TwoColumnLeft');
	$this->_out('>>');
	$this->_out('endobj');
	// Info
	$this->_newobj(2);
	$this->_out('<<');
	foreach($this->metadata as $key=>$value)
		$this->_out('/'.$key.' '.$this->_textstring($value));
	$this->_out('/Producer '.$this->_textstring('FPDF '.FPDF_VERSION));
	$this->_out('/CreationDate '.$this->_textstring('D:'.date('YmdHis')));
	$this->_out('>>');
	$this->_out('endobj');
	// Pages root
	$nb = $this->page;
	$this->_newobj(3);
	$this->_out('<<');
	$this->_out('/Type /Pages');
	$kids = '/Kids [';
	for($i=1;$i<=$nb;$i++)
		$kids .= (3+$i).' 0 R ';
	$kids .= ']';
	$this->_out($kids);
	$this->_out('/Count '.$nb);
	$this->_out('>>');
	$this->_out('endobj');
	// Page objects
	for($n=1;$n<=$nb;$n++)
	{
		$this->_newobj(3+$n);
		$this->_out('<</Type /Page');
		$this->_out('/Parent 3 0 R');
		if(isset($this->PageSizes[$n]))
			$this->_out(sprintf('/MediaBox [0 0 %.2F %.2F]',$this->PageSizes[$n][0],$this->PageSizes[$n][1]));
		$this->_out('/Resources 4 0 R');
		$this->_out('/Contents '.($this->n+1).' 0 R>>');
		$this->_out('endobj');

		// Page content
		$p = $this->pages[$n];
		$this->_newobj();
		$len = strlen($p);
		$this->_out('<<');
		if($this->compress)
		{
			$p = gzcompress($p);
			$this->_out('/Filter /FlateDecode');
		}
		$this->_out('/Length '.$len.'>>');
		$this->_out('stream');
		$this->_out($p);
		$this->_out('endstream');
		$this->_out('endobj');
	}
	// Resources
	$this->_newobj(4);
	$this->_out('<< /ProcSet [/PDF /Text] /Font <<');
	foreach($this->fonts as $font)
		$this->_out('/F'.$font['i'].' '.$font['i'].' 0 R');
	$this->_out('>> >>');
	$this->_out('endobj');
	// Fonts
	$i = $this->n;
	foreach($this->fonts as $font)
	{
		$this->_newobj($font['i']);
		$this->_out('<</Type /Font');
		$this->_out('/Subtype /Type1');
		$this->_out('/BaseFont /'.strtoupper($font['name']));
		$this->_out('/Encoding /WinAnsiEncoding');
		$this->_out('>>');
		$this->_out('endobj');
	}
	// XRef
	$pos = strlen($this->buffer);
	$this->_out('xref');
	$this->_out('0 '.($this->n+1));
	$this->_out('0000000000 65535 f ');
	for($i=1;$i<=$this->n;$i++)
		$this->_out(sprintf('%010d 00000 n ',$this->offsets[$i]));
	// Trailer
	$this->_out('trailer');
	$this->_out('<<');
	$this->_out('/Size '.($this->n+1));
	$this->_out('/Root 1 0 R');
	$this->_out('/Info 2 0 R');
	$this->_out('>>');
	$this->_out('startxref');
	$this->_out($pos);
	$this->_out('%%EOF');
	$this->state = 3;
}

protected function _beginpage($orientation, $format)
{
	$this->page++;
	$this->pages[$this->page] = '';
	$this->state = 2;
	$this->x = $this->lMargin;
	$this->y = $this->tMargin;
	$this->FontFamily = '';
	// Page format
	if ($orientation=='')
		$orientation = $this->DefOrientation;
	else
		$orientation = strtoupper($orientation[0]);
	if ($format=='')
		$format = $this->DefPageFormat;
	else
		$format = $this->_getpageformat($format);
	if ($orientation!=$this->DefOrientation || $format!=$this->DefPageFormat)
		$this->PageSizes[$this->page] = array($format[0],$format[1]);
	if ($orientation=='P') {
		$this->w = $format[0]/$this->k;
		$this->h = $format[1]/$this->k;
	}
	else {
		$this->w = $format[1]/$this->k;
		$this->h = $format[0]/$this->k;
	}
	$this->wPt = $this->w*$this->k;
	$this->hPt = $this->h*$this->k;
	$this->PageBreakTrigger = $this->h-$this->bMargin;
	$this->CurOrientation = $orientation;
	$this->CurPageFormat = $format;
}

protected function _endpage()
{
	$this->state = 1;
}

protected function _newobj($n=null)
{
	if ($n===null)
		$n = ++$this->n;
	else
		$this->n = $n;
	$this->offsets[$this->n] = strlen($this->buffer);
	$this->_out($this->n.' 0 obj');
}

protected function _putpages()
{
}

protected function _putresources()
{
}

protected function _textstring($s)
{
	return '('.str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$s))).')';
}

protected function _out($s)
{
	if ($this->state==2)
		$this->pages[$this->page] .= $s."\n";
	else
		$this->buffer .= $s."\n";
}

protected function _getpageformat($format)
{
	if (is_string($format))
	{
		$format = strtolower($format);
		if (!isset($this->PageFormats[$format]))
			$this->Error('Unknown page format: '.$format);
		$size = $this->PageFormats[$format];
	}
	else
	{
		if (!is_array($format) || count($format)!=2)
			$this->Error('Invalid page format: '.$format);
		$size = $format;
	}
	return $size;
}

protected function _dochecks()
{
	if (ini_get('mbstring.func_overload') & 2)
		$this->Error('mbstring overloading must be disabled');
}

function Error($msg)
{
	throw new \Exception('FPDF error: '.$msg);
}
}
?>
