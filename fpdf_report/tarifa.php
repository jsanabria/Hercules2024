<?php
require('rcs/fpdf.php');
require("connect.php");

class PDF extends FPDF
{
	// Cabecera de pбgina
	function Header()
	{
		// Consulto datos de la compaснa 
		require("connect.php");

		$this->SetFont('Arial','B',12);
		$this->Image('../phpimages/logo_letras.jpg',55,10,95);
		
		$this->Ln(30);
		$this->SetFont('Arial','B',8);
		$this->Cell(205,5,'PRECIOS SERVICIOS FUNERARIOS P/ INHUMACION',0,0,'C');
		$this->Ln();
		$this->Cell(205,5,'(NO INCLUYE EL PROCESO DE INHUMACION)',0,0,'C');


		$this->Ln(6);
		$this->SetFont('Arial','BU',12);
		$this->Cell(205,5,'CAPILLAS MONUMENTALES:',0,0,'C');

// MONUMENTAL INHUMACION
		$this->Ln(12);
		$this->SetFont('Arial','BU',10);
		$this->Cell(205,5,'CAPILLA MONUMENTAL',0,0,'C');

		$sql = "SELECT valor1 as iva FROM sco_parametro WHERE codigo = '002';";
		$resultado = mysql_query($sql) or die(mysql_error()); 
		$row = mysql_fetch_array($resultado);
		$iva = $row["iva"];


		$sql = "SELECT 
					(SELECT COUNT(localidad) 
					FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
					WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad) AS localidad, 
					c.nombre AS capilla, 
					(SELECT COUNT(tipo_servicio) 
					FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
					WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad AND tipo_servicio = t.tipo_servicio) AS tipo_servicio, 
					s.nombre AS servicio, 
					t.horas, 
					d.base, 
					d.Ncostos_tarifa_detalle, date_format(d.fecha, '%d/%m/%Y') AS fecha, t.Ncostos_tarifa,
					LPAD(SUBSTRING(t.horas, 1, POSITION(' ' IN t.horas)-1), 2, '0') as hr, 
					d.Ncostos_tarifa_detalle 
				FROM 
					sco_costos_tarifa t 
					JOIN sco_servicio_tipo c ON c.Nservicio_tipo = t.localidad 
					JOIN sco_servicio_tipo s ON s.Nservicio_tipo = t.tipo_servicio 
					JOIN sco_costos_tarifa_detalle d ON d.costos_tarifa = t.Ncostos_tarifa 
				WHERE 
					t.activo = 'S' AND d.cerrado = 'N' AND c.Nservicio_tipo = 'CAP0' AND s.Nservicio_tipo = 'SEPE' 
				ORDER BY c.Nservicio_tipo, s.Nservicio_tipo, hr";

		$resultado = mysql_query($sql) or die(mysql_error()); 
		$this->SetFont('Arial','B',8);
		$this->Ln(6);
		while($row = mysql_fetch_array($resultado))
		{
			$this->Cell(60);
			$this->Cell(30,4,"VELACION HASTA",0,0,'L');
			$this->Cell(20,4,trim($row["horas"]),0,0,'R');
			$this->Cell(30,4,(substr(trim($row["horas"]),0,2)=="24"?"* ":"") . "Bs. " . number_format(($row["base"] + ($row["base"]*($iva/100))), 2, ",", "."),0,0,'R');
			$this->Cell(60);
			$this->Ln(4);
		}
		$this->Ln(5);

// DEL ESTE INHUMACION
		//$this->Ln(12);
		$this->SetFont('Arial','BU',10);
		$this->Cell(200,5,'CAPILLA DEL ESTE',0,0,'C');

		$sql = "SELECT 
					(SELECT COUNT(localidad) 
					FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
					WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad) AS localidad, 
					c.nombre AS capilla, 
					(SELECT COUNT(tipo_servicio) 
					FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
					WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad AND tipo_servicio = t.tipo_servicio) AS tipo_servicio, 
					s.nombre AS servicio, 
					t.horas, 
					d.base, 
					d.Ncostos_tarifa_detalle, date_format(d.fecha, '%d/%m/%Y') AS fecha, t.Ncostos_tarifa,
					LPAD(SUBSTRING(t.horas, 1, POSITION(' ' IN t.horas)-1), 2, '0') as hr, 
					d.Ncostos_tarifa_detalle 
				FROM 
					sco_costos_tarifa t 
					JOIN sco_servicio_tipo c ON c.Nservicio_tipo = t.localidad 
					JOIN sco_servicio_tipo s ON s.Nservicio_tipo = t.tipo_servicio 
					JOIN sco_costos_tarifa_detalle d ON d.costos_tarifa = t.Ncostos_tarifa 
				WHERE 
					t.activo = 'S' AND d.cerrado = 'N' AND c.Nservicio_tipo = 'CAP5' AND s.Nservicio_tipo = 'SEPE' 
				ORDER BY c.Nservicio_tipo, s.Nservicio_tipo, hr";

		$resultado = mysql_query($sql) or die(mysql_error()); 
		$this->SetFont('Arial','B',8);
		$this->Ln(6);
		while($row = mysql_fetch_array($resultado))
		{
			$this->Cell(60);
			$this->Cell(30,4,"VELACION HASTA",0,0,'L');
			$this->Cell(20,4,trim($row["horas"]),0,0,'R');
			$this->Cell(30,4,"Bs. " . number_format(($row["base"] + ($row["base"]*($iva/100))), 2, ",", "."),0,0,'R');
			$this->Cell(60);
			$this->Ln(4);
		}
		$this->Ln(5);

		$this->SetFont('Arial','',8);
		$text = "INCLUYE: Ataъd estбndar Monumental, bъsqueda y traslado (UNICAMENTE CARACAS), preparaciуn del cuerpo, carroza fъnebre, automуvil de acompaсante, cafeterнa, habitaciуn de descanso, 1 arreglo floral bбsico, oficio catуlico en la capilla velatoria, asesorнa en trбmites legales. (no incluye obituarios). ";
		
		$this->Cell(20,5);
		$this->MultiCell(160,5,$text,'0','L');
		$this->Ln();

		$this->SetFont('Arial','B',8);
		$text = "*Nota: El servicio 24 horas Monumental adicionalmente incluye un Cofre Americano o Ataъd Metбlico Superior (segъn disponibilidad) y un obituario S23 en EL Nacional.";
		
		$this->Cell(20,5);
		$this->MultiCell(160,5,$text,'0','L');
		$this->Ln();

// MONUMENTAL CREMACION 
		$this->SetFont('Arial','B',8);
		$this->Cell(205,5,'PRECIOS SERVICIO FUNERARIO P/CREMACION',0,0,'C');
		$this->Ln();
		$this->Cell(205,5,'(NO INCLUYE EL PROCESO DE CREMACION)',0,0,'C');

		$this->Ln(6);
		$this->SetFont('Arial','BU',10);
		$this->Cell(205,5,'CAPILLA MONUMENTAL',0,0,'C');

		$sql = "SELECT 
					(SELECT COUNT(localidad) 
					FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
					WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad) AS localidad, 
					c.nombre AS capilla, 
					(SELECT COUNT(tipo_servicio) 
					FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
					WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad AND tipo_servicio = t.tipo_servicio) AS tipo_servicio, 
					s.nombre AS servicio, 
					t.horas, 
					d.base, 
					d.Ncostos_tarifa_detalle, date_format(d.fecha, '%d/%m/%Y') AS fecha, t.Ncostos_tarifa,
					LPAD(SUBSTRING(t.horas, 1, POSITION(' ' IN t.horas)-1), 2, '0') as hr, 
					d.Ncostos_tarifa_detalle 
				FROM 
					sco_costos_tarifa t 
					JOIN sco_servicio_tipo c ON c.Nservicio_tipo = t.localidad 
					JOIN sco_servicio_tipo s ON s.Nservicio_tipo = t.tipo_servicio 
					JOIN sco_costos_tarifa_detalle d ON d.costos_tarifa = t.Ncostos_tarifa 
				WHERE 
					t.activo = 'S' AND d.cerrado = 'N' AND c.Nservicio_tipo = 'CAP0' AND s.Nservicio_tipo = 'CREM' 
				ORDER BY c.Nservicio_tipo, s.Nservicio_tipo, hr";

		$resultado = mysql_query($sql) or die(mysql_error()); 
		$this->SetFont('Arial','B',8);
		$this->Ln(6);
		while($row = mysql_fetch_array($resultado))
		{
			$this->Cell(60);
			$this->Cell(30,4,"VELACION HASTA",0,0,'L');
			$this->Cell(20,4,trim($row["horas"]),0,0,'R');
			$this->Cell(30,4,(substr(trim($row["horas"]),0,2)=="24"?"* ":"") . "Bs. " . number_format(($row["base"] + ($row["base"]*($iva/100))), 2, ",", "."),0,0,'R');
			$this->Cell(60);
			$this->Ln(4);
		}

// DEL ESTE CREMACION Y CREMATORIAS
		$this->Ln(6);
		$this->SetFont('Arial','B',10);
		$this->Cell(20);
		$this->Cell(85,5,'CAPILLA DEL ESTE:',0,0,'L');
		$this->Cell(85,5,'CAPILLAS CREMATORIAS:',0,0,'L');

		$sql = "SELECT 
					(SELECT COUNT(localidad) 
					FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
					WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad) AS localidad, 
					c.nombre AS capilla, 
					(SELECT COUNT(tipo_servicio) 
					FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
					WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad AND tipo_servicio = t.tipo_servicio) AS tipo_servicio, 
					s.nombre AS servicio, 
					t.horas, 
					d.base, 
					d.Ncostos_tarifa_detalle, date_format(d.fecha, '%d/%m/%Y') AS fecha, t.Ncostos_tarifa,
					LPAD(SUBSTRING(t.horas, 1, POSITION(' ' IN t.horas)-1), 2, '0') as hr, 
					d.Ncostos_tarifa_detalle 
				FROM 
					sco_costos_tarifa t 
					JOIN sco_servicio_tipo c ON c.Nservicio_tipo = t.localidad 
					JOIN sco_servicio_tipo s ON s.Nservicio_tipo = t.tipo_servicio 
					JOIN sco_costos_tarifa_detalle d ON d.costos_tarifa = t.Ncostos_tarifa 
				WHERE 
					t.activo = 'S' AND d.cerrado = 'N' AND c.Nservicio_tipo = 'CAP5' AND s.Nservicio_tipo = 'CREM' 
				ORDER BY c.Nservicio_tipo, s.Nservicio_tipo, hr";

		$resultado = mysql_query($sql) or die(mysql_error()); 


		$sql = "SELECT 
					(SELECT COUNT(localidad) 
					FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
					WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad) AS localidad, 
					c.nombre AS capilla, 
					(SELECT COUNT(tipo_servicio) 
					FROM sco_costos_tarifa x JOIN sco_costos_tarifa_detalle y ON y.costos_tarifa = x.Ncostos_tarifa 
					WHERE activo = 'S' AND cerrado = 'N' AND localidad = t.localidad AND tipo_servicio = t.tipo_servicio) AS tipo_servicio, 
					s.nombre AS servicio, 
					t.horas, 
					d.base, 
					d.Ncostos_tarifa_detalle, date_format(d.fecha, '%d/%m/%Y') AS fecha, t.Ncostos_tarifa,
					LPAD(SUBSTRING(t.horas, 1, POSITION(' ' IN t.horas)-1), 2, '0') as hr, 
					d.Ncostos_tarifa_detalle 
				FROM 
					sco_costos_tarifa t 
					JOIN sco_servicio_tipo c ON c.Nservicio_tipo = t.localidad 
					JOIN sco_servicio_tipo s ON s.Nservicio_tipo = t.tipo_servicio 
					JOIN sco_costos_tarifa_detalle d ON d.costos_tarifa = t.Ncostos_tarifa 
				WHERE 
					t.activo = 'S' AND d.cerrado = 'N' AND c.Nservicio_tipo = 'CAP2' AND s.Nservicio_tipo = 'CREM' 
				ORDER BY c.Nservicio_tipo, s.Nservicio_tipo, hr";

		$resultado2 = mysql_query($sql) or die(mysql_error()); 
		$this->SetFont('Arial','B',8);
		$this->Ln(6);
		while($row = mysql_fetch_array($resultado))
		{
			if($row2 = mysql_fetch_array($resultado2)) {
				$v = "VELACION HASTA"; $h = trim($row2["horas"]); $b = "Bs. " . number_format(($row2["base"] + ($row2["base"]*($iva/100))), 2, ",", ".");
			}
			else {
				$v = ""; $h = ""; $b = "";
			}
			$this->Cell(20);
			$this->Cell(30,4,"VELACION HASTA",0,0,'L');
			$this->Cell(15,4,trim($row["horas"]),0,0,'R');
			$this->Cell(30,4,"Bs. " . number_format(($row["base"] + ($row["base"]*($iva/100))), 2, ",", "."),0,0,'R');

			$this->Cell(10);
			$this->Cell(30,4,$v,0,0,'L');
			$this->Cell(15,4,$h,0,0,'R');
			$this->Cell(30,4,$b,0,0,'R');

			$this->Ln();
		}
		$this->Ln(5);

		$this->SetFont('Arial','',8);
		$text = "INCLUYE: Bъsqueda y traslado (UNICAMENTE CARACAS), derecho a uso de ataъd, preparaciуn del cuerpo, cafeterнa, habitaciуn de descanso, carroza fъnebre,  asesorнa en trбmites legales, 1 arreglo floral bбsico, oficio religioso catуlico en la capilla velatoria (no incluye  obituarios)";
		
		$this->Cell(20,5);
		$this->MultiCell(160,5,$text,'0','L');
		$this->Ln();

		$this->SetFont('Arial','B',8);
		$text = "*Nota: El servicio 24 horas Monumental adicionalmente incluye un obituario S33 en EL Nacional.";
		
		$this->Cell(20,5);
		$this->MultiCell(160,5,$text,'0','L');
		$this->Ln();

		$sql = "SELECT valor2 as costo FROM sco_parametro WHERE codigo = '018' AND valor1 = 'P/INH';";
		$resultado = mysql_query($sql) or die(mysql_error()); 
		$row = mysql_fetch_array($resultado);
		$inh = "Bs. " . number_format(($row["costo"] + ($row["costo"]*($iva/100))), 2, ".", ",");

		$sql = "SELECT valor2 as costo FROM sco_parametro WHERE codigo = '018' AND valor1 = 'P/CREM';";
		$resultado = mysql_query($sql) or die(mysql_error()); 
		$row = mysql_fetch_array($resultado);
		$cre = "Bs. " . number_format(($row["costo"] + ($row["costo"]*($iva/100))), 2, ".", ",");

		$sql = "SELECT valor2 as costo FROM sco_parametro WHERE codigo = '018' AND valor1 = 'TRASLADO DIRECTO A PARCELA';";
		$resultado = mysql_query($sql) or die(mysql_error()); 
		$row = mysql_fetch_array($resultado);
		$tra = "Bs. " . number_format(($row["costo"] + ($row["costo"]*($iva/100))), 2, ".", ",");

		$this->SetFont('Arial','B',8);
		$text = "*TRASLADOS DIRECTOS CON HONORES: P/INH $inh, Incluye: bъsqueda y traslado, ataъd,  asesorнa en trбmites legales, preparaciуn del cuerpo, una hora en la Iglesia del cementerio del este con oficio religioso y tributo musical. P/CREM $cre (ataъd en calidad de derecho de uso), una hora en la Iglesia, con oficio religioso y tributo musical.  TRASLADO DIRECTO A PARCELA $tra";
		
		$this->Cell(20,5);
		$this->MultiCell(160,5,$text,'0','L');
		$this->Ln();

		$this->SetFont('Arial','B',8);
		$this->Cell(205,5,'ESTOS PRECIOS INCLUYEN IVA',0,0,'C');
		$this->Ln();
		$this->Cell(205,5,'ATENCION LAS 24 HORAS',0,0,'C');
		$this->Ln();
		$this->Cell(205,5,'MASTER: (0212)6283400',0,0,'C');
	}
	
	// Pie de pбgina
	function Footer()
	{
		// Posiciуn: a 1,5 cm del final
		$this->SetY(-15);
		// Arial italic 8
		$this->SetFont('Arial','I',8);
		// Nъmero de pбgina
		$this->ln();
		$this->Cell(0,5,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	
	function EndReport($id_invoice)
	{
	}
}

// Creaciуn del objeto de la clase heredada
$pdf = new PDF();
$pdf->SetMargins(2,10,10);
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','',8);



$pdf->Output();
?>