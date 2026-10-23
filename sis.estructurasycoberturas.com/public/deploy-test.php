<?php

// Archivo temporal para verificar el deploy. Eliminar después de revisar.
header('Content-Type: text/plain; charset=utf-8');

$root = dirname(__DIR__);

echo "DEPLOY TEST OK\n";
echo 'Marca de código: 2026-10-23-v1' . "\n";
echo 'Fecha del servidor: ' . date('c') . "\n";
echo 'Ruta: ' . $root . "\n";
echo 'PHP: ' . PHP_VERSION . "\n";
echo 'Modificado: ' . date('c', filemtime(__FILE__)) . "\n";
