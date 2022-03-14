<?php

class PDF_WriteTag extends FPDF
{
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

	// VARIABLES
	public $ancho, $alto, $alto_subtitulo, $ancho_a, $sumar_alto = false;

	// Public Functions

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
		$this->Cell($this->wLine, $this->tPadding, "", $border, 0, 'C', $this->fill);
		$y = $this->GetY() + $this->tPadding;
		$this->SetXY($this->Xini, $y);
	}


	function BorderBottom()
	{
		$border = 0;
		if ($this->border == 1)
			$border = "BLR";
		$this->Cell($this->wLine, $this->bPadding, "", $border, 0, 'C', $this->fill);
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

		trim($this->Text);
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
		$this->Cell($this->wLine, $this->hLine, "", $border, 0, 'C', $this->fill);
		$y = $this->GetY();
		$this->SetXY($this->Xini + $this->lPadding, $y);

		if ($this->Indent > 0) {
			if ($this->Bullet != '')
				$this->SetTextColor(0);
			$this->Cell($this->Indent, $this->hLine, $this->Bullet);
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
				$this->Cell($space, $this->hLine, "         ", 0, 0, 'C', false, $href);
			else
				$this->Cell($this->StringLength[$i], $this->hLine, $this->Line2Print[$i], 0, 0, 'C', false, $href);
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
			$this->Cell($this->Delta, $this->hLine);

		if ($this->align == "C")
			$this->Cell($this->Delta / 2, $this->hLine);

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
		$this->Cell($this->wLine, $this->hLine / 2, "", $border, 0, 'C', $this->fill);
		$x = $this->Xini;
		$y = $this->GetY() + $this->hLine / 2;
		$this->SetXY($x, $y);
	}

	// METODOS
	public function print_qr($code, $x, $y, $fuente, $tamaño_fuente, array $color_fuente = [0, 0, 0],  $estilo = '')
	{
		$this->Image("http://localhost/generar_qr/qr_generator.php?code=" . $code, $x, $y, 36, 36, "png");
		// texto de verificacion qr
		$this->SetXY(intval($x), intval($y) + 35);
		$this->AddFont($fuente, '', $fuente . '.php');
		$this->SetFont($fuente, '', $tamaño_fuente);
		$this->SetTextColor($color_fuente[0], $color_fuente[1], $color_fuente[2]);
		$this->SetFillColor(255, 255, 255);
		$this->Rect($this->GetX(), $this->GetY() - 1, 36, 13.5, 'F');
		$this->MultiCell(36, 3.5, utf8_decode("Código QR de verificación del certificado"), 0, "C");
	}

	public function print_participante($nombre, $x, $y, $fuente, $tamaño_fuente, $fuente_A, $tamaño_fuente_A, array $color_fuente = [0, 0, 0], $estilo = '', $imprimir_A)
	{
		// Agregar la letra delante del nombre en el certificado
		if ($imprimir_A == "SI") {
			$this->AddFont($fuente_A, '', $fuente_A . ".php");
			$this->SetFont($fuente_A, '', $tamaño_fuente + $tamaño_fuente_A);
			$this->SetXY($x, $y);
			$this->Cell($this->ancho_a, $this->alto, utf8_decode("A: "), 0, 1, 'L');
		}
		if ($nombre != NULL) {
			$this->AddFont($fuente, '', $fuente . '.php');
			$this->SetFont($fuente, $estilo, $tamaño_fuente);
			$this->SetTextColor($color_fuente[0],  $color_fuente[1],  $color_fuente[2]);
			$this->SetXY($x + $this->ancho_a, $y);
			$this->AjustCell($this->ancho, $this->alto, utf8_decode(mb_convert_case(preg_replace('/\s+/', ' ', trim($nombre)), MB_CASE_UPPER)), 0, 1, 'C');
		}
	}

	public function print_tipo_partipacion($data, $x, $y, $fuente, $tamaño_fuente, $fuente_netrita, array $color_fuente = [0, 0, 0], $nota_aprobacion, $calificacion_final, $estilo = '')
	{
		$this->AddFont($fuente, '', $fuente . '.php');
		$this->AddFont($fuente_netrita, '', $fuente_netrita . '.php');

		$this->SetFont($fuente, $estilo, $tamaño_fuente);
		$this->SetStyle("p", $fuente, "", $tamaño_fuente, "$color_fuente[0],$color_fuente[1],$color_fuente[0]", 0);
		$this->SetStyle("vb", $fuente_netrita, "", $tamaño_fuente, "$color_fuente[0],$color_fuente[1],$color_fuente[0]");
		$this->SetTextColor(0, 0, 0);
		$this->SetXY($x, $y);
		switch ($data) {
			case 'PARTICIPANTE':
				$this->WriteTag($this->ancho, $this->alto, utf8_decode($this->verificar_aprobacion($nota_aprobacion, $calificacion_final)), 0);
				break;

			case 'EXPOSITOR':
				$this->WriteTag($this->ancho, $this->alto, utf8_decode("<p>Por haber participado en calidad de <vb>EXPOSITOR</vb> del curso práctico de:</p>"), 0);
				break;

			case 'ORGANIZADOR':
				$this->WriteTag($this->ancho, $this->alto, utf8_decode("<p>Por haber participado en calidad de <vb>ORGANIZADOR</vb> del curso práctico de:</p>"), 0);
				break;

			default:
				$this->WriteTag($this->ancho, $this->alto, utf8_decode("<p>Por haber <vb>PARTICIPADO</vb>  del curso práctico de:</p>"), 0);
				break;
		}
	}

	public function print_titulo_curso($nombre_curso, $x, $y, $fuente, $tamaño_fuente, $subtitulo, $fuente_subtitulo, $tamaño_fuente_subtitulo, array $color_fuente = [0, 0, 0], $tipo, $imprimir_subtitulo, $estilo = '')
	{
		// TÍTULO DEL CURSO
		$this->SetTextColor($color_fuente[0], $color_fuente[1], $color_fuente[2]);
		$this->SetXY($x, $y);
		$this->AddFont($fuente, '', $fuente . '.php');
		$this->SetFont($fuente, $estilo, $tamaño_fuente);
		$this->multiCelda($this->ancho, $this->alto, utf8_decode($nombre_curso), 0, 'C');
		$this->sumar_alto = false;
		//IMPRIMIR SUBITULO
		if ($tipo == "CURSO") {
			if ($imprimir_subtitulo == "1") {
				$this->sumar_alto = true;
				$this->SetXY($x, $this->GetY());
				$this->AddFont($fuente_subtitulo, '', $fuente_subtitulo . ".php");
				$this->SetFont($fuente_subtitulo, '', $tamaño_fuente_subtitulo);
				$this->Cell($this->ancho, $this->alto_subtitulo, utf8_decode($subtitulo), 0, 1, 'C');
			}
		}
	}

	public function print_bloque_texto($texto, $x, $y, $fuente, $tamaño_fuente, $fuente_negrita, array $color_fuente = [0, 0, 0], $fecha_certificacion, $estilo = '')
	{
		$this->SetTextColor($color_fuente[0], $color_fuente[1], $color_fuente[2]);
		$this->AddFont($fuente_negrita, '', $fuente_negrita . '.php');
		$this->AddFont($fuente, '', $fuente . '.php');

		$this->SetStyle("p", $fuente, $estilo, $tamaño_fuente, "$color_fuente[0], $color_fuente[1], $color_fuente[2]", 0);
		$this->SetStyle("vb", $fuente_negrita, "", $tamaño_fuente, "$color_fuente[0], $color_fuente[1], $color_fuente[2]");
		$s = ($this->sumar_alto === true) ? $this->alto_subtitulo : 0;
		$this->SetXY($x, ($y + $s));
		$this->WriteTag($this->ancho, $this->alto, $texto, 0);

		// FECHA DE CERTIFICACIÓN
		$this->SetX($x);
		$this->multiCelda($this->ancho, $this->alto + 2, utf8_decode(($fecha_certificacion)) . "  ", 0, 'R');
	}

	public function print_imagen($ruta, $x, $y, $w = 0, $h = 0)
	{
		$this->Image($ruta, $x, $y, $w, $h);
	}

	public function verificar_aprobacion($nota_aprobacion, $nota_final)
	{
		if (intval($nota_final) >= intval($nota_aprobacion)) {
			return "<p>Por haber <vb>APROBADO SATISFACTORIAMENTE</vb> el curso práctico de: </p>";
		} else {
			return "<p>Por haber <vb>PARTICIPADO</vb> del curso práctico de: </p>";
		}
	}
} // End of class
