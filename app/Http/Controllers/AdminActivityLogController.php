<?php

namespace App\Http\Controllers;

use App\Models\AdminActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class AdminActivityLogController extends Controller
{
    /**
     * Activity Log Listing
     */
    public function index(Request $request)
    {
        $query = AdminActivityLog::with('user');

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Action Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('action')) {

            $query->where(
                'action',
                $request->action
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Single Date Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {

            $query->whereDate(
                'created_at',
                $request->date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date Range Filter
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Pagination
        |--------------------------------------------------------------------------
        */

        $perPage = (int) $request->get(
            'per_page',
            5
        );

        if (!in_array(
            $perPage,
            [5, 10, 15, 25, 50, 100]
        )) {

            $perPage = 5;
        }

        $activities = $query
            ->oldest()
            ->paginate($perPage)
            ->withQueryString();

        /*
        |--------------------------------------------------------------------------
        | Available Actions
        |--------------------------------------------------------------------------
        */

        $actions = AdminActivityLog::query()
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        /*
        |--------------------------------------------------------------------------
        | Activity Statistics
        |--------------------------------------------------------------------------
        */

        $totalActivities = AdminActivityLog::count();

        $todayActivities = AdminActivityLog::whereDate(
            'created_at',
            today()
        )->count();

        $thisWeekActivities = AdminActivityLog::whereBetween(
            'created_at',
            [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ]
        )->count();

        $thisMonthActivities = AdminActivityLog::whereMonth(
            'created_at',
            now()->month
        )
            ->whereYear(
                'created_at',
                now()->year
            )
            ->count();

        /*
        |--------------------------------------------------------------------------
        | Top Action
        |--------------------------------------------------------------------------
        */

        $topAction = AdminActivityLog::query()
            ->selectRaw('action, COUNT(*) as total')
            ->groupBy('action')
            ->orderByDesc('total')
            ->first();

        return view(
            'activity-logs',
            compact(
                'activities',
                'actions',
                'perPage',
                'totalActivities',
                'todayActivities',
                'thisWeekActivities',
                'thisMonthActivities',
                'topAction'
            )
        );
    }

    /**
     * Export Activity Logs CSV
     */
    public function export(Request $request)
    {
        $query = AdminActivityLog::query();

        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('action', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('ip_address', 'like', "%{$search}%");

            });
        }

        /*
        |--------------------------------------------------------------------------
        | Action
        |--------------------------------------------------------------------------
        */

        if ($request->filled('action')) {

            $query->where(
                'action',
                $request->action
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Single Date
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date')) {

            $query->whereDate(
                'created_at',
                $request->date
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Date Range
        |--------------------------------------------------------------------------
        */

        if ($request->filled('date_from')) {

            $query->whereDate(
                'created_at',
                '>=',
                $request->date_from
            );
        }

        if ($request->filled('date_to')) {

            $query->whereDate(
                'created_at',
                '<=',
                $request->date_to
            );
        }

        $activities = $query
            ->with('user')
            ->oldest()
            ->get();

        $filename =
            'activity_logs_' .
            now()->format('Y_m_d_H_i_s') .
            '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' =>
                'attachment; filename="' .
                $filename .
                '"',
        ];

        $callback = function () use ($activities) {

            $file = fopen(
                'php://output',
                'w'
            );

            fputcsv($file, [
                'ID',
                'User ID',
                'User Name',
                'Action',
                'Description',
                'IP Address',
                'Created At',
            ]);

            foreach ($activities as $activity) {

                fputcsv($file, [
                    $activity->id,
                    $activity->user_id ?? '',
                    $activity->user?->name ?? 'System',
                    $activity->action,
                    $activity->description,
                    $activity->ip_address ?? '',
                    $activity->created_at?->format(
                        'Y-m-d H:i:s'
                    ),
                ]);
            }

            fclose($file);
        };

        return Response::stream(
            $callback,
            200,
            $headers
        );
    }

    /**
     * Delete old activity logs
     */
    public function cleanup(Request $request)
    {
        $days = (int) $request->get(
            'days',
            30
        );

        if (!in_array(
            $days,
            [7, 15, 30, 60, 90, 180, 365]
        )) {

            $days = 30;
        }

        $before = now()->subDays($days);

        $deleted = AdminActivityLog::where(
            'created_at',
            '<',
            $before
        )->delete();

        return redirect()
            ->route('activity.logs')
            ->with(
                'success',
                "{$deleted} activity log(s) older than {$days} days deleted."
            );
    }
}