<?php

namespace App\Http\Controllers;

use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        /*
        |--------------------------------------------------------------------------
        | Dashboard Statistics
        |--------------------------------------------------------------------------
        */

        $totalUsers = User::count();

        $verifiedUsers = User::whereNotNull('email_verified_at')->count();

        $unverifiedUsers = User::whereNull('email_verified_at')->count();

        $todayUsers = User::whereDate('created_at', today())->count();

        $newUsersThisMonth = User::whereMonth(
            'created_at',
            now()->month
        )
            ->whereYear('created_at', now()->year)
            ->count();

        $totalActivities = AdminActivityLog::count();

        /*
        |--------------------------------------------------------------------------
        | Last 7 Days User Registration Chart
        |--------------------------------------------------------------------------
        */

        $lastSevenDaysLabels = [];
        $lastSevenDaysData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);

            $lastSevenDaysLabels[] = $date->format('M d');

            $lastSevenDaysData[] = User::whereDate(
                'created_at',
                $date->toDateString()
            )->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Last 6 Months User Registration Chart
        |--------------------------------------------------------------------------
        */

        $monthlyLabels = [];
        $monthlyData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);

            $monthlyLabels[] = $date->format('M Y');

            $monthlyData[] = User::whereMonth(
                'created_at',
                $date->month
            )
                ->whereYear(
                    'created_at',
                    $date->year
                )
                ->count();
        }

        /*
        |--------------------------------------------------------------------------
        | Recent Activities
        |--------------------------------------------------------------------------
        */

        $recentActivities = AdminActivityLog::with('user')
            ->latest()
            ->take(8)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Log Dashboard Visit
        |--------------------------------------------------------------------------
        */

        AdminActivityLog::create([
            'action' => 'Dashboard Viewed',
            'description' => 'Admin dashboard was viewed.',
            'ip_address' => request()->ip(),
        ]);

        return view('dashboard', compact(
            'totalUsers',
            'verifiedUsers',
            'unverifiedUsers',
            'todayUsers',
            'newUsersThisMonth',
            'totalActivities',
            'lastSevenDaysLabels',
            'lastSevenDaysData',
            'monthlyLabels',
            'monthlyData',
            'recentActivities'
        ));
    }

    /**
     * Advanced Users Management
     */
    public function users(Request $request)
    {
        $query = User::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        /*
        |--------------------------------------------------------------------------
        | Verification Status Filter
        |--------------------------------------------------------------------------
        */

        if ($request->status === 'verified') {
            $query->whereNotNull('email_verified_at');
        }

        if ($request->status === 'unverified') {
            $query->whereNull('email_verified_at');
        }

        /*
        |--------------------------------------------------------------------------
        | Sorting
        |--------------------------------------------------------------------------
        */

        $allowedSorts = [
            'id',
            'name',
            'email',
            'created_at',
        ];

        $sort = $request->get('sort', 'created_at');

        $direction = $request->get('direction', 'desc');

        if (!in_array($sort, $allowedSorts)) {
            $sort = 'created_at';
        }

        if (!in_array($direction, ['asc', 'desc'])) {
            $direction = 'desc';
        }

        $users = $query
            ->orderBy($sort, $direction)
            ->paginate(10)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Log User List Access
        |--------------------------------------------------------------------------
        */

        AdminActivityLog::create([
            'action' => 'Users Viewed',
            'description' => 'Admin viewed the users management page.',
            'ip_address' => request()->ip(),
        ]);

        return view('users', compact(
            'users',
            'sort',
            'direction'
        ));
    }

    /**
     * User Details
     */
    public function show(User $user)
    {
        AdminActivityLog::create([
            'user_id' => $user->id,
            'action' => 'User Viewed',
            'description' => "Admin viewed user #{$user->id} ({$user->name}).",
            'ip_address' => request()->ip(),
        ]);

        return view('user-details', compact('user'));
    }
}