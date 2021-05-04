<?php
// require_once APPPATH.'/vendor/autoload.php';
class Fpdf_psg extends FPDF
{
	public function __construct()
	{
		parent::__construct();
		setlocale(LC_ALL, "es_ES");
	}

	protected $wLine; // Maximum width of the line
	protected $hLine; // Height of the line
	protected $Text; // Text to display
	protected $border;
	protected $align; // Justification of the text
	protected $fill;
	protected $Padding;
	protected $lPadding;
	protected $tPadding;
	protected $bPadding;
	protected $rPadding;
	protected $TagStyle; // Style for each tag
	protected $Indent;
	protected $Bullet; // Bullet character
	protected $Space; // Minimum space between words
	protected $PileStyle;
	protected $Line2Print; // Line to display
	protected $NextLineBegin; // Buffer between lines
	protected $TagName;
	protected $Delta; // Maximum width minus width
	protected $StringLength;
	protected $LineLength;
	protected $wTextLine; // Width minus paddings
	protected $nbSpace; // Number of spaces in the line
	protected $Xini; // Initial position
	protected $href; // Current URL
	protected $TagHref; // URL for a cell
	protected $rotacion;
	protected $header;
	protected $footer;

	public function agregarPagina($orientacion = '', $tamano = '', $rotacion = 0, $encabezado = true, $piePagina = true, $img = array())
	{
		$this->AddPage($orientacion, $tamano, $rotacion);
		$this->rotation = $rotacion;
		$this->header = $encabezado;
		$this->footer = $piePagina;
		if ($encabezado) {
			$this->InHeader = true;
			$this->encabezado(); // $this->Header()
			$this->InHeader = false;
		}

		if ($piePagina) {
			$this->InFooter = true;
			$this->piePagina();  // $this->Footer()
			$this->InFooter = false;
		}
		$this->SetY(25);
	}

