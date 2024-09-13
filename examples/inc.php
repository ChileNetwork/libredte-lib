<?php

/**
 * @file inc.php
 * Archivo que incluye todos los archivo .php de la biblioteca para evitar incluirlos manualmente. 
 * Esto es sólo válido en los ejemplos, en código real usar la autocarga de composer.
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2020-03-13
 */

// activar todos los errores
ini_set('display_errors', true);
error_reporting(E_ALL); 

// zona horaria
date_default_timezone_set('America/Santiago');

// incluir autocarga de composer
if (is_readable(dirname(dirname(__FILE__)).'/vendor/autoload.php')) {
    include dirname(dirname(__FILE__)).'/vendor/autoload.php';
} else {
    die('Para probar los ejemplos debes ejecutar primero "composer install" en el directorio '.dirname(dirname(__FILE__))."\n");
}

//  todos los ejemplos se ejecutan con backtrace activado, esto para ayudar al debug de los mismos
\sasco\LibreDTE\Log::setBacktrace(true);

// incluir configuración específica de los ejemplos
if (is_readable(dirname(__FILE__).'/config.php')) {
    include dirname(__FILE__).'/config.php'; 
} else {
    die('Debes crear config.php a partir de config-dist.php'."\n");
}
