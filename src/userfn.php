<?php

namespace PHPMaker2024\hercules;

use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Container\ContainerInterface;
use Slim\Routing\RouteCollectorProxy;
use Slim\App;
use Closure;

// Filter for 'Last Month' (example)
function GetLastMonthFilter($FldExpression, $dbid = "")
{
    $today = getdate();
    $lastmonth = mktime(0, 0, 0, $today['mon'] - 1, 1, $today['year']);
    $val = date("Y|m", $lastmonth);
    $wrk = $FldExpression . " BETWEEN " .
        QuotedValue(DateValue("month", $val, 1, $dbid), DataType::DATE, $dbid) .
        " AND " .
        QuotedValue(DateValue("month", $val, 2, $dbid), DataType::DATE, $dbid);
    return $wrk;
}

// Filter for 'Starts With A' (example)
function GetStartsWithAFilter($FldExpression, $dbid = "")
{
    return $FldExpression . Like("'A%'", $dbid);
}

// Global user functions
// Database Connecting event
function Database_Connecting(&$info) {
	// Example:
	//var_dump($info);
	date_default_timezone_set('America/La_Paz');
	if (!IsLocal()) {
        /*
		$info["host"] = "localhost";
		$info["user"] = "root";
		$info["pass"] = "142536";
		$info["db"] = "hercules";
        */
		$info["host"] = "localhost";
		$info["user"] = "cemenlsk_hercules";
		$info["pass"] = "S![%IeeBY.nW";
		$info["db"] = "cemenlsk_hercules";
	}
}

// Database Connected event
function Database_Connected($conn)
{
    // Example:
    //if ($conn->info["id"] == "DB") {
    //    $conn->executeQuery("Your SQL");
    //}
}

// Language Load event
function Language_Load()
{
    // Example:
    //$this->setPhrase("MyID", "MyValue"); // Refer to language file for the actual phrase id
    //$this->setPhraseClass("MyID", "fa-solid fa-xxx ew-icon"); // Refer to https://fontawesome.com/icons?d=gallery&m=free [^] for icon name
}

function MenuItem_Adding($item)
{
    //var_dump($item);
    //$item->Allowed = false; // Set to false if menu item not allowed
}

function Menu_Rendering()
{
    // Change menu items here
}

function Menu_Rendered()
{
    // Clean up here
}

// Page Loading event
function Page_Loading()
{
    //Log("Page Loading");
}

// Page Rendering event
function Page_Rendering()
{
    //Log("Page Rendering");
}

// Page Unloaded event
function Page_Unloaded()
{
    //Log("Page Unloaded");
}

// AuditTrail Inserting event
function AuditTrail_Inserting(&$rsnew)
{
    //var_dump($rsnew);
    return true;
}

// Personal Data Downloading event
function PersonalData_Downloading($row)
{
    //Log("PersonalData Downloading");
}

// Personal Data Deleted event
function PersonalData_Deleted($row)
{
    //Log("PersonalData Deleted");
}

// One Time Password Sending event
function Otp_Sending($usr, $client)
{
    // Example:
    // var_dump($usr, $client); // View user and client (Email or SMS object)
    // if (SameText(Config("TWO_FACTOR_AUTHENTICATION_TYPE"), "email")) { // Possible values, email or SMS
    //     $client->Content = ...; // Change content
    //     $client->Recipient = ...; // Change recipient
    //     // return false; // Return false to cancel
    // }
    return true;
}

// Route Action event
function Route_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// API Action event
function Api_Action($app)
{
    // Example:
    // $app->get('/myaction', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
    // $app->get('/myaction2', function ($request, $response, $args) {
    //    return $response->withJson(["name" => "myaction2"]); // Note: Always return Psr\Http\Message\ResponseInterface object
    // });
}

// Container Build event
function Container_Build($builder)
{
    // Example:
    // $builder->addDefinitions([
    //    "myservice" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService();
    //    },
    //    "myservice2" => function (ContainerInterface $c) {
    //        // your code to provide the service, e.g.
    //        return new MyService2();
    //    }
    // ]);
}

