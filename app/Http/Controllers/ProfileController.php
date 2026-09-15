<?php

namespace App\Http\Controllers;

use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Display the Admin Profile page.
     */
    public function show()
    {
        $adminUser = User::where('role', 'admin')->first() ?? User::first();

        if (!$adminUser) {
            $adminUser = User::create([
                'name' => 'System Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
            ]);
        }

        $recentActivities = AdminActivityLog::latest()->take(8)->get();

        return view('profile', compact('adminUser', 'recentActivities'));
    }

    /**
     * Update Profile Details (Name, Email, Phone, Avatar).
     */
    public function update(Request $request)
    {
        $adminUser = User::where('role', 'admin')->first() ?? User::firstOrFail();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$adminUser->id}",
            'phone' => 'nullable|string|max:30',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
        ];

        if ($request->hasFile('avatar')) {
            if ($adminUser->avatar && Storage::disk('public')->exists($adminUser->avatar)) {
                Storage::disk('public')->delete($adminUser->avatar);
            }
            $updateData['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $adminUser->update($updateData);

        try {
            AdminActivityLog::create([
                'user_id' => $adminUser->id,
                'action' => 'Profile Updated',
                'description' => "Administrator updated profile information.",
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'System',
            ]);
        } catch (\Throwable) {}

        return redirect()->route('profile.show')->with('success', 'Profile information updated successfully!');
    }

    /**
     * Update Administrator Password.
     */
    public function updatePassword(Request $request)
    {
        $adminUser = User::where('role', 'admin')->first() ?? User::firstOrFail();

        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!Hash::check($validated['current_password'], $adminUser->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        $adminUser->update([
            'password' => Hash::make($validated['password']),
        ]);

        try {
            AdminActivityLog::create([
                'user_id' => $adminUser->id,
                'action' => 'Password Changed',
                'description' => "Administrator updated their login password.",
                'ip_address' => $request->ip() ?? '127.0.0.1',
                'user_agent' => $request->userAgent() ?? 'System',
            ]);
        } catch (\Throwable) {}

        return redirect()->route('profile.show')->with('success', 'Password changed successfully!');
    }
}
