<?php

/**
 * @file 006-verificarFirmaXML.php
 * @author Esteban De La Fuente Rubio, DeLaF (esteban[at]sasco.cl)
 * @version 2015-09-16
 */

// respuesta en texto plano
header('Content-type: text/plain');

// incluir archivos php de la biblioteca y configuraciones
include 'inc.php';

// verificar firma
$xml_data = file_get_contents('xml/archivoFirmado.xml');
$FirmaElectronica = new \sasco\LibreDTE\FirmaElectronica($config['firma']);
var_dump($FirmaElectronica->verifyXML($xml_data, 'SetDTE'));

// si hubo errores mostrar
foreach (\sasco\LibreDTE\Log::readAll() as $error)
    echo $error,"\n";
