<?php

function imprimir($mensaje) {
    echo $mensaje . PHP_EOL;
}

function verificarClave($clave) {
    $detalles = openssl_pkey_get_details($clave);
    if ($detalles === false) {
        imprimir("Error al obtener detalles de la clave: " . openssl_error_string());
        return false;
    }
    imprimir("Tipo de clave: " . $detalles['type']);
    imprimir("Bits: " . $detalles['bits']);
    return true;
}

$datos = "Hola, este es un mensaje que será firmado digitalmente.";

$config = [
    "digest_alg" => "sha256",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
];

$clavePrimaria = openssl_pkey_new($config);

if ($clavePrimaria === false) {
    imprimir("Error al generar la clave: " . openssl_error_string());
    exit(1);
}

if (!verificarClave($clavePrimaria)) {
    exit(1);
}

$exito = openssl_pkey_export($clavePrimaria, $clavePrivada);
if (!$exito) {
    imprimir("Error al exportar la clave privada: " . openssl_error_string());
    exit(1);
}

// Verificar que la clave privada es válida
$clavePrivadaRecurso = openssl_pkey_get_private($clavePrivada);
if ($clavePrivadaRecurso === false) {
    imprimir("Error: La clave privada no es válida. " . openssl_error_string());
    exit(1);
}

if (!verificarClave($clavePrivadaRecurso)) {
    exit(1);
}

$firma = '';
$exito = openssl_sign($datos, $firma, $clavePrivadaRecurso, OPENSSL_ALGO_SHA256);

if ($exito) {
    imprimir("Firma creada exitosamente.");
    imprimir("Firma (en base64): " . base64_encode($firma));

    $clavePublica = openssl_pkey_get_details($clavePrivadaRecurso)['key'];
    $resultado = openssl_verify($datos, $firma, $clavePublica, OPENSSL_ALGO_SHA256);

    if ($resultado === 1) {
        imprimir("La firma es válida.");
    } elseif ($resultado === 0) {
        imprimir("La firma es inválida.");
    } else {
        imprimir("Error al verificar la firma: " . openssl_error_string());
    }
} else {
    imprimir("Error al crear la firma: " . openssl_error_string());
}