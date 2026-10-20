<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\OtpCode;
use App\Models\OtpGatewayMessage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function showLogin(): View
    {
        return view('front.auth.login');
    }

    public function sendOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
            'name' => 'nullable|string|max:100',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $phone = $this->normalizePhone($request->phone);

        if ($request->filled('name')) {
            session(['pending_user_name' => $request->name]);
        }

        if (app()->environment('local') || config('app.debug')) {
            OtpCode::updateOrCreate(
                ['phone' => $phone],
                [
                    'code' => '240774',
                    'action' => 'auth',
                    'expires_at' => Carbon::now()->addMinutes(10),
                    'is_used' => false,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => 'Tassyklama kody ugradyldy (DEV: 240774)',
                'dev_code' => '240774',
            ]);
        }

        $code = (string) random_int(100000, 999999);

        OtpCode::updateOrCreate(
            ['phone' => $phone],
            [
                'code' => $code,
                'action' => 'auth',
                'expires_at' => Carbon::now()->addMinutes(5),
                'is_used' => false,
            ]
        );

        OtpGatewayMessage::create([
            'phone' => $phone,
            'message' => "ProTeachers tassyklama kody: {$code}",
            'status' => 0,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tassyklama kody ugradyldy.',
        ]);
    }

    public function verifyOtp(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required|string|max:20',
            'code' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $phone = $this->normalizePhone($request->phone);
        $isDevMasterCode = (app()->environment('local') || config('app.debug')) && $request->code === '240774';

        if (!$isDevMasterCode) {
            $otp = OtpCode::where('phone', $phone)
                ->where('code', $request->code)
                ->where('is_used', false)
                ->where('expires_at', '>', Carbon::now())
                ->first();

            if (!$otp) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kod nädogry ýa-da möhleti geçen.',
                ], 422);
            }

            $otp->update(['is_used' => true]);
        }

        $user = User::where('phone', $phone)->first();

        if (!$user) {
            $name = session()->pull('pending_user_name', 'Ulanyjy ' . substr($phone, -4));
            $user = User::create([
                'name' => $name,
                'phone' => $phone,
                'phone_verified_at' => Carbon::now(),
                'role' => 'student',
                'status' => 1,
            ]);
        } else {
            if (!$user->phone_verified_at) {
                $user->update(['phone_verified_at' => Carbon::now()]);
            }
        }

        if ($user->status !== 1) {
            return response()->json([
                'success' => false,
                'message' => 'Hasabyňyz petiklenen.',
            ], 403);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        $redirectUrl = match ($user->role) {
            'admin' => route('admin.dashboard'),
            'teacher' => route('teacher.portal.dashboard'),
            default => route('home'),
        };

        return response()->json([
            'success' => true,
            'redirect' => $redirectUrl,
        ]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);

        if (strlen($phone) === 8) {
            return '+993' . $phone;
        }

        if (strlen($phone) === 11 && str_starts_with($phone, '993')) {
            return '+' . $phone;
        }

        return '+' . $phone;
    }
}