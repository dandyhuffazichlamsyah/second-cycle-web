<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class SystemSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin', 'ceo']);
    }

    /**
     * Display system settings page
     */
    public function index()
    {
        $settings = $this->getSystemSettings();
        return view('admin.system-settings', compact('settings'));
    }

    /**
     * Update system settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'contact_email' => 'required|email',
            'contact_phone' => 'nullable|string|max:20',
            'maintenance_mode' => 'boolean',
            'allow_registration' => 'boolean',
            'email_verification' => 'boolean',
            'max_file_size' => 'nullable|integer|min:1|max:10240',
            'allowed_file_types' => 'nullable|string',
        ]);

        try {
            $settings = $request->only([
                'site_name', 'site_description', 'contact_email', 'contact_phone',
                'maintenance_mode', 'allow_registration', 'email_verification',
                'max_file_size', 'allowed_file_types'
            ]);

            // Store settings in cache
            Cache::forever('system_settings', $settings);

            // Update environment file for critical settings
            $this->updateEnvironmentFile($settings);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengaturan sistem berhasil diperbarui!',
                    'settings' => $settings
                ]);
            }

            return redirect()->route('admin.system-settings')
                ->with('success', 'Pengaturan sistem berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating system settings: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui pengaturan: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.system-settings')
                ->with('error', 'Gagal memperbarui pengaturan: ' . $e->getMessage());
        }
    }

    /**
     * Clear system cache
     */
    public function clearCache(Request $request)
    {
        try {
            Cache::flush();
            \Artisan::call('config:clear');
            \Artisan::call('route:clear');
            \Artisan::call('view:clear');

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Cache sistem berhasil dibersihkan!'
                ]);
            }

            return redirect()->route('admin.system-settings')
                ->with('success', 'Cache sistem berhasil dibersihkan!');
        } catch (\Exception $e) {
            Log::error('Error clearing cache: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membersihkan cache: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.system-settings')
                ->with('error', 'Gagal membersihkan cache: ' . $e->getMessage());
        }
    }

    /**
     * Backup database
     */
    public function backupDatabase(Request $request)
    {
        try {
            $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
            $command = sprintf(
                'mysqldump --user=%s --password=%s --host=%s %s > %s',
                config('database.connections.mysql.username'),
                config('database.connections.mysql.password'),
                config('database.connections.mysql.host'),
                config('database.connections.mysql.database'),
                storage_path('app/backups/' . $filename)
            );

            // Create backups directory if it doesn't exist
            Storage::disk('local')->makeDirectory('backups');

            exec($command);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Backup database berhasil dibuat!',
                    'filename' => $filename
                ]);
            }

            return redirect()->route('admin.system-settings')
                ->with('success', 'Backup database berhasil dibuat!');
        } catch (\Exception $e) {
            Log::error('Error backing up database: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat backup: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.system-settings')
                ->with('error', 'Gagal membuat backup: ' . $e->getMessage());
        }
    }

    /**
     * Get system statistics
     */
    public function getSystemStats()
    {
        try {
            $stats = [
                'users' => \App\Models\User::count(),
                'products' => \App\Models\Product::count(),
                'contacts' => \App\Models\ContactMessage::count(),
                'disk_usage' => $this->getDiskUsage(),
                'memory_usage' => memory_get_usage(true),
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'database_size' => $this->getDatabaseSize(),
                'last_backup' => $this->getLastBackup(),
                'uptime' => $this->getSystemUptime(),
            ];

            return response()->json($stats);
        } catch (\Exception $e) {
            Log::error('Error getting system stats: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get system stats'], 500);
        }
    }

    /**
     * Get current system settings
     */
    private function getSystemSettings()
    {
        return Cache::get('system_settings', [
            'site_name' => config('app.name', 'SecondCycle'),
            'site_description' => 'Platform jual-beli motor bekas terpercaya',
            'contact_email' => config('mail.from.address', 'info@secondcycle.id'),
            'contact_phone' => '+62 812-3456-7890',
            'maintenance_mode' => false,
            'allow_registration' => true,
            'email_verification' => true,
            'max_file_size' => 5120,
            'allowed_file_types' => 'jpg,jpeg,png,gif,pdf,doc,docx',
        ]);
    }

    /**
     * Update environment file
     */
    private function updateEnvironmentFile($settings)
    {
        $envFile = base_path('.env');
        $envContent = file_get_contents($envFile);

        $envMappings = [
            'site_name' => 'APP_NAME',
            'contact_email' => 'MAIL_FROM_ADDRESS',
        ];

        foreach ($envMappings as $setting => $envKey) {
            if (isset($settings[$setting])) {
                $pattern = "/^{$envKey}=.*$/m";
                $replacement = "{$envKey}=" . $settings[$setting];
                $envContent = preg_replace($pattern, $replacement, $envContent);
            }
        }

        file_put_contents($envFile, $envContent);
    }

    /**
     * Get disk usage
     */
    private function getDiskUsage()
    {
        $total = disk_total_space('/');
        $free = disk_free_space('/');
        $used = $total - $free;

        return [
            'total' => $this->formatBytes($total),
            'used' => $this->formatBytes($used),
            'free' => $this->formatBytes($free),
            'percentage' => round(($used / $total) * 100, 2)
        ];
    }

    /**
     * Get database size
     */
    private function getDatabaseSize()
    {
        try {
            $dbName = config('database.connections.mysql.database');
            $result = \DB::select("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS 'size' FROM information_schema.tables WHERE table_schema = '{$dbName}'");
            return $this->formatBytes($result[0]->size * 1024 * 1024);
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Get last backup
     */
    private function getLastBackup()
    {
        try {
            $backups = Storage::disk('local')->files('backups');
            if (empty($backups)) {
                return null;
            }

            $latestBackup = collect($backups)->last();
            return [
                'filename' => basename($latestBackup),
                'date' => Storage::disk('local')->lastModified($latestBackup),
                'size' => $this->formatBytes(Storage::disk('local')->size($latestBackup))
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get system uptime
     */
    private function getSystemUptime()
    {
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            return [
                'load_1min' => $load[0],
                'load_5min' => $load[1],
                'load_15min' => $load[2]
            ];
        }
        return null;
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
