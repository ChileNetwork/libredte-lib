#!/usr/bin/env php
<?php

// Detectar si se está ejecutando desde la línea de comandos
$esConsola = (php_sapi_name() === 'cli');

// Si no es consola, establecer el header
if (!$esConsola) {
    //echo "asdfasdf";
    header('Content-type: text/plain');
}

// Función para imprimir
function imprimir($mensaje) {
    global $esConsola;
    if ($esConsola) {
        fwrite(STDOUT, $mensaje . PHP_EOL);
    } else {
        echo $mensaje . "\n";
    }
}

// Tu lógica principal aquí
function ejecutarLogicaPrincipal() {
    imprimir("Inicio del script");
    
    // Ejemplo de uso de una característica de PHP 8.3: json_validate()
    $jsonValido = '{"nombre": "Juan", "edad": 30}';
    $jsonInvalido = '{"nombre": "Juan", "edad": }';
    
    imprimir("Validación de JSON válido: " . (json_validate($jsonValido) ? "OK" : "Fallo"));
    imprimir("Validación de JSON inválido: " . (json_validate($jsonInvalido) ? "OK" : "Fallo"));
    
    // Uso de una característica introducida en PHP 8.1: array_is_list()
    $lista = [1, 2, 3, 4, 5];
    $noLista = [1 => 'a', 0 => 'b', 2 => 'c'];
    
    imprimir("¿Es una lista [1, 2, 3, 4, 5]? " . (array_is_list($lista) ? "Sí" : "No"));
    imprimir("¿Es una lista [1 => 'a', 0 => 'b', 2 => 'c']? " . (array_is_list($noLista) ? "Sí" : "No"));
    
    imprimir("Fin del script");
}

// Manejo de errores
set_exception_handler(function($e) {
    global $esConsola;
    $mensaje = "Error: " . $e->getMessage() . "\n" . $e->getTraceAsString();
    if ($esConsola) {
        fwrite(STDERR, $mensaje . PHP_EOL);
    } else {
        echo $mensaje;
    }
    exit(1);
});

// Ejecutar la lógica principal
ejecutarLogicaPrincipal();