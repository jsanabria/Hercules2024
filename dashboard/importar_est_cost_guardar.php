<?php
/**
 * Script de Procesamiento de Importación de Estructuras de Costo
 * Actualizado a MySQLi con Consultas Preparadas
 */

require_once 'includes/conexBD.php'; // Usa la variable $link definida en tu conexBD.php
date_default_timezone_set('America/Caracas'); 

$target_dir = "../carpetacarga/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true);
}

// 1. Configuración y Limpieza
$uploadOk = "NO"; // Usamos "NO" para indicar que NO hay errores (siguiendo tu lógica original)
$file_input = "myfile";

if (!isset($_FILES[$file_input]) || $_FILES[$file_input]["error"] !== UPLOAD_ERR_OK) {
    $uploadOk = "Error al subir el archivo al servidor.";
} else {
    $fileName = $_FILES[$file_input]["name"];
    $fileTmpName = $_FILES[$file_input]["tmp_name"];
    $fileSize = $_FILES[$file_input]["size"];
    $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    
    $target_filename = date("YmdHis") . "_" . basename($fileName);
    $target_file = $target_dir . $target_filename;

    // 2. Validaciones de Seguridad
    // Verificar que sea un archivo de texto
    if ($fileType !== "txt") {
        $uploadOk = "Tipo de archivo no válido. Solo se permiten archivos .txt";
    }
    // Verificar tamaño (Máximo 50MB)
    elseif ($fileSize > 50000000) { 
        $uploadOk = "Archivo superior a 50MB";
    }
    // Verificar si el archivo es realmente un texto y no una imagen camuflada
    elseif (@getimagesize($fileTmpName) !== false) {
        $uploadOk = "El archivo debe ser plano (formato texto), no una imagen.";
    }
}

// 3. Procesamiento del Archivo
if ($uploadOk === "NO") {
    if (move_uploaded_file($fileTmpName, $target_file)) {
        
        $handle = fopen($target_file, "r");
        if ($handle) {
            
            // Preparamos las consultas una sola vez para mayor eficiencia
            $sqlCheck = "SELECT Ncostos_articulo FROM sco_costos_articulos WHERE Ncostos_articulo = ?";
            $stmtCheck = $link->prepare($sqlCheck);

            $sqlUpdate = "UPDATE sco_costos_articulos SET precio = ?, variacion = ? WHERE Ncostos_articulo = ?";
            $stmtUpdate = $link->prepare($sqlUpdate);

            $sqlInsert = "INSERT INTO sco_costos_articulos 
                          (Ncostos_articulo, tipo, descripcion, precio, variacion, tipo_hercules, articulo_hercules) 
                          VALUES (?, ?, ?, ?, ?, NULL, NULL)";
            $stmtInsert = $link->prepare($sqlInsert);

            // Iniciar Transacción para asegurar integridad
            $link->begin_transaction();

            try {
                while (($linea = fgets($handle)) !== false) {
                    $linea = trim($linea);
                    if (empty($linea)) continue;

                    $ln = explode(";", $linea);
                    if (count($ln) < 5) {
                        throw new Exception("Estructura incorrecta en línea: " . substr($linea, 0, 30) . "...");
                    }

                    // Mapeo de datos del archivo TXT
                    $codigo      = trim($ln[0]);
                    $tipo        = trim($ln[1]);
                    $descripcion = trim($ln[2]);
                    $monto       = floatval(str_replace(',', '.', $ln[3])); // Convertir a decimal estándar
                    $porcentaje  = floatval(str_replace(',', '.', $ln[4]));

                    // A. Verificar existencia
                    $stmtCheck->bind_param("s", $codigo);
                    $stmtCheck->execute();
                    $result = $stmtCheck->get_result();

                    if ($result->num_rows > 0) {
                        // B. Existe -> Actualizar
                        $stmtUpdate->bind_param("dds", $monto, $porcentaje, $codigo);
                        $stmtUpdate->execute();
                    } else {
                        // C. No existe -> Insertar
                        $stmtInsert->bind_param("ssssd", $codigo, $tipo, $descripcion, $monto, $porcentaje);
                        $stmtInsert->execute();
                    }
                }
                
                $link->commit(); // Guardar cambios

            } catch (Exception $e) {
                $link->rollback(); // Revertir si algo falla
                $uploadOk = $e->getMessage();
            }

            fclose($handle);
            $stmtCheck->close();
            $stmtUpdate->close();
            $stmtInsert->close();
        } else {
            $uploadOk = "No se pudo abrir el archivo para lectura.";
        }

        // 4. Limpieza: Eliminar archivo temporal
        if (file_exists($target_file)) {
            unlink($target_file);
        }
    } else {
        $uploadOk = "Error al mover el archivo al directorio de carga.";
    }
}

// 5. Redirección con resultado
$link->close();
header("Location: importar_est_cost.php?error=" . urlencode($uploadOk));
exit();
?>