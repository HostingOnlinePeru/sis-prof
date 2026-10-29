<?php
// Limpieza de caché de vistas y OPcache en producción
$base = dirname(__DIR__);
$views = glob($base . '/storage/framework/views/*.php');
$count = 0;
if ($views) {
    foreach ($views as $f) {
        if (@unlink($f)) $count++;
    }
}
$opcache = function_exists('opcache_reset') && opcache_reset() ? 'RESET_OK' : 'SKIPPED';

header('Content-Type: text/plain; charset=utf-8');
echo "DELETED_VIEWS: $count\n";
echo "OPCACHE: $opcache\n";
echo "TIME: " . date('Y-m-d H:i:s') . "\n";
