<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display admin dashboard with statistics
     */
    public function index()
    {
        try {
            // Get basic statistics
            $stats = [
                'total_users' => User::count(),
                'total_products' => Product::count(),
                'total_contacts' => ContactMessage::count(),
                'active_users' => User::whereNotNull('email_verified_at')->count(),
                'new_users_today' => User::whereDate('created_at', today())->count(),
                'new_products_today' => Product::whereDate('created_at', today())->count(),
                'new_contacts_today' => ContactMessage::whereDate('created_at', today())->count(),
            ];

            // Get user role distribution
            $userRoles = [
                'customers' => User::where('role', 'customer')->count(),
                'managers' => User::where('role', 'manager')->count(),
                'admins' => User::where('role', 'admin')->count(),
                'ceos' => User::where('role', 'ceo')->count(),
            ];

            // Get recent activities
            $recentUsers = User::latest()->take(5)->get();
            $recentProducts = Product::latest()->take(5)->get();
            $recentContacts = ContactMessage::latest()->take(5)->get();

            // Get chart data for last 7 days
            $chartData = $this->getChartData();

            // Get system info
            $systemInfo = [
                'php_version' => PHP_VERSION,
                'laravel_version' => app()->version(),
                'database_size' => $this->getDatabaseSize(),
                'disk_usage' => $this->getDiskUsage(),
            ];

            return view('admin.dashboard', compact(
                'stats', 'userRoles', 'recentUsers', 'recentProducts', 
                'recentContacts', 'chartData', 'systemInfo'
            ));
        } catch (\Exception $e) {
            \Log::error('Dashboard error: ' . $e->getMessage());
            
            // Return basic data if there's an error
            return view('admin.dashboard', [
                'stats' => [
                    'total_users' => 0,
                    'total_products' => 0,
                    'total_contacts' => 0,
                    'active_users' => 0,
                    'new_users_today' => 0,
                    'new_products_today' => 0,
                    'new_contacts_today' => 0,
                ],
                'userRoles' => [
                    'customers' => 0,
                    'managers' => 0,
                    'admins' => 0,
                    'ceos' => 0,
                ],
                'recentUsers' => collect(),
                'recentProducts' => collect(),
                'recentContacts' => collect(),
                'chartData' => $this->getEmptyChartData(),
                'systemInfo' => [
                    'php_version' => PHP_VERSION,
                    'laravel_version' => app()->version(),
                    'database_size' => 'Unknown',
                    'disk_usage' => ['total' => '0 MB', 'used' => '0 MB', 'free' => '0 MB'],
                ]
            ]);
        }
    }

    /**
     * Get chart data for last 7 days
     */
    private function getChartData()
    {
        try {
            $dates = collect(CarbonPeriod::create(now()->subDays(6), now())->toArray());
            
            $contactMessages = $dates->map(function($date) {
                return ContactMessage::whereDate('created_at', $date)->count();
            });

            $newUsers = $dates->map(function($date) {
                return User::whereDate('created_at', $date)->count();
            });

            $newProducts = $dates->map(function($date) {
                return Product::whereDate('created_at', $date)->count();
            });

            return [
                'labels' => $dates->map->format('D d'),
                'contact_messages' => $contactMessages,
                'new_users' => $newUsers,
                'new_products' => $newProducts,
            ];
        } catch (\Exception $e) {
            \Log::error('Chart data error: ' . $e->getMessage());
            return $this->getEmptyChartData();
        }
    }

    /**
     * Get empty chart data for fallback
     */
    private function getEmptyChartData()
    {
        $dates = collect(CarbonPeriod::create(now()->subDays(6), now())->toArray());
        
        return [
            'labels' => $dates->map->format('D d'),
            'contact_messages' => $dates->map(fn() => 0),
            'new_users' => $dates->map(fn() => 0),
            'new_products' => $dates->map(fn() => 0),
        ];
    }

    /**
     * Get database size
     */
    private function getDatabaseSize()
    {
        try {
            $dbName = config('database.connections.mysql.database');
            $result = DB::select("SELECT ROUND(SUM(data_length + index_length) / 1024 / 1024, 1) AS 'size' FROM information_schema.tables WHERE table_schema = '{$dbName}'");
            return $this->formatBytes($result[0]->size * 1024 * 1024);
        } catch (\Exception $e) {
            return 'Unknown';
        }
    }

    /**
     * Get disk usage
     */
    private function getDiskUsage()
    {
        try {
            $total = disk_total_space('/');
            $free = disk_free_space('/');
            $used = $total - $free;

            return [
                'total' => $this->formatBytes($total),
                'used' => $this->formatBytes($used),
                'free' => $this->formatBytes($free),
                'percentage' => round(($used / $total) * 100, 2)
            ];
        } catch (\Exception $e) {
            return [
                'total' => '0 MB',
                'used' => '0 MB', 
                'free' => '0 MB',
                'percentage' => 0
            ];
        }
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

    /**
     * Get dashboard statistics for AJAX
     */
    public function getStats()
    {
        try {
            $stats = [
                'total_users' => User::count(),
                'total_products' => Product::count(),
                'total_contacts' => ContactMessage::count(),
                'active_users' => User::whereNotNull('email_verified_at')->count(),
                'new_users_today' => User::whereDate('created_at', today())->count(),
                'new_products_today' => Product::whereDate('created_at', today())->count(),
                'new_contacts_today' => ContactMessage::whereDate('created_at', today())->count(),
            ];

            return response()->json(['success' => true, 'stats' => $stats]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
