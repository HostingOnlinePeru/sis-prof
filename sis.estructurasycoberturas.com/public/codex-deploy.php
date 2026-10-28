<?php
$token = 'codex-' . '20260711' . '-sanchez';
$base = dirname(__DIR__);
$work = $base . '/storage/app/codex-deploy';
$b64 = $work . '/update.zip.b64';
$zip = $work . '/update.zip';
function out($msg){ echo '<pre style="font:14px monospace;white-space:pre-wrap">'.htmlspecialchars($msg, ENT_QUOTES, 'UTF-8').'</pre>'; }
function ok_token($token){ return ($_REQUEST['token'] ?? '') === $token; }
if (!ok_token($token)) { http_response_code(403); exit('Token invalido'); }
@mkdir($work, 0775, true);
$action = $_POST['action'] ?? $_GET['action'] ?? 'form';
if ($action === 'clear') {
    $log = "Base: $base\n";
    try {
        require $base . '/vendor/autoload.php';
        $app = require $base . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->call('optimize:clear');
        $log .= "CACHE:\n".$kernel->output()."\n";
        if (function_exists('opcache_reset')) {
            opcache_reset();
            $log .= "OPCACHE: reset ok\n";
        }
    } catch (Throwable $e) {
        $log .= "ERROR: ".$e->getMessage()."\n";
    }
    out($log);
    exit;
}
if ($action === 'chunk') {
    $data = $_POST['data'] ?? '';
    if (($_POST['first'] ?? '') === '1') { @unlink($b64); @unlink($zip); }
    file_put_contents($b64, preg_replace('/\s+/', '', $data), FILE_APPEND | LOCK_EX);
    out('CHUNK_OK '.strlen($data).' total='.filesize($b64));
    exit;
}
if ($action === 'deploy') {
    if (!is_file($b64)) { out('No existe payload base64'); exit; }
    $decoded = base64_decode(file_get_contents($b64), true);
    if ($decoded === false) { out('Base64 invalido'); exit; }
    file_put_contents($zip, $decoded, LOCK_EX);
    $za = new ZipArchive();
    if ($za->open($zip) !== true) { out('No se pudo abrir ZIP'); exit; }
    if (!$za->extractTo($base)) { out('No se pudo extraer ZIP'); $za->close(); exit; }
    $za->close();
    $log = "ZIP extraido en $base
";
    try {
        require $base . '/vendor/autoload.php';
        $app = require $base . '/bootstrap/app.php';
        $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
        $kernel->call('migrate', ['--force' => true]);
        $log .= "MIGRATE:
".$kernel->output()."
";
        $kernel->call('optimize:clear');
        $log .= "CACHE:
".$kernel->output()."
";
    } catch (Throwable $e) {
        $log .= "ERROR ARTISAN: ".$e->getMessage()."
";
    }
    @unlink($b64); @unlink($zip);
    out($log."
DEPLOY_OK");
    exit;
}
if ($action === 'cleanup') { @unlink(__FILE__); exit('CLEANUP_OK'); }
?>
<!doctype html><meta charset="utf-8"><title>Codex Deploy</title>
<form method="post"><input type="hidden" name="token" value="<?=htmlspecialchars($token)?>"><input type="hidden" name="action" value="chunk"><label><input type="checkbox" name="first" value="1"> first</label><br><textarea name="data" style="width:100%;height:320px"></textarea><br><button>Subir chunk</button></form>
<form method="post" style="margin-top:20px"><input type="hidden" name="token" value="<?=htmlspecialchars($token)?>"><input type="hidden" name="action" value="deploy"><button>Desplegar</button></form>
<form method="post" style="margin-top:20px"><input type="hidden" name="token" value="<?=htmlspecialchars($token)?>"><input type="hidden" name="action" value="cleanup"><button>Eliminar actualizador</button></form>