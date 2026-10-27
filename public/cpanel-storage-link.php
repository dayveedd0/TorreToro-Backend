<?php
/**
 * One-Click Storage Link & Cache Clear Tool for cPanel Shared Hosting
 *
 * Usage:
 * 1. Upload this file to your public/ directory on cPanel.
 * 2. Access in browser: https://api.yourdomain.com/cpanel-storage-link.php?key=toretorro_setup_2026
 * 3. Delete this file immediately after execution for security.
 */

$securityKey = 'toretorro_setup_2026';

if (!isset($_GET['key']) || $_GET['key'] !== $securityKey) {
    http_response_code(403);
    die('<h1>403 Forbidden</h1><p>Invalid or missing security key.</p>');
}

$target = __DIR__ . '/../storage/app/public';
$shortcut = __DIR__ . '/storage';

$results = [];

// 1. Storage link check & creation
if (file_exists($shortcut)) {
    $results[] = 'Target shortcut "public/storage" already exists.';
} else {
    if (function_exists('symlink')) {
        try {
            $created = @symlink($target, $shortcut);
            if ($created) {
                $results[] = 'SUCCESS: Symbolic link created from "' . $target . '" to "' . $shortcut . '".';
            } else {
                $results[] = 'NOTICE: symlink() function returned false. Your cPanel host might restrict symlinks.';
            }
        } catch (\Throwable $e) {
            $results[] = 'ERROR creating symlink: ' . $e->getMessage();
        }
    } else {
        $results[] = 'NOTICE: symlink() function is disabled in php.ini on this host.';
    }
}

// 2. Clear Laravel caches via bootstrap
try {
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    \Illuminate\Support\Facades\Artisan::call('optimize:clear');
    $results[] = 'SUCCESS: Laravel caches cleared: ' . trim(\Illuminate\Support\Facades\Artisan::output());

    \Illuminate\Support\Facades\Artisan::call('storage:link');
    $results[] = 'Artisan storage:link output: ' . trim(\Illuminate\Support\Facades\Artisan::output());
} catch (\Throwable $e) {
    $results[] = 'Laravel bootstrap notice: ' . $e->getMessage();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Torre Tórò cPanel Setup Helper</title>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif; background: #0f172a; color: #f8fafc; padding: 40px; }
        .card { background: #1e293b; border-radius: 12px; padding: 24px; max-width: 650px; margin: 0 auto; box-shadow: 0 10px 25px rgba(0,0,0,0.5); border: 1px solid #334155; }
        h1 { color: #f59e0b; font-size: 20px; margin-top: 0; }
        ul { background: #0f172a; padding: 16px 32px; border-radius: 8px; border: 1px solid #334155; }
        li { margin-bottom: 8px; font-family: monospace; font-size: 13px; }
        .alert { background: #7c2d12; color: #fecaca; padding: 12px 16px; border-radius: 8px; font-size: 13px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="card">
        <h1>Torre Tórò - cPanel Storage & Cache Helper</h1>
        <ul>
            <?php foreach ($results as $res): ?>
                <li><?= htmlspecialchars($res) ?></li>
            <?php endforeach; ?>
        </ul>
        <div class="alert">
            <strong>IMPORTANT:</strong> For security, please delete this file (<code>public/cpanel-storage-link.php</code>) via cPanel File Manager now that setup is complete.
        </div>
    </div>
</body>
</html>