	public function celda($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
	{
		$this->CheckPageBreak($h);
		$this->Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
	}

	function multiCelda($w, $h, $txt, $border = 0, $align = 'J', $fill = false)
	{
		// Output text with automatic or explicit line breaks
		if (!isset($this->CurrentFont))
			$this->Error('No font has been set');
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 && $s[$nb - 1] == "\n")
			$nb--;
		$b = 0;
		if ($border) {
			if ($border == 1) {
				$border = 'LTRB';
				$b = 'LRT';
				$b2 = 'LR';
			} else {
				$b2 = '';
				if (strpos($border, 'L') !== false)
					$b2 .= 'L';
				if (strpos($border, 'R') !== false)
					$b2 .= 'R';
				$b = (strpos($border, 'T') !== false) ? $b2 . 'T' : $b2;
			}
		}
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$ns = 0;
		$nl = 1;
		while ($i < $nb) {
			// Get next character
			$c = $s[$i];
			if ($c == "\n") {
				// Explicit line break
				if ($this->ws > 0) {
					$this->ws = 0;
					$this->_out('0 Tw');
				}
				$this->celda($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$ns = 0;
				$nl++;
				if ($border && $nl == 2)
					$b = $b2;
				continue;
			}
			if ($c == ' ') {
				$sep = $i;
				$ls = $l;
				$ns++;
			}
			$l += $cw[$c];
			if ($l > $wmax) {
				// Automatic line break
				if ($sep == -1) {
					if ($i == $j)
						$i++;
					if ($this->ws > 0) {
						$this->ws = 0;
						$this->_out('0 Tw');
					}
					$this->celda($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
				} else {
					if ($align == 'J') {
						$this->ws = ($ns > 1) ? ($wmax - $ls) / 1000 * $this->FontSize / ($ns - 1) : 0;
						$this->_out(sprintf('%.3F Tw', $this->ws * $this->k));
					}
					$this->celda($w, $h, substr($s, $j, $sep - $j), $b, 2, $align, $fill);
					$i = $sep + 1;
				}
				$sep = -1;
				$j = $i;
				$l = 0;
				$ns = 0;
				$nl++;
				if ($border && $nl == 2)
					$b = $b2;
			} else
				$i++;
		}
		// Last chunk
		if ($this->ws > 0) {
			$this->ws = 0;
			$this->_out('0 Tw');
		}
		if ($border && strpos($border, 'B') !== false)
			$b .= 'B';
		$this->celda($w, $h, substr($s, $j, $i - $j), $b, 2, $align, $fill);
		$this->x = $this->lMargin;
	}

	public function imagen($file, $x = null, $y = null, $w = 0, $h = 0, $type = '', $link = '')
	{
		if ($y === null) {
			if ($this->y + $h > $this->PageBreakTrigger && !$this->InHeader && !$this->InFooter && $this->AcceptPageBreak()) {
				// Automatic page break
				$x2 = $this->x;
				$this->agregarPagina($this->CurOrientation, $this->CurPageSize, $this->CurRotation);
				$this->x = $x2;
			}
			$y = $this->y;
			$this->y += $h;
		}
		$this->Image($file, $x, $y, $w, $h, $type, $link);
	}

	public function medidas()
	{
		if ($this->CurOrientation == 'p' || $this->CurOrientation == 'pontrait' || $this->CurOrientation == 'P') {
			$medidas = [
				'x_imagen_posgrado' => 170,
				'w_imagen_footer' => 200,
				'h_imagen_footer' => 270,
				'y' => -28

			];
			return $medidas;
		} else {
			$medidas = [
				'x_imagen_posgrado' => 230,
				'w_imagen_footer' => 260,
				'h_imagen_footer' => 210,
				'y' => -22
			];
			return $medidas;
		}
	}

	public function Header()
	{
		// $this->SetTopMargin(10);
		// $this->SetLeftMargin(20);
		// $this->SetRightMargin(19);
		// $this->SetAutoPageBreak(1, 20);

		// $m = $this->medidas();
		// $this->Image(APPPATH . '../public_html/img/upea.png', 20, 3, 15, 'jpg');
		// $this->Image(APPPATH . '../public_html/img/posgrado.png', $m['x_imagen_posgrado'], 8, 30, 11, 'png', '');
		// $this->AddFont('EdwardianScriptITC', 'I', 'EdwardianScriptITC.php');
		// $this->AddFont('helvetica', 'I', 'helvetica.php');
		// $this->SetTextColor(0, 0, 0); //Color del texto: Negro
		// $this->SetFont('EdwardianScriptITC', 'I', 30);
		// #$this->Ln();
		// $this->Cell(0, 0, utf8_decode('Universidad Pública de El Alto'), 0, 1, 'C');  // $this->Cell(ANCHO, ALTO, 'UNIVERSIDAD PUBLICA DE EL ALTO', margen, 1=seguido, 'alineacion');
		// $this->Ln(5);
		// $this->SetFont('Arial', 'I', 6);
		// $this->Cell(0, 2, 'Creada por Ley 2115 del 5 de Septiembre de 2000 y Autonoma por Ley 2556 del 12 de Noviembre de 2003', 0, 1, 'C');
		// $this->Ln(2.5);
		// $this->SetX(20);
		// $this->Cell(0, 1, null, 'B', 0, 'C');
		// // $this->Cell(0, 0, '        ________________________________________________________________________________________________________________________________________________________', 0, 1, 'C');
		// $this->Ln(4);
		// $this->SetTopMargin(5);
		// $this->SetLeftMargin(20);
		// $this->SetRightMargin(19);
		// $this->SetAutoPageBreak(1, 20);
	}

	public function encabezado($img = array())
	{
		if ($img) {
			# code...
		}
		$this->SetTopMargin(10);
		$this->SetLeftMargin(20);
		$this->SetRightMargin(19);
		$this->SetAutoPageBreak(1, 20);

		$m = $this->medidas();
		$this->Image(APPPATH . '../public_html/img/upea.png', 20, 3, 15, 'jpg');
		$this->Image(APPPATH . '../public_html/img/posgrado.png', $m['x_imagen_posgrado'], 8, 30, 11, 'png', '');
		$this->AddFont('EdwardianScriptITC', 'I', 'EdwardianScriptITC.php');
		$this->AddFont('helvetica', 'I', 'helvetica.php');
		$this->SetTextColor(0, 0, 0); //Color del texto: Negro
		$this->SetFont('EdwardianScriptITC', 'I', 30);
		#$this->Ln();
		$this->Cell(0, 0, utf8_decode('Universidad Pública de El Alto'), 0, 1, 'C');  // $this->Cell(ANCHO, ALTO, 'UNIVERSIDAD PUBLICA DE EL ALTO', margen, 1=seguido, 'alineacion');
		$this->Ln(5);
		$this->SetFont('Arial', 'I', 6);
		$this->Cell(0, 2, 'Creada por Ley 2115 del 5 de Septiembre de 2000 y Autonoma por Ley 2556 del 12 de Noviembre de 2003', 0, 1, 'C');
		$this->Ln(2.5);
		$this->SetX(20);
		$this->Cell(0, 1, null, 'B', 0, 'C');
		// $this->Cell(0, 0, '        ________________________________________________________________________________________________________________________________________________________', 0, 1, 'C');
		$this->Ln(4);
		// $this->SetY(25);
		// $this->SetTopMargin(5);
		// $this->SetLeftMargin(20);
		// $this->SetRightMargin(19);
		// $this->SetAutoPageBreak(1, 20);
	}

	// function Footer()
	function piePagina()
	{
		$m = $this->medidas();
		// $this->Image(FCPATH . 'img/marca-de-agua.png', 8, 0, $m['w_imagen_footer'], $m['h_imagen_footer']); //208, 288)
		$this->SetXY(15, $m['y']);
		// Arial italic 8
		$this->SetFont('Arial', 'I', 6);
		// $this->SetTextColor(256,256,256);
		// Número de página
		$this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'L');
		$this->AliasNbPages();
	}
	function Footer()
	{
		// $m = $this->medidas();
		// $this->Image(FCPATH . 'img/marca-de-agua.png', 8, 0, $m['w_imagen_footer'], $m['h_imagen_footer']); //208, 288)
		// $this->SetXY(15, $m['y']);
		// // Arial italic 8
		// $this->SetFont('Arial', 'I', 6);
		// // $this->SetTextColor(256,256,256);
		// // Número de página
		// $this->Cell(0, 10, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'L');
		// $this->AliasNbPages();
	}
	public function nombre_mes($mes)
	{
		setlocale(LC_TIME, 'spanish');
		$mesResul = strftime("%B", mktime(0, 0, 0, $mes, 1, 2000));
		return $mesResul;
	}
	function AjustCell($w, $h = 0, $txt = '', $border = 0, $ln = 0, $align = '', $fill = false, $link = '')
	{
		$TamanoInicial = $this->FontSizePt;
		$TamanoLetra = $this->FontSizePt;
		$Decremento = 0.5;
		while ($this->GetStringWidth($txt) > $w)
			$this->SetFontSize($TamanoLetra -= $Decremento);
		$this->celda($w, $h, $txt, $border, $ln, $align, $fill, $link);
		$this->SetFontSize($TamanoInicial);
	}

	function AjustMultiCell($width = null, $data = null, $w, $h = 0, $txt = '', $border = 0, $align = '')
	{
		if (!is_null($width) && !is_null($data)) {
			$TamanoInicial = $this->FontSizePt;
			// $TamanoLetra = $
			// $Decremento = 0.5;
			// while ($this->GetStringWidth($txt) > ($w))
			// $this->SetFontSize($TamanoLetra -= $Decremento);
			$this->SetFontSize($width);
			$this->MultiCell($w, $h, $txt, $border, $align);
			$this->SetFontSize($TamanoInicial);
		} else {
		}
	}

	public function getFontSize($datos)
	{
		// return var_dump($this->type_cell[0]);
		$TamanoInicial = $this->FontSizePt;
		$TamanoLetra = $this->FontSizePt;
		$Decremento = 0.5;
		for ($i = 0; $i < count($datos); $i++) {
			if ($this->type_cell[$i] == 'm') {
				$palabras = str_word_count(utf8_decode($datos[$i]), 1, '1234567890|°¬!"#$%&/()=?¿¡+*~{[}],;.:-_<>');
				// return var_dump($palabras);
				$numero_palabras = count($palabras);
				if ($numero_palabras > 1) {
					for ($j = 0; $j < $numero_palabras; $j++) {
						$p[$j]['tamaño'] = strlen($palabras[$j]);
						$p[$j]['string'] = $palabras[$j];
					}
					$string_largo = max($p);

					while ($this->GetStringWidth($string_largo['string']) > $this->widths[$i]) {
						$TamanoLetra -= $Decremento;
						$this->SetFontSize($TamanoLetra);
					}
					$tamano[$i] = $TamanoLetra;
				} else {
					$this->type_cell[$i] = 'c';
				}
			} else {
				$tamano[$i] = $TamanoInicial;
			}
		}
		// return var_dump($m);
		// return var_dump($this->GetStringWidth($string_largo['string']),$this->widths[0]);
		return $tamano;
	}

	function SetWidths($w)
	{
		//Set the array of column widths
		$this->widths = $w;
	}

	function SetAligns($a)
	{
		//Set the array of column alignments
		$this->aligns = $a;
	}
	function SetTypeCell($c)
	{
		// Sets the cell type of a column to the array
		$this->type_cell = $c;
	}

	function Row($data, $fill = 'D')
	{
		// return var_dump($this->getFontSize($data));
		//Calculate the height of the row
		$nb = 0;
		for ($i = 0; $i < count($data); $i++)
			$nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
		$h = 5 * $nb;
		//Issue a page break first if needed
		$this->CheckPageBreak($h);
		//Draw the cells of the row
		for ($i = 0; $i < count($data); $i++) {
			$w = $this->widths[$i];
			$a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'C';
			//Save the current position
			$x = $this->GetX();
			$y = $this->GetY();
			//Draw the border
			$this->Rect($x, $y, $w, $h, $fill);
			//Print the text
			if (isset($this->type_cell)) {
				#$this->type_cell = isset($this->aligns[$i]) ? $this->aligns[$i] : 'multicell';
				switch ($this->type_cell[$i]) {
					case 'm':
						$this->multiCelda($w, 5, $data[$i], 0, $a);
						// $this->AjustMultiCell($w,5,$data[$i],0,$a);
						break;
					case 'c':
						$this->celda($w, $h, $data[$i], 0, 0, $a);
						// $this->AjustCell($w,$h,$data[$i],0,0,$a);
						break;
					case 'wt':
						$this->WriteTag($w, 4, $data[$i], 0, $a, false, 1);
						break;
					default:
						$this->multiCelda($w, 5, $data[$i], 0, $a);
						break;
				}
			} else {
				$this->multiCelda($w, 5, $data[$i], 0, $a);
			}
			//Put the position to the right of the cell
			$this->SetXY($x + $w, $y);
		}
		//Go to the next line
		$this->Ln($h);
	}

	function NbLines($w, $txt)
	{
		//Computes the number of lines a MultiCell of width w will take
		$cw = &$this->CurrentFont['cw'];
		if ($w == 0)
			$w = $this->w - $this->rMargin - $this->x;
		$wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
		$s = str_replace("\r", '', $txt);
		$nb = strlen($s);
		if ($nb > 0 and $s[$nb - 1] == "\n")
			$nb--;
		$sep = -1;
		$i = 0;
		$j = 0;
		$l = 0;
		$nl = 1;
		while ($i < $nb) {
			$c = $s[$i];
			if ($c == "\n") {
				$i++;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
				continue;
			}
			if ($c == ' ')
				$sep = $i;
			$l += $cw[$c];
			if ($l > $wmax) {
				if ($sep == -1) {
					if ($i == $j)
						$i++;
				} else
					$i = $sep + 1;
				$sep = -1;
				$j = $i;
				$l = 0;
				$nl++;
			} else
				$i++;
		}
		return $nl;
	}

	function CheckPageBreak($h)
	{
		//If the height h would cause an overflow, add a new page immediately
		if ($this->GetY() + $h > $this->PageBreakTrigger) {
			// $this->AddPage($this->CurOrientation, $this->CurPageSize);
			$this->agregarPagina($this->CurOrientation, $this->CurPageSize, $this->rotacion, $this->header, $this->footer);
			$this->Ln();
		}
	}

	function WriteTag($w, $h, $txt, $border = 0, $align = "J", $fill = false, $padding = 0)
	{
		$this->wLine = $w;
		$this->hLine = $h;
		$this->Text = trim($txt);
		$this->Text = preg_replace("/\n|\r|\t/", "", $this->Text);
		$this->border = $border;
		$this->align = $align;
		$this->fill = $fill;
		$this->Padding = $padding;

		$this->Xini = $this->GetX();
		$this->href = "";
		$this->PileStyle = array();
		$this->TagHref = array();
		$this->LastLine = false;
		$this->NextLineBegin = array();

		$this->SetSpace();
		$this->Padding();
		$this->LineLength();
		$this->BorderTop();

		while ($this->Text != "") {
			$this->MakeLine();
			$this->PrintLine();
		}

		$this->BorderBottom();
	}


	function SetStyle($tag, $family, $style, $size, $color, $indent = -1, $bullet = '')
	{
		$tag = trim($tag);
		$this->TagStyle[$tag]['family'] = trim($family);
		$this->TagStyle[$tag]['style'] = trim($style);
		$this->TagStyle[$tag]['size'] = trim($size);
		$this->TagStyle[$tag]['color'] = trim($color);
		$this->TagStyle[$tag]['indent'] = $indent;
		$this->TagStyle[$tag]['bullet'] = $bullet;
	}


	// Private Functions

	function SetSpace() // Minimal space between words
	{
		$tag = $this->Parser($this->Text);
		$this->FindStyle($tag[2], 0);
		$this->DoStyle(0);
		$this->Space = $this->GetStringWidth(" ");
	}


	function Padding()
	{
		if (preg_match("/^.+,/", $this->Padding)) {
			$tab = explode(",", $this->Padding);
			$this->lPadding = $tab[0];
			$this->tPadding = $tab[1];
			if (isset($tab[2]))
				$this->bPadding = $tab[2];
			else
				$this->bPadding = $this->tPadding;
			if (isset($tab[3]))
				$this->rPadding = $tab[3];
			else
				$this->rPadding = $this->lPadding;
		} else {
			$this->lPadding = $this->Padding;
			$this->tPadding = $this->Padding;
			$this->bPadding = $this->Padding;
			$this->rPadding = $this->Padding;
		}
		if ($this->tPadding < $this->LineWidth)
			$this->tPadding = $this->LineWidth;
	}


	function LineLength()
	{
		if ($this->wLine == 0)
			$this->wLine = $this->w - $this->Xini - $this->rMargin;

		$this->wTextLine = $this->wLine - $this->lPadding - $this->rPadding;
	}


	function BorderTop()
	{
		$border = 0;
		if ($this->border == 1)
			$border = "TLR";
		$this->celda($this->wLine, $this->tPadding, "", $border, 0, 'C', $this->fill);
		$y = $this->GetY() + $this->tPadding;
		$this->SetXY($this->Xini, $y);
	}


	function BorderBottom()
	{
		$border = 0;
		if ($this->border == 1)
			$border = "BLR";
		$this->celda($this->wLine, $this->bPadding, "", $border, 0, 'C', $this->fill);
	}


	function DoStyle($ind) // Applies a style
	{
		if (!isset($this->TagStyle[$ind]))
			return;

		$this->SetFont(
			$this->TagStyle[$ind]['family'],
			$this->TagStyle[$ind]['style'],
			$this->TagStyle[$ind]['size']
		);

		$tab = explode(",", $this->TagStyle[$ind]['color']);
		if (count($tab) == 1)
			$this->SetTextColor($tab[0]);
		else
			$this->SetTextColor($tab[0], $tab[1], $tab[2]);
	}


	function FindStyle($tag, $ind) // Inheritance from parent elements
	{
		$tag = trim($tag);

		// Family
		if ($this->TagStyle[$tag]['family'] != "")
			$family = $this->TagStyle[$tag]['family'];
		else {
			foreach ($this->PileStyle as $val) {
				$val = trim($val);
				if ($this->TagStyle[$val]['family'] != "") {
					$family = $this->TagStyle[$val]['family'];
					break;
				}
			}
		}

		// Style
		$style = "";
		$style1 = strtoupper($this->TagStyle[$tag]['style']);
		if ($style1 != "N") {
			$bold = false;
			$italic = false;
			$underline = false;
			foreach ($this->PileStyle as $val) {
				$val = trim($val);
				$style1 = strtoupper($this->TagStyle[$val]['style']);
				if ($style1 == "N")
					break;
				else {
					if (strpos($style1, "B") !== false)
						$bold = true;
					if (strpos($style1, "I") !== false)
						$italic = true;
					if (strpos($style1, "U") !== false)
						$underline = true;
				}
			}
			if ($bold)
				$style .= "B";
			if ($italic)
				$style .= "I";
			if ($underline)
				$style .= "U";
		}

		// Size
		if ($this->TagStyle[$tag]['size'] != 0)
			$size = $this->TagStyle[$tag]['size'];
		else {
			foreach ($this->PileStyle as $val) {
				$val = trim($val);
				if ($this->TagStyle[$val]['size'] != 0) {
					$size = $this->TagStyle[$val]['size'];
					break;
				}
			}
		}

		// Color
		if ($this->TagStyle[$tag]['color'] != "")
			$color = $this->TagStyle[$tag]['color'];
		else {
			foreach ($this->PileStyle as $val) {
				$val = trim($val);
				if ($this->TagStyle[$val]['color'] != "") {
					$color = $this->TagStyle[$val]['color'];
					break;
				}
			}
		}

		// Result
		$this->TagStyle[$ind]['family'] = $family;
		$this->TagStyle[$ind]['style'] = $style;
		$this->TagStyle[$ind]['size'] = $size;
		$this->TagStyle[$ind]['color'] = $color;
		$this->TagStyle[$ind]['indent'] = $this->TagStyle[$tag]['indent'];
	}


	function Parser($text)
	{
		$tab = array();
		// Closing tag
		if (preg_match("|^(</([^>]+)>)|", $text, $regs)) {
			$tab[1] = "c";
			$tab[2] = trim($regs[2]);
		}
		// Opening tag
		else if (preg_match("|^(<([^>]+)>)|", $text, $regs)) {
			$regs[2] = preg_replace("/^a/", "a ", $regs[2]);
			$tab[1] = "o";
			$tab[2] = trim($regs[2]);

			// Presence of attributes
			if (preg_match("/(.+) (.+)='(.+)'/", $regs[2])) {
				$tab1 = preg_split("/ +/", $regs[2]);
				$tab[2] = trim($tab1[0]);
				foreach ($tab1 as $i => $couple) {
					if ($i > 0) {
						$tab2 = explode("=", $couple);
						$tab2[0] = trim($tab2[0]);
						$tab2[1] = trim($tab2[1]);
						$end = strlen($tab2[1]) - 2;
						$tab[$tab2[0]] = substr($tab2[1], 1, $end);
					}
				}
			}
		}
		// Space
		else if (preg_match("/^( )/", $text, $regs)) {
			$tab[1] = "s";
			$tab[2] = ' ';
		}
		// Text
		else if (preg_match("/^([^< ]+)/", $text, $regs)) {
			$tab[1] = "t";
			$tab[2] = trim($regs[1]);
		}

		$begin = strlen($regs[1]);
		$end = strlen($text);
		$text = substr($text, $begin, $end);
		$tab[0] = $text;

		return $tab;
	}


	function MakeLine()
	{
		$this->Text .= " ";
		$this->LineLength = array();
		$this->TagHref = array();
		$Length = 0;
		$this->nbSpace = 0;

		$i = $this->BeginLine();
		$this->TagName = array();

		if ($i == 0) {
			$Length = $this->StringLength[0];
			$this->TagName[0] = 1;
			$this->TagHref[0] = $this->href;
		}

		while ($Length < $this->wTextLine) {
			$tab = $this->Parser($this->Text);
			$this->Text = $tab[0];
			if ($this->Text == "") {
				$this->LastLine = true;
				break;
			}

			if ($tab[1] == "o") {
				array_unshift($this->PileStyle, $tab[2]);
				$this->FindStyle($this->PileStyle[0], $i + 1);

				$this->DoStyle($i + 1);
				$this->TagName[$i + 1] = 1;
				if ($this->TagStyle[$tab[2]]['indent'] != -1) {
					$Length += $this->TagStyle[$tab[2]]['indent'];
					$this->Indent = $this->TagStyle[$tab[2]]['indent'];
					$this->Bullet = $this->TagStyle[$tab[2]]['bullet'];
				}
				if ($tab[2] == "a")
					$this->href = $tab['href'];
			}

			if ($tab[1] == "c") {
				array_shift($this->PileStyle);
				if (isset($this->PileStyle[0])) {
					$this->FindStyle($this->PileStyle[0], $i + 1);
					$this->DoStyle($i + 1);
				}
				$this->TagName[$i + 1] = 1;
				if ($this->TagStyle[$tab[2]]['indent'] != -1) {
					$this->LastLine = true;
					$this->Text = trim($this->Text);
					break;
				}
				if ($tab[2] == "a")
					$this->href = "";
			}

			if ($tab[1] == "s") {
				$i++;
				$Length += $this->Space;
				$this->Line2Print[$i] = "";
				if ($this->href != "")
					$this->TagHref[$i] = $this->href;
			}

			if ($tab[1] == "t") {
				$i++;
				$this->StringLength[$i] = $this->GetStringWidth($tab[2]);
				$Length += $this->StringLength[$i];
				$this->LineLength[$i] = $Length;
				$this->Line2Print[$i] = $tab[2];
				if ($this->href != "")
					$this->TagHref[$i] = $this->href;
			}
		}

		// return var_dump(trim($this->Text));
		// trim($this->Text);
		if ($Length > $this->wTextLine || $this->LastLine == true)
			$this->EndLine();
	}


	function BeginLine()
	{
		$this->Line2Print = array();
		$this->StringLength = array();

		if (isset($this->PileStyle[0])) {
			$this->FindStyle($this->PileStyle[0], 0);
			$this->DoStyle(0);
		}

		if (count($this->NextLineBegin) > 0) {
			$this->Line2Print[0] = $this->NextLineBegin['text'];
			$this->StringLength[0] = $this->NextLineBegin['length'];
			$this->NextLineBegin = array();
			$i = 0;
		} else {
			preg_match("/^(( *(<([^>]+)>)* *)*)(.*)/", $this->Text, $regs);
			$regs[1] = str_replace(" ", "", $regs[1]);
			$this->Text = $regs[1] . $regs[5];
			$i = -1;
		}

		return $i;
	}


	function EndLine()
	{
		if (end($this->Line2Print) != "" && $this->LastLine == false) {
			$this->NextLineBegin['text'] = array_pop($this->Line2Print);
			$this->NextLineBegin['length'] = end($this->StringLength);
			array_pop($this->LineLength);
		}

		while (end($this->Line2Print) === "")
			array_pop($this->Line2Print);

		$this->Delta = $this->wTextLine - end($this->LineLength);

		$this->nbSpace = 0;
		for ($i = 0; $i < count($this->Line2Print); $i++) {
			if ($this->Line2Print[$i] == "")
				$this->nbSpace++;
		}
	}


	function PrintLine()
	{
		$border = 0;
		if ($this->border == 1)
			$border = "LR";
		$this->celda($this->wLine, $this->hLine, "", $border, 0, 'C', $this->fill);
		$y = $this->GetY();
		$this->SetXY($this->Xini + $this->lPadding, $y);

		if ($this->Indent > 0) {
			if ($this->Bullet != '')
				$this->SetTextColor(0);
			$this->celda($this->Indent, $this->hLine, $this->Bullet);
			$this->Indent = -1;
			$this->Bullet = '';
		}

		$space = $this->LineAlign();
		$this->DoStyle(0);
		for ($i = 0; $i < count($this->Line2Print); $i++) {
			if (isset($this->TagName[$i]))
				$this->DoStyle($i);
			if (isset($this->TagHref[$i]))
				$href = $this->TagHref[$i];
			else
				$href = '';
			if ($this->Line2Print[$i] == "")
				$this->celda($space, $this->hLine, "         ", 0, 0, 'C', false, $href);
			else
				$this->celda($this->StringLength[$i], $this->hLine, $this->Line2Print[$i], 0, 0, 'C', false, $href);
		}

		$this->LineBreak();
		if ($this->LastLine && $this->Text != "")
			$this->EndParagraph();
		$this->LastLine = false;
	}


	function LineAlign()
	{
		$space = $this->Space;
		if ($this->align == "J") {
			if ($this->nbSpace != 0)
				$space = $this->Space + ($this->Delta / $this->nbSpace);
			if ($this->LastLine)
				$space = $this->Space;
		}

		if ($this->align == "R")
			$this->celda($this->Delta, $this->hLine);

		if ($this->align == "C")
			$this->celda($this->Delta / 2, $this->hLine);

		return $space;
	}


	function LineBreak()
	{
		$x = $this->Xini;
		$y = $this->GetY() + $this->hLine;
		$this->SetXY($x, $y);
	}


	function EndParagraph()
	{
		$border = 0;
		if ($this->border == 1)
			$border = "LR";
		$this->celda($this->wLine, $this->hLine / 2, "", $border, 0, 'C', $this->fill);
		$x = $this->Xini;
		$y = $this->GetY() + $this->hLine / 2;
		$this->SetXY($x, $y);
	}

	protected $widths = [];
	public function getWidth($datos)
	{
		$w = array_fill(0, count($datos), 0);
		for ($i = 0; $i < count($datos); $i++) {
			for ($j = 0; $j < count($datos[$i]); $j++) {
				if (!is_null($datos[$i][$j]) || ($datos[$i][$j]) != '') {
					$a = 1.4 * ($this->GetStringWidth($datos[$i][$j]));
					if ($a > 20) {
						if ($w[$j] < $a) {
							$this->widths[$j] = $w[$j];
							// $this->widths[$j] = $a;
						} else {
							$this->widths[$j] = $a;
							// $this->widths[$j] = $w[$j];
						}
						$w[$j] = $a;
					} elseif ($a <= 20) {
						$this->widths[$j] = 15;
						$w[$j] = 15;
					}
				} else {
					$this->widths[$j] = 15;
					$w[$j] = 15;
				}
			}
		}
		return $this->widths;
	}

	protected $alings = [];
	public function getTypeCell($datos)
	{
		for ($i = 0; $i < count($datos); $i++) {
			for ($j = 0; $j < count($datos[$i]); $j++) {
				$a = 0.5 * ($this->GetStringWidth($datos[$i][$j]));
				if ($a < $this->widths[$j]) {
					$this->alings[$i][$j] = 'c';
				} else {
					$this->alings[$i][$j] = 'm';
				}
			}
		}
		return $this->alings;
	}

	public function getTypeCellKeys($datos)
	{
		for ($i = 0; $i < count($datos); $i++) {
			$a = $this->GetStringWidth($datos[$i]);
			if ($a < $this->widths[$i]) {
				$this->alings[$i] = 'c';
			} else {
				$this->alings[$i] = 'm';
			}
		}
		return $this->alings;
	}

	public function getOrientation($widths)
	{
		$total_width = 0;
		$orientation = '';

		for ($i = 0; $i < count($widths); $i++) {
			$total_width = $total_width + $widths[$i];
		}
		if ($total_width < 186) {
			$orientation = 'P';
		} else {
			$orientation = 'L';
		}

		return $orientation;
	}

	// public function utf8_decode_array($array)
	// {
	// 	// return var_dump($array);
	// 	for ($i = 0; $i < count($array); $i++) {
	// 		for ($j = 0; $j < count($array[$i]); $j++) {
	// 			$array[$i][$j] = utf8_decode($array[$i][$j]);
	// 		}
	// 	}
	// 	return $array;
	// }

	public function decodifica_array_utf8($datos)
	{
		return var_dump($datos);
		$datos_decodificados = array();
		for ($i = 0; $i < count($datos); $i++) {
			$datos[$i] = array_values($datos[$i]);
			for ($j = 0; $j < count($datos[$i]); $j++) {
				$datos_decodificados[$i][$j] = utf8_decode($datos[$i][$j]);
			}
		}
		return $datos_decodificados;
	}
}
