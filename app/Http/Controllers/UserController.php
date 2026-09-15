<?php

namespace App\Http\Controllers;

use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Admin Dashboard with Dynamic Date Filtering
     */
    public function dashboard(Request $request)
    {
        $dateFilter = $request->query('date_filter', '7_days');
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        $query = User::query();

        switch ($dateFilter) {
            case 'today':
                $query->whereDate('created_at', today());
                $chartDays = 1;
                break;
            case '30_days':
                $query->where('created_at', '>=', now()->subDays(30));
                $chartDays = 30;
                break;
            case 'this_month':
                $query->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year);
                $chartDays = now()->day;
                break;
            case 'custom':
                if ($startDate && $endDate) {
                    $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
                }
                $chartDays = 14;
                break;
            case '7_days':
            default:
                $query->where('created_at', '>=', now()->subDays(7));
                $chartDays = 7;
                break;
        }

        $filteredUsersCount = $query->count();
        $totalUsers = User::count();
        $activeUsers = User::where('status', 'active')->count();
        $inactiveUsers = User::where('status', 'inactive')->count();
        $bannedUsers = User::where('status', 'banned')->count();
        $trashedUsersCount = User::onlyTrashed()->count();
        $totalActivities = AdminActivityLog::count();

        // Chart Data for trend
        $chartLabels = [];
        $chartData = [];

        for ($i = $chartDays - 1; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('M d');
            $chartData[] = User::whereDate('created_at', $date->toDateString())->count();
        }

        // Monthly Breakdown Chart (Last 6 Months)
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');
            $monthlyData[] = User::whereMonth('created_at', $date->month)
                ->whereYear('created_at', $date->year)
                ->count();
        }

        $recentUsers = User::latest()->take(5)->get();
        $recentActivities = AdminActivityLog::latest()->take(6)->get();

        return view('dashboard', compact(
            'totalUsers',
            'activeUsers',
            'inactiveUsers',
            'bannedUsers',
            'trashedUsersCount',
            'filteredUsersCount',
            'totalActivities',
            'dateFilter',
            'startDate',
            'endDate',
            'chartLabels',
            'chartData',
            'monthlyLabels',
            'monthlyData',
            'recentUsers',
            'recentActivities'
        ));
    }

    /**
     * User Management Listing
     */
    public function users(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $role = $request->input('role');

        $query = User::query()->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($status && in_array($status, ['active', 'inactive', 'banned'])) {
            $query->where('status', $status);
        }

        if ($role && in_array($role, ['admin', 'manager', 'editor', 'user'])) {
            $query->where('role', $role);
        }

        $users = $query->paginate(10)->withQueryString();
        $trashedCount = User::onlyTrashed()->count();
        $totalUsers = User::count();
        $activeCount = User::where('status', 'active')->count();

        return view('users', compact('users', 'trashedCount', 'totalUsers', 'activeCount', 'search', 'status', 'role'));
    }

    /**
     * Store new User (Create with Avatar & Password Generator)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:30',
            'role' => 'required|string|in:admin,manager,editor,user',
            'status' => 'required|string|in:active,inactive,banned',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'status' => $validated['status'],
            'avatar' => $avatarPath,
            'email_verified_at' => now(),
        ]);

        $this->logActivity('User Created', "Created new user '{$user->name}' ({$user->email}) with role {$user->role}.", $user->id);

        return redirect()->route('users.index')->with('success', "User '{$user->name}' created successfully!");
    }

    /**
     * Show single user details
     */
    public function show(User $user)
    {
        $activities = AdminActivityLog::where('user_id', $user->id)->latest()->take(10)->get();
        return view('user-details', compact('user', 'activities'));
    }

    /**
     * Update existing User details
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$id}",
            'password' => 'nullable|string|min:6',
            'phone' => 'nullable|string|max:30',
            'role' => 'required|string|in:admin,manager,editor,user',
            'status' => 'required|string|in:active,inactive,banned',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'status' => $validated['status'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $updateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($updateData);

        $this->logActivity('User Updated', "Updated details for user '{$user->name}'.", $user->id);

        return redirect()->route('users.index')->with('success', "User '{$user->name}' updated successfully!");
    }

    /**
     * 1-Click Status Toggle (Active -> Inactive -> Banned -> Active)
     */
    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);

        $nextStatus = match ($user->status) {
            'active' => 'inactive',
            'inactive' => 'banned',
            'banned' => 'active',
            default => 'active',
        };

        $user->update(['status' => $nextStatus]);

        $this->logActivity('Status Changed', "Changed status of user '{$user->name}' to '{$nextStatus}'.", $user->id);

        return redirect()->back()->with('success', "User '{$user->name}' status changed to " . ucfirst($nextStatus) . ".");
    }

    /**
     * Soft Delete a user (Move to Trash)
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $name = $user->name;
        $user->delete();

        $this->logActivity('User Moved to Trash', "Moved user '{$name}' to recycle bin.", $id);

        return redirect()->route('users.index')->with('success', "User '{$name}' moved to Trash successfully.");
    }

    /**
     * Trash / Recycle Bin list of soft-deleted users
     */
    public function trash(Request $request)
    {
        $search = $request->input('search');
        $query = User::onlyTrashed()->latest();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $trashedUsers = $query->paginate(10)->withQueryString();
        $trashedCount = User::onlyTrashed()->count();

        return view('users-trash', compact('trashedUsers', 'trashedCount', 'search'));
    }

    /**
     * Restore user from Trash
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        $this->logActivity('User Restored', "Restored user '{$user->name}' from trash.", $user->id);

        return redirect()->route('users.trash')->with('success', "User '{$user->name}' restored successfully!");
    }

    /**
     * Permanently delete user
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $name = $user->name;

        if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
            Storage::disk('public')->delete($user->avatar);
        }

        $user->forceDelete();

        $this->logActivity('User Permanently Deleted', "Permanently purged user '{$name}' from database.", $id);

        return redirect()->route('users.trash')->with('success', "User '{$name}' permanently deleted.");
    }

    /**
     * Bulk batch actions for checked users
     */
    public function bulkAction(Request $request)
    {
        $action = $request->input('bulk_action');
        $userIds = $request->input('user_ids', []);

        if (empty($userIds)) {
            return redirect()->back()->with('error', 'Please select at least one user.');
        }

        switch ($action) {
            case 'delete':
                User::whereIn('id', $userIds)->delete();
                $this->logActivity('Bulk Delete', "Soft-deleted " . count($userIds) . " user(s).");
                return redirect()->back()->with('success', count($userIds) . ' user(s) moved to Trash.');

            case 'restore':
                User::onlyTrashed()->whereIn('id', $userIds)->restore();
                $this->logActivity('Bulk Restore', "Restored " . count($userIds) . " user(s) from trash.");
                return redirect()->back()->with('success', count($userIds) . ' user(s) restored successfully.');

            case 'force_delete':
                $users = User::onlyTrashed()->whereIn('id', $userIds)->get();
                foreach ($users as $u) {
                    if ($u->avatar && Storage::disk('public')->exists($u->avatar)) {
                        Storage::disk('public')->delete($u->avatar);
                    }
                    $u->forceDelete();
                }
                $this->logActivity('Bulk Purge', "Permanently deleted " . count($userIds) . " user(s).");
                return redirect()->back()->with('success', count($userIds) . ' user(s) permanently deleted.');

            case 'status_active':
                User::whereIn('id', $userIds)->update(['status' => 'active']);
                return redirect()->back()->with('success', count($userIds) . ' user(s) marked as Active.');

            case 'status_inactive':
                User::whereIn('id', $userIds)->update(['status' => 'inactive']);
                return redirect()->back()->with('success', count($userIds) . ' user(s) marked as Inactive.');

            case 'status_banned':
                User::whereIn('id', $userIds)->update(['status' => 'banned']);
                return redirect()->back()->with('success', count($userIds) . ' user(s) marked as Banned.');

            default:
                return redirect()->back()->with('error', 'Invalid bulk action selected.');
        }
    }

    /**
     * Export Users to CSV
     */
    public function export(Request $request)
    {
        $users = User::all();
        $filename = 'users-export-' . now()->format('Y-m-d-His') . '.csv';

        return response()->streamDownload(function () use ($users) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Role', 'Status', 'Registered At']);
            foreach ($users as $u) {
                fputcsv($handle, [
                    $u->id,
                    $u->name,
                    $u->email,
                    $u->phone ?? 'N/A',
                    $u->role ?? 'user',
                    $u->status ?? 'active',
                    $u->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        }, $filename, ['Content-Type' => 'text/csv']);
    }

    /**
     * Helper to log activity
     */
    protected function logActivity(string $action, string $description, ?int $userId = null)
    {
        try {
            AdminActivityLog::create([
                'user_id' => $userId,
                'action' => $action,
                'description' => $description,
                'ip_address' => request()->ip() ?? '127.0.0.1',
                'user_agent' => request()->userAgent() ?? 'System',
            ]);
        } catch (\Throwable) {}
    }
}