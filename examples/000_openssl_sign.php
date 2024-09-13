<?php

// Función para imprimir mensajes
echo "hola\n";
function imprimir($mensaje) {
    echo $mensaje . PHP_EOL;
}

// Datos que queremos firmar
$datos = "Hola, este es un mensaje que será firmado digitalmente.";

// Generar un nuevo par de claves (solo para este ejemplo)
$config = [
    "digest_alg" => "sha256",
    "private_key_bits" => 2048,
    "private_key_type" => OPENSSL_KEYTYPE_RSA,
];

// En PHP 8.3, openssl_pkey_new devuelve OpenSSLAsymmetricKey|false
$clavePrimaria = openssl_pkey_new($config);

if ($clavePrimaria === false) {
    imprimir("Error al generar la clave: " . openssl_error_string());
    exit(1);
}

// Extraer la clave privada
$exito = openssl_pkey_export($clavePrimaria, $clavePrivada);
if (!$exito) {
    imprimir("Error al exportar la clave privada: " . openssl_error_string());
    exit(1);
}

// Extraer la clave pública
$detallesClave = openssl_pkey_get_details($clavePrimaria);
if ($detallesClave === false) {
    imprimir("Error al obtener detalles de la clave: " . openssl_error_string());
    exit(1);
}
$clavePublica = $detallesClave["key"];

// Crear la firma
$firma = '';
$exito = openssl_sign($datos, $firma, $clavePrivada, OPENSSL_ALGO_SHA256);

if ($exito) {
    imprimir("Firma creada exitosamente.");
    imprimir("Firma (en base64): " . base64_encode($firma));

    // Verificar la firma
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

// No es necesario liberar manualmente el recurso en PHP 8.3
// La gestión de recursos se maneja automáticamente