function alertas()
{
    // A. Activar alertas dentro de su periodo de validez
    Execute("UPDATE sco_alertas SET activo = 1 WHERE CURDATE() BETWEEN fecha AND fecha_end;");

    // B. Desactivar alertas cuya fecha de fin ya ha pasado
    Execute("UPDATE sco_alertas SET activo = 0 WHERE fecha_end < CURDATE();");

    // --- 2. Obtención de Textos de Alerta (Solución N+1 Query Problem) ---

    // Se obtiene directamente un array de todas las descripciones activas en UNA SOLA CONSULTA.
    $sql_textos = "SELECT descripcion_larga 
                   FROM sco_alertas 
                   WHERE activo = 1 
                   ORDER BY orden;";

    // Se utiliza ExecuteRows para obtener todos los resultados en un array
    $rows_alertas = ExecuteRows($sql_textos);
    $textos_formateados = [];
    $separador = " --- --- --- --- --- --- --- --- --- --- "; // Separador visual
    if ($rows_alertas) {
        // Recorrer el array y extraer solo las descripciones
        foreach ($rows_alertas as $row) {
            $textos_formateados[] = $row["descripcion_larga"];
        }
    }

    // Unir todos los textos con el separador
    $texto_final = implode($separador, $textos_formateados);

    // --- 3. Construcción del HTML (Modernización: usar CSS/JS en lugar de <marquee>) ---

    // Si no hay alertas activas, salimos.
    if (empty($texto_final)) {
        return;
    }

    // Se usa un div con clases de estilo para simular una marquesina con CSS o JS.
    // NOTA: Si el framework de destino (e.g., Bootstrap) permite clases para esto, úsalas.
    // Usamos estilos inline básicos para simular el look and feel original:
    $alert = sprintf(
        '<div class="alert-container" style="background-color: #123e1c; color: #ffffff; padding: 3px; font-weight: bold; overflow: hidden; white-space: nowrap;">
            %s
        </div>',
        // El contenido completo (necesitará JS/CSS externo para el efecto de movimiento)
        $texto_final 
    );

    // --- 4. Verificación de Permisos (Mejora de sintaxis SQL) ---

    // Se remueven las comillas simples innecesarias del entero
    $sql_permiso = "SELECT ver_alertas FROM userlevels WHERE userlevelid = " . intval(CurrentUserLevel()) . " AND userlevelid <> 0;";
    $ver_alertas = ExecuteScalar($sql_permiso);
    if ($ver_alertas == "S") {
        echo $alert;
    }
}

