<?php

namespace App\Listeners;

use App\Models\LoginLog;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
{
    /**
     * Handle the Login event fired by Laravel's authentication system.
     */
    public function handle(Login $event): void
    {
        $user = $event->user;
        $request = request();

        // Cegah pembuatan log ganda dalam rentang 5 detik untuk pengguna yang sama
        $recentLog = LoginLog::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subSeconds(5))
            ->first();

        if ($recentLog) {
            return;
        }

        LoginLog::create([
            'user_id'    => $user->id,
            'email'      => $user->email,
            'name'       => $user->name,
            'role'       => $user->role ?? null,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);
    }
}
