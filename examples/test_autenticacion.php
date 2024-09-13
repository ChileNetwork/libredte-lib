<?php

/**
 * @file 002-getToken.php
 * Ejemplo de obtención de token para autenticación automática en el SII
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2015-09-14
 */

if(!(php_sapi_name() === 'cli')){
    // respuesta en texto plano
    header('Content-type: text/plain');
}

// incluir archivos php de la biblioteca y configuraciones
include 'inc.php';  

// solicitar token
$token = \sasco\LibreDTE\Sii\Autenticacion::getToken($config['firma']);
//print_r($config['firma']);
//$token = null;
echo "Token\n";
var_dump($token);
echo "FIN-Token\n";
// si hubo errores se muestran
echo "\nERRORES\n";
foreach (\sasco\LibreDTE\Log::readAll() as $error) {
    echo $error,"\n";
}
echo "\nFIN-ERRORES\n";
