<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display all users with filtering and pagination
     */
    public function index(Request $request)
    {
        $query = User::latest();

        // Search by name or email
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by role
        if ($request->role) {
            $query->where('role', $request->role);
        }

        // Filter by status (active/inactive based on email verification)
        if ($request->status) {
            if ($request->status === 'active') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->status === 'inactive') {
                $query->whereNull('email_verified_at');
            }
        }

        $users = $query->paginate(10);
        
        return view('admin.users', compact('users'));
    }

    /**
     * Store a new user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:customer,manager,admin,ceo',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'email_verified_at' => now(),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengguna berhasil ditambahkan!',
                    'user' => $user
                ]);
            }

            return redirect()->route('admin.users')
                ->with('success', 'Pengguna berhasil ditambahkan!');
        } catch (\Exception $e) {
            Log::error('Error creating user: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menambahkan pengguna: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.users')
                ->with('error', 'Gagal menambahkan pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Show user details
     */
    public function show(Request $request, User $user)
    {
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        }

        return view('admin.users.show', compact('user'));
    }

    /**
     * Update user
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:customer,manager,admin,ceo',
        ]);

        try {
            $userData = $request->only(['name', 'email', 'role']);
            
            // If email changed, remove verification
            if ($user->email !== $request->email) {
                $userData['email_verified_at'] = null;
            }

            $user->update($userData);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengguna berhasil diperbarui!',
                    'user' => $user
                ]);
            }

            return redirect()->route('admin.users')
                ->with('success', 'Pengguna berhasil diperbarui!');
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal memperbarui pengguna: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.users')
                ->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Delete user
     */
    public function destroy(Request $request, User $user)
    {
        try {
            // Prevent deletion of current user
            if ($user->id === auth()->id()) {
                throw new \Exception('Tidak dapat menghapus akun yang sedang digunakan.');
            }

            // Prevent deletion of CEO if current user is not CEO
            if ($user->role === 'ceo' && !auth()->user()->isCeo()) {
                throw new \Exception('Hanya CEO yang dapat menghapus akun CEO.');
            }

            $user->delete();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Pengguna berhasil dihapus!'
                ]);
            }

            return redirect()->route('admin.users')
                ->with('success', 'Pengguna berhasil dihapus!');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus pengguna: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.users')
                ->with('error', 'Gagal menghapus pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Toggle user status (active/inactive)
     */
    public function toggleStatus(Request $request, User $user)
    {
        try {
            if ($user->id === auth()->id()) {
                throw new \Exception('Tidak dapat mengubah status akun yang sedang digunakan.');
            }

            if ($user->email_verified_at) {
                $user->email_verified_at = null;
                $message = 'Pengguna berhasil dinonaktifkan!';
            } else {
                $user->email_verified_at = now();
                $message = 'Pengguna berhasil diaktifkan!';
            }

            $user->save();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'user' => $user
                ]);
            }

            return redirect()->route('admin.users')
                ->with('success', $message);
        } catch (\Exception $e) {
            Log::error('Error toggling user status: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengubah status: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.users')
                ->with('error', 'Gagal mengubah status: ' . $e->getMessage());
        }
    }

    /**
     * Reset user password
     */
    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $user->update([
                'password' => Hash::make($request->password),
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Password pengguna berhasil direset!'
                ]);
            }

            return redirect()->route('admin.users')
                ->with('success', 'Password pengguna berhasil direset!');
        } catch (\Exception $e) {
            Log::error('Error resetting password: ' . $e->getMessage());
            
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal reset password: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.users')
                ->with('error', 'Gagal reset password: ' . $e->getMessage());
        }
    }

    /**
     * Get user statistics for dashboard
     */
    public function getStats()
    {
        $stats = [
            'total' => User::count(),
            'customers' => User::where('role', 'customer')->count(),
            'managers' => User::where('role', 'manager')->count(),
            'admins' => User::where('role', 'admin')->count(),
            'ceos' => User::where('role', 'ceo')->count(),
            'active' => User::whereNotNull('email_verified_at')->count(),
            'inactive' => User::whereNull('email_verified_at')->count(),
            'recent' => User::latest()->take(5)->get(),
        ];

        return response()->json($stats);
    }

    /**
     * Export users to CSV
     */
    public function export(Request $request)
    {
        $users = User::latest();

        // Apply filters
        if ($request->role) {
            $users->where('role', $request->role);
        }
        if ($request->status === 'active') {
            $users->whereNotNull('email_verified_at');
        } elseif ($request->status === 'inactive') {
            $users->whereNull('email_verified_at');
        }

        $users = $users->get();

        $filename = 'users_' . date('Y-m-d_H-i-s') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($file, [
                'ID', 'Nama', 'Email', 'Role', 'Status', 'Google ID', 'Dibuat', 'Diperbarui'
            ]);

            // CSV Data
            foreach ($users as $user) {
                fputcsv($file, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->email_verified_at ? 'Aktif' : 'Tidak Aktif',
                    $user->google_id ?: 'Manual',
                    $user->created_at->format('d M Y H:i'),
                    $user->updated_at->format('d M Y H:i')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
