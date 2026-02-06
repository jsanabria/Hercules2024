<?php
/**
 * Traduce mes/día EN->ES y helpers.
 * Recomendado guardar el archivo en UTF-8.
 */

function traducir_mes(string $xmes): string
{
    // Espera algo tipo: "January 01 2026" (o similar). Tú usas $arr[2] como año.
    $arr = preg_split('/\s+/', trim($xmes));
    if (count($arr) < 3) {
        return ''; // o devuelve $xmes si prefieres
    }

    $meses = [
        'January'   => 'Enero',
        'February'  => 'Febrero',
        'March'     => 'Marzo',
        'April'     => 'Abril',
        'May'       => 'Mayo',
        'June'      => 'Junio',
        'July'      => 'Julio',
        'August'    => 'Agosto',
        'September' => 'Septiembre',
        'October'   => 'Octubre',
        'November'  => 'Noviembre',
        'December'  => 'Diciembre',
    ];

    $mesEn = $arr[0];
    $anio  = $arr[2];

    $mesEs = $meses[$mesEn] ?? $mesEn; // fallback si viene algo raro
    return $mesEs . ' - ' . $anio;
}

function traducir_dia(string $xdia): string
{
    // Espera algo tipo: "Wednesday ..." pero tú solo usas el primer token.
    $arr = preg_split('/\s+/', trim($xdia));
    if (count($arr) < 1 || $arr[0] === '') {
        return '';
    }

    $dias = [
        'Sunday'    => 'Domingo',
        'Monday'    => 'Lunes',
        'Tuesday'   => 'Martes',
        'Wednesday' => 'Miércoles',
        'Thursday'  => 'Jueves',
        'Friday'    => 'Viernes',
        'Saturday'  => 'Sábado',
    ];

    $diaEn = $arr[0];
    return $dias[$diaEn] ?? $diaEn; // fallback
}

/**
 * Nombre del mes en español a partir de número (1-12), sin depender de setlocale.
 */
function nombremes(int $mes): string
{
    static $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
    ];

    return $meses[$mes] ?? '';
}
?>
