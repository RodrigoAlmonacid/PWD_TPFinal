<?php
/**
 * getSubmittedData
 * 
 * Función auxiliar (helper) para centralizar la recolección y sanitización
 * de datos enviados mediante formularios HTML usando los métodos POST, GET
 * y archivos (FILES).
 * 
 * Objetivos principales:
 * - Unificar en un solo array toda la información recibida.
 * - Aplicar sanitización básica para prevenir inyección de código HTML/JS.
 * - Mantener compatibilidad con inputs simples y múltiples (arrays).
 * - Dar prioridad a POST sobre GET en caso de conflicto de nombres.
 * 
 * IMPORTANTE:
 * - Esta función devuelve datos ya "seguros para mostrar en HTML".
 * - Para usos específicos (ej: números, emails, guardar en BD) 
 *   se recomienda validarlos de nuevo con filter_var() u otras funciones.
 * 
 * @return array Datos procesados desde POST, GET y FILES.
 */
function getSubmittedData() {
    // Array donde se guardarán todos los datos saneados
    $datos = [];

    /**
     * PROCESAR POST
     * Si hay datos en $_POST (generalmente enviados desde formularios),
     * se recorren y sanitizan.
     * Tiene prioridad sobre GET, por eso se procesa primero.
     */
    if (!empty($_POST)) {
        foreach ($_POST as $key => $value) {
            // Si el valor es un array (ej: checkbox multiple), se procesa cada elemento
            if (is_array($value)) {
                $datos[$key] = array_map(function($item) {
                    return htmlspecialchars(trim($item), ENT_QUOTES, 'UTF-8');
                }, $value);
            } else {
                // Si es un valor simple, lo sanitizamos directamente
                $datos[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }
        }
    }

    /**
     * PROCESAR GET
     * Si hay datos en $_GET (parámetros en la URL),
     * se recorren y sanitizan.
     * ¡OJO! Solo se agregan los campos que no existan ya en POST.
     */
    if (!empty($_GET)) {
        foreach ($_GET as $key => $value) {
            //chequeo que no exista el $key en datos del post para no pisarlo
            if (!array_key_exists($key, $datos)) {
                if (is_array($value)) {
                    $datos[$key] = array_map(function($item) {
                        return htmlspecialchars(trim($item), ENT_QUOTES, 'UTF-8');
                    }, $value);
                } else {
                    $datos[$key] = htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
                }
            }
        }
    }

    /**
     * PROCESAR FILES
     * Los archivos subidos NO se sanitizan, ya que $_FILES contiene
     * un array asociativo con información estructurada (nombre, tipo, tmp_name, error, size).
     * Aquí simplemente se copian tal cual.
     */
    if (!empty($_FILES)) {
        foreach ($_FILES as $key => $file) {
            $datos[$key] = $file;
        }
    }

    // Retorna todos los datos unificados en un solo array
    return $datos;
}