function actualizar_monto_incidencia($xincidencia) {
    // 1. Sanitizar el ID de la incidencia como un entero.
    $incidencia_id_seguro = intval($xincidencia);

    // 2. Calcular la suma de costos (SQL sin comillas en el ID)
    // Usamos ExecuteScalar para obtener el valor directamente.
    $value = ExecuteScalar("SELECT SUM(costo)
                           FROM sco_flota_incidencia_detalle
                           WHERE flota_incidencia = " . $incidencia_id_seguro);

    // 3. Sanitizar y Normalizar el Monto (Si la suma es NULL, debe ser 0)
    // Usamos floatval para asegurar que sea un valor numérico válido (costo).
    $monto_seguro = floatval($value);

    // 4. Actualizar la tabla principal de incidencia.
    // NOTA: Los valores numéricos ($monto_seguro, $incidencia_id_seguro) NO llevan comillas en la sentencia SQL.
    Execute("UPDATE sco_flota_incidencia 
             SET monto = " . $monto_seguro . " 
             WHERE Nflota_incidencia = " . $incidencia_id_seguro);
}

function legenda()
{
    $sql = "select count(*) as total from sco_estatus where activo = 'S';";
    $total = ExecuteScalar($sql);

    // Validamos que $total no sea 0, nulo o falso
    if ($total > 0) {
        $xAncho = round(100 / $total, 0) - 1;
    } else {
        // Definimos un valor por defecto si no hay registros
        $xAncho = 0; 
    }
	$table = '<table align="left" cellpadding="3" cellspacing="3" width="80%">
				<tr height="30">';
					for($i=0; $i<$total; $i++)
					{
						$sql = "select
									Nstatus, nombre, color
								from
									sco_estatus
								where
									activo = 'S' order by Nstatus limit $i, 1;";
						$row = ExecuteRow($sql);
						$table .= '<td bgcolor="'.$row["color"].'" width="'.$xAncho.'%" align="center">
							<b>'.$row["nombre"].'</b></td>';
					}
				$table .= '</tr>';
			$table .= '</table><br><br>';
	return $table;
}

/**
 * Calcula el tiempo transcurrido entre dos fechas y lo devuelve en formato legible (años, meses, días).
 *
 * @param string $fechaInicio Fecha inicial (en formato que DateTime entienda).
 * @param string $fechaFin Fecha final (en formato que DateTime entienda).
 * @return string Tiempo transcurrido formateado.
 */
function tiempoTranscurridoFechas(string $fechaInicio, string $fechaFin): string {
    if (is_null($fechaInicio) || $fechaInicio == "") {
        return "N/A"; // O el mensaje que prefieras si no hay fecha
    }

    // 1. Crear objetos DateTime y calcular la diferencia usando el método estándar diff()
    try {
        $fecha1 = new \DateTime($fechaInicio);
        $fecha2 = new \DateTime($fechaFin);
    } catch (\Exception $e) {
        // Manejo básico de error si el formato de fecha es inválido
        return "Error en el formato de fecha: " . $e->getMessage();
    }
    $intervalo = $fecha1->diff($fecha2);
    $partes = [];

    // Función auxiliar para generar la cadena de tiempo (singular/plural)
    $obtenerParte = function($valor, $singular, $plural) use (&$partes) {
        if ($valor > 0) {
            $unidad = ($valor === 1) ? $singular : $plural;
            $partes[] = $valor . " " . $unidad;
        }
    };

    // 2. Aplicar la lógica a Años, Meses y Días
    $obtenerParte($intervalo->y, "año", "años");
    $obtenerParte($intervalo->m, "mes", "meses");
    $obtenerParte($intervalo->d, "día", "días");

    // 3. Formatear la salida
    if (empty($partes)) {
        return "0 días";
    }

    // Unir las partes con coma y un 'y' antes del último elemento si hay más de uno
    $ultimo = array_pop($partes);
    if (!empty($partes)) {
        return implode(", ", $partes) . " y " . $ultimo;
    }
    return $ultimo;
}

// Valiacaión CI 
function valida_ci($xCI) {
	$xBad = true;
	$xCI = str_replace(" ","",$xCI);
	$xCI = str_replace(".","",$xCI);
	$xCI = str_replace(",","",$xCI);
	if(substr($xCI,1,1)!="-")
		$xCI = substr($xCI,0,1) . "-" . trim(substr($xCI,1,strlen($xCI)));
	$xCI = strtoupper($xCI);
	if($xCI==""){
		$result = "C.I. Difunto no puede estar vacio";
		$xBad = false;
	}else if(strlen($xCI) < 7) {
		$result = "C.I. debe ser mayor a 6 caracteres";
		$xBad = false;
	}else if(strlen($xCI) > 12) {
		$result = "C.I. debe ser menor a 12 caracteres";
		$xBad = false;
	}else if(substr($xCI,0,2) != "V-" and substr($xCI,0,2) != "E-" and substr($xCI,0,2) != "M-" and substr($xCI,0,2) != "J-" and substr($xCI,0,2) != "G-") {
		$result = "C.I. debe comenzar con (V-) Venezolano o con (E-) Extranjero o con (M-) Menor de edad sin poseer CI.";
		$xBad = false;
	}
	if($xBad == true) {
		$result = "OK";
	}
	return $result;
}

function subHeaderExp($id) { 
    die("!!! REVISAR !!!");
    /*
	return '<a href="dashboard/asistencia.php?Nexpediente='.$id.'">Servicio</a>&nbsp;/&nbsp;
	<a href="sco_notalist.php?showmaster=sco_expediente&fk_Nexpediente='.$id.'">Nota</a>&nbsp;/&nbsp;
	<a href="sco_seguimientolist.php?showmaster=sco_expediente&fk_Nexpediente='.$id.'">Seguimiento</a>&nbsp;/&nbsp;
	<a href="sco_expediente_estatuslist.php?showmaster=sco_expediente&fk_Nexpediente='.$id.'">Monitor</a>&nbsp;/&nbsp;
	<a href="sco_adjuntolist.php?showmaster=sco_expediente&fk_Nexpediente='.$id.'">Adjuntos</a><br>';
    */

	/*return '<a href="dashboard/asistencia.php?Nexpediente='.$id.'">Servcio</a>&nbsp;/&nbsp;
	<a href="sco_notaview.php?showmaster=sco_expediente&fk_Nexpediente='.$id.'">Nota</a>&nbsp;/&nbsp;
	<a href="sco_seguimientoview.php?showmaster=sco_expediente&fk_Nexpediente='.$id.'">Seguimiento</a>&nbsp;/&nbsp;
	<a href="sco_expediente_estatusview.php?showmaster=sco_expediente&fk_Nexpediente='.$id.'">Monitor</a>&nbsp;/&nbsp;
	<a href="sco_adjuntoview.php?showmaster=sco_expediente&fk_Nexpediente='.$id.'">Ajuntos</a><br>';*/
}
function get_real_ip()
{
	if (isset($_SERVER["HTTP_CLIENT_IP"]))
	{
		return $_SERVER["HTTP_CLIENT_IP"];
	}
	elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
	{
		return $_SERVER["HTTP_X_FORWARDED_FOR"];
	}
	elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
	{
		return $_SERVER["HTTP_X_FORWARDED"];
	}
	elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
	{
		return $_SERVER["HTTP_FORWARDED_FOR"];
	}
	elseif (isset($_SERVER["HTTP_FORWARDED"]))
	{
		return $_SERVER["HTTP_FORWARDED"];
	}
	else
	{
		return $_SERVER["REMOTE_ADDR"];
	}
}
function user_show()
{
	$sql = "SELECT nombre FROM sco_user WHERE username = '".CurrentUserName()."'";
	$usuario = ExecuteScalar($sql);
	$header = "<br><i><b>Usuario Registra: (" . CurrentUserName() . ") $usuario -- Fecha Hora: " . date("d/m/Y g:i A") . "</b></i>";
	return $header;
}
function calc_edad($fecha_nacimiento)
{
	//fecha actual
	$dia = date("d");
	$mes = date("m");
	$ano = date("Y");

	//fecha de nacimiento
	$fn = explode("-", $fecha_nacimiento);
	$dianaz = (int) $fn[2];
	$mesnaz = (int) $fn[1];
	$anonaz = (int) $fn[0];

	//si el mes es el mismo pero el día inferior aun no ha cumplido años, le quitaremos un año al actual
	if (($mesnaz == $mes) && ($dianaz > $dia)) {
		$ano=($ano-1);
	}

	//si el mes es superior al actual tampoco habrá cumplido años, por eso le quitamos un año al actual
	if ($mesnaz > $mes) {
		$ano=($ano-1);
	}

	//ya no habría mas condiciones, ahora simplemente restamos los años y mostramos el resultado como su edad
	$edad=($ano-$anonaz);
	return $edad;
}
function cambiar_estatus($Nexpediente, $estatus)
{
	Execute("SET time_zone = '-04:00';");
	$sql = "DELETE FROM sco_expediente_estatus
			WHERE expediente = '$Nexpediente' and estatus = '$estatus';";
	Execute($sql);
	$sql = "INSERT INTO sco_expediente_estatus
				(expediente, estatus, fecha_hora, username)
			VALUES ('$Nexpediente', '$estatus', NOW(), '".CurrentUserName()."');";
	Execute($sql);

	// Si se anula el expedeinte, se verifican si se asignó ataud y/o cofre
	// para realizar el reverso de los mismo y eliminar esos registros
	// paso 3 del expediente
	if($estatus==7) {
		$sql = "SELECT count(servicio) as cantidad FROM sco_orden WHERE paso = 3 AND expediente = '$Nexpediente'";
		$cantidad = ExecuteScalar($sql);
		for($i=0; $i<$cantidad; $i++) {
			$sql = "SELECT servicio FROM sco_orden WHERE paso = 3 AND expediente = '$Nexpediente' LIMIT $i,1";
			$serv = ExecuteScalar($sql);
			$sql = "INSERT INTO sco_entrada_salida
						(Nentrada_salida, tipo_doc, proveedor, documento, fecha, nota, username)
					VALUES (NULL, 'EXIN', -1, '$Nexpediente', NOW(), 'ENTRADA AUTOMATICA POR ANULACION DE Exp.: $Nexpediente', '".CurrentUserName()."')";
			Execute($sql);
			$idEntr = ExecuteScalar("SELECT LAST_INSERT_ID();");
			$sql = "INSERT INTO sco_entrada_salida_detalle
						(Nentrada_salida_detalle, entrada_salida, tipo_doc, proveedor, articulo, cantidad, costo, total)
					VALUES (NULL, $idEntr, 'EXIN', -1, '$serv', 1, 0, 0)";
			Execute($sql);
		}
		$sql = "DELETE FROM sco_orden WHERE expediente = '$Nexpediente'";
		Execute($sql);
	}

	// FIN
}
function addAuditTrail($action, $table, $field, $keyvalue, $oldvalue = null, $newvalue = null) {
    // Registrar variables globales de usuario y script
    global $UserProfile;
    $user = CurrentUserName() ?? "guest";
    $script = CurrentPageName();
    $sql = "INSERT INTO audittrail
        (`datetime`, `script`, `user`, `action`, `table`, `field`, `keyvalue`, `oldvalue`, `newvalue`)
        VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)";

    // Ejecutar
    Execute($sql, [
        $script,
        $user,
        $action,
        $table,
        $field,
        $keyvalue,
        $oldvalue,
        $newvalue
    ]);
}

/*
Ejemplo → Cuando insertas un registro y quieres auditarlo:
addAuditTrail(
    "INSERT",
    "clientes",
    "", // puedes dejar vacío si aplica a toda la fila
    $newRecord["id"],
    "",
    json_encode($newRecord)
);
*/

/*
Ejemplo → Cuando actualizas un campo:
addAuditTrail(
    "UPDATE",
    "sco_orden",
    "estatus",
    $rsold["Norden"],
    $rsold["estatus"],
    $rsnew["estatus"]
);
*/

/*
Ejemplo → Cuando eliminas:
addAuditTrail(
    "DELETE",
    "sco_orden",
    "",
    json_encode($rsold),
    json_encode($rsold),
    ""
);
*/

/**
 * Función unificada para envío de correos en Hércules
 */

// Este siguiente línea es por si se quiere unificar todo dentro de phpmaker pero
// mejor dejo ambas declaraciones per evitar conflictos y a la hora de 
// cambiar credenciales debo hacerlo en ambos lados 

// require_once "dashboard/funciones_mail_hercules.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function EnviarCorreo($opciones) {
    $mail = new PHPMailer(true);
    try {
        // --- CONFIGURACIÓN SMTP (La que probamos y funcionó) ---
        $mail->isSMTP();
        $mail->Host       = 'cementeriodeleste.com.ve'; 
        $mail->SMTPAuth   = true;
        $mail->Username   = 'info@cementeriodeleste.com.ve';
        $mail->Password   = 'Windeco2022'; // <--- Pon tu clave real aquí
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        // --- BYPASS DE SEGURIDAD PARA LARAGON ---
        $mail->SMTPOptions = [
            'ssl' => [
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            ]
        ];

        // --- DESTINATARIOS Y CONTENIDO ---
        $mail->setFrom('info@cementeriodeleste.com.ve', 'Sistema Hercules');
        $mail->addAddress($opciones['to']);
        if (!empty($opciones['cc'])) $mail->addCC($opciones['cc']);
        if (!empty($opciones['bcc'])) $mail->addBCC($opciones['bcc']);

        // Adjuntos
        if (!empty($opciones['attachments']) && is_array($opciones['attachments'])) {
            foreach ($opciones['attachments'] as $file) {
                if (file_exists($file)) $mail->addAttachment($file);
            }
        }
        $mail->isHTML(true);
        $mail->Subject = $opciones['subject'];
        $mail->Body    = $opciones['body'];
        return $mail->send();
    } catch (Exception $e) {
        // Si falla, lo guarda en el log de PHPMaker para que sepas por qué
        Log("Error enviando correo: " . $mail->ErrorInfo);
        return false;
    }
}

/*
Ejemplo de envío de correos masivos
$usuarios = ExecuteRows("SELECT email FROM usuarios WHERE activo = 1");
foreach ($usuarios as $u) {
    EnviarCorreo([
        'to' => $u['email'],
        'subject' => "Boletín Informativo",
        'body' => "Contenido del boletín..."
    ]);
}
*/

// Add listeners
AddListener(DatabaseConnectingEvent::NAME, fn(DatabaseConnectingEvent $event) => Database_Connecting($event));
AddListener(DatabaseConnectedEvent::NAME, fn(DatabaseConnectedEvent $event) => Database_Connected($event->getConnection()));
AddListener(LanguageLoadEvent::NAME, fn(LanguageLoadEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Language_Load")->bindTo($event->getLanguage())());
AddListener(MenuItemAddingEvent::NAME, fn(MenuItemAddingEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "MenuItem_Adding")->bindTo($event->getMenu())($event->getMenuItem()));
AddListener(MenuRenderingEvent::NAME, fn(MenuRenderingEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Menu_Rendering")->bindTo($event->getMenu())($event->getMenu()));
AddListener(MenuRenderedEvent::NAME, fn(MenuRenderedEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Menu_Rendered")->bindTo($event->getMenu())($event->getMenu()));
AddListener(PageLoadingEvent::NAME, fn(PageLoadingEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Page_Loading")->bindTo($event->getPage())());
AddListener(PageRenderingEvent::NAME, fn(PageRenderingEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Page_Rendering")->bindTo($event->getPage())());
AddListener(PageUnloadedEvent::NAME, fn(PageUnloadedEvent $event) => Closure::fromCallable(PROJECT_NAMESPACE . "Page_Unloaded")->bindTo($event->getPage())());
AddListener(RouteActionEvent::NAME, fn(RouteActionEvent $event) => Route_Action($event->getApp()));
AddListener(ApiActionEvent::NAME, fn(ApiActionEvent $event) => Api_Action($event->getApp()));
AddListener(ContainerBuildEvent::NAME, fn(ContainerBuildEvent $event) => Container_Build($event->getBuilder()));

// PhpSpreadsheet
AddListener(ConfigurationEvent::NAME, function (ConfigurationEvent $event) {
    $exts = array_merge($event->get("PHP_EXTENSIONS"), [
        "zip" => "zip",
        "zlib" => "zlib",
    ]);
    $event->import([
        "USE_PHPEXCEL" => true,
        "EXPORT_EXCEL_FORMAT" => "Excel5",
        "PHP_EXTENSIONS" => $exts,
    ]);
});
