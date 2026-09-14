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
        $totalUsers = User::count();

        $verifiedUsers = User::whereNotNull('email_verified_at')->count();

        $unverifiedUsers = User::whereNull('email_verified_at')->count();

        $todayUsers = User::whereDate('created_at', today())->count();

        $newUsersThisMonth = User::whereMonth('created_at', now()->month)
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
            ->oldest()
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
     * Users Management
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
        | User Date Range Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('from_date')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->filled('to_date')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
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

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        /*
        |--------------------------------------------------------------------------
        | Per Page
        |--------------------------------------------------------------------------
        */

        $allowedPerPage = [
            5,
            10,
            15,
            25,
            50,
        ];

        $perPage = (int) $request->get('per_page', 10);

        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 10;
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $users = $query
            ->orderBy($sort, $direction)
            ->paginate($perPage)
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
            'direction',
            'perPage'
        ));
    }

    /**
     * User Details
     */
    public function show(User $user)
    {
        $activities = $user->activityLogs()
            ->latest()
            ->take(10)
            ->get();

        $activityCount = $user->activityLogs()->count();

        AdminActivityLog::create([
            'user_id' => $user->id,
            'action' => 'User Viewed',
            'description' => "Admin viewed user #{$user->id} ({$user->name}).",
            'ip_address' => request()->ip(),
        ]);

        return view('user-details', compact(
            'user',
            'activities',
            'activityCount'
        ));
    }

    /**
     * Toggle User Email Verification
     */
    public function toggleVerification(User $user)
    {
        if ($user->email_verified_at) {
            $user->email_verified_at = null;

            $status = 'unverified';

            $message = "User #{$user->id} ({$user->name}) was marked as unverified.";
        } else {
            $user->email_verified_at = now();

            $status = 'verified';

            $message = "User #{$user->id} ({$user->name}) was marked as verified.";
        }

        $user->save();

        AdminActivityLog::create([
            'user_id' => $user->id,
            'action' => 'User Verification Changed',
            'description' => $message,
            'ip_address' => request()->ip(),
        ]);

        return back()->with(
            'success',
            "User {$user->name} is now {$status}."
        );
    }

        /**
     * Export Users CSV
     */
    public function export(Request $request)
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
        | Date Range Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('from_date')) {
            $query->whereDate(
                'created_at',
                '>=',
                $request->from_date
            );
        }

        if ($request->filled('to_date')) {
            $query->whereDate(
                'created_at',
                '<=',
                $request->to_date
            );
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

        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        if (!in_array($direction, ['asc', 'desc'], true)) {
            $direction = 'desc';
        }

        $query->orderBy($sort, $direction);

        /*
        |--------------------------------------------------------------------------
        | CSV Download
        |--------------------------------------------------------------------------
        */

        $fileName = 'users_' . now()->format('Y_m_d_H_i_s') . '.csv';

        /*
        |--------------------------------------------------------------------------
        | Activity Log
        |--------------------------------------------------------------------------
        */

        AdminActivityLog::create([
            'action' => 'Users Exported',
            'description' => 'Admin exported users data as CSV.',
            'ip_address' => request()->ip(),
        ]);

        return response()->streamDownload(function () use ($query) {

            $handle = fopen('php://output', 'w');

            /*
            |--------------------------------------------------------------------------
            | CSV Header
            |--------------------------------------------------------------------------
            */

            fputcsv($handle, [
                'ID',
                'Name',
                'Email',
                'Verification Status',
                'Registered At',
                'Email Verified At',
            ]);

            /*
            |--------------------------------------------------------------------------
            | CSV Rows
            |--------------------------------------------------------------------------
            */

            foreach ($query->cursor() as $user) {

                fputcsv($handle, [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->email_verified_at
                        ? 'Verified'
                        : 'Unverified',
                    $user->created_at?->format('Y-m-d H:i:s'),
                    $user->email_verified_at?->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);

        }, $fileName, [
            'Content-Type' => 'text/csv',
        ]);
    }
}