<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\ResetPasswordNotification;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        
        // Cek kredensial
        $user = \App\Models\User::where('email', $credentials['email'])->first();
        
        if ($user && !Hash::check($credentials['password'], $user->password)) {
            return back()->withErrors([
                'email' => 'Email atau password salah.',
            ])->onlyInput('email');
        }
        
        if ($user && !$user->is_approved && $user->role !== 'admin') {
            return back()->withErrors([
                'email' => 'Akun Anda masih menunggu verifikasi dari administrator. Silakan hubungi admin untuk informasi lebih lanjut.',
            ])->onlyInput('email');
        }
        
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            return $this->redirectBasedOnRole(Auth::user());
        }
        
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('home')->with('success', 'Anda berhasil logout');
    }
    
    public function showRegister()
    {
        if (Auth::check()) {
            return $this->redirectBasedOnRole(Auth::user());
        }
        
        // Get hamlets data for dropdown
        $hamlets = $this->getHamlets();
        
        return view('auth.register', compact('hamlets'));
    }
    
    private function getHamlets()
    {
        if (!\Illuminate\Support\Facades\Storage::disk('local')->exists('hamlets.json')) {
            return [];
        }
        
        $hamlets = json_decode(\Illuminate\Support\Facades\Storage::disk('local')->get('hamlets.json'), true) ?? [];
        return collect($hamlets)->pluck('name')->toArray();
    }
    
    public function register(Request $request)
    {
        $validated = $request->validate([
            // Data User & Akun
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            
            // Data Resident/Kependudukan
            'nik' => 'required|string|size:16|unique:users,nik',
            'family_card_number' => 'required|string|size:16',
            'gender' => 'required|in:Male,Female',
            'birth_date' => 'required|date',
            'birth_place' => 'required|string|max:100',
            'address' => 'required|string',
            'hamlet' => 'required|string|max:100',
            'religion' => 'required|string|max:50',
            'marital_status' => 'required|in:Single,Married,Divorced,Widowed',
            'occupation' => 'required|string|max:100',
            'phone' => 'required|string|max:15',
            'status' => 'required|in:active,moved,deceased',
        ], [
            // User validation messages
            'name.required' => 'Nama harus diisi',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            
            // Resident validation messages
            'nik.required' => 'NIK harus diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nik.unique' => 'NIK sudah digunakan untuk registrasi akun. Satu NIK hanya bisa registrasi 1 kali',
            'family_card_number.required' => 'Nomor KK harus diisi',
            'family_card_number.size' => 'Nomor KK harus 16 digit',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'birth_date.required' => 'Tanggal lahir harus diisi',
            'birth_place.required' => 'Tempat lahir harus diisi',
            'address.required' => 'Alamat harus diisi',
            'hamlet.required' => 'Dusun harus diisi',
            'religion.required' => 'Agama harus dipilih',
            'marital_status.required' => 'Status perkawinan harus dipilih',
            'occupation.required' => 'Pekerjaan harus diisi',
            'phone.required' => 'No. telepon harus diisi',
            'phone.max' => 'No. telepon maksimal 15 karakter',
            'status.required' => 'Status penduduk harus dipilih',
        ]);
        
        // Create User Account
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'nik' => $validated['nik'],
            'password' => bcrypt($validated['password']),
            'role' => 'user',
            'is_approved' => false, // Menunggu verifikasi admin
        ]);
        
        // Cek apakah NIK sudah ada di data penduduk
        $existingResident = \App\Models\Resident::where('nik', $validated['nik'])->first();
        
        if ($existingResident) {
            // Jika NIK sudah ada di data penduduk, update data dan link ke user
            $existingResident->update([
                'user_id' => $user->id,
                'family_card_number' => $validated['family_card_number'] ?? $existingResident->family_card_number,
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'birth_date' => $validated['birth_date'],
                'birth_place' => $validated['birth_place'],
                'address' => $validated['address'],
                'hamlet' => $validated['hamlet'],
                'religion' => $validated['religion'],
                'marital_status' => $validated['marital_status'],
                'occupation' => $validated['occupation'],
                'phone' => $validated['phone'],
                'status' => $validated['status'],
            ]);
            $resident = $existingResident;
        } else {
            // Jika NIK belum ada, create data penduduk baru
            $resident = \App\Models\Resident::create([
                'user_id' => $user->id,
                'nik' => $validated['nik'],
                'family_card_number' => $validated['family_card_number'],
                'name' => $validated['name'],
                'gender' => $validated['gender'],
                'birth_date' => $validated['birth_date'],
                'birth_place' => $validated['birth_place'],
                'address' => $validated['address'],
                'hamlet' => $validated['hamlet'],
                'religion' => $validated['religion'],
                'marital_status' => $validated['marital_status'],
                'occupation' => $validated['occupation'],
                'phone' => $validated['phone'],
                'status' => $validated['status'],
            ]);
        }
        
        // Auto-manage family data berdasarkan No. KK
        if ($validated['family_card_number']) {
            $this->manageFamily($resident);
        }
        
        // Tidak langsung login, user perlu diverifikasi dulu
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Akun Anda menunggu verifikasi dari administrator dan silahkan cek email secara berkala untuk pemberitahuan aktivasi akun.');
    }
    
    private function manageFamily($resident)
    {
        // Cek apakah keluarga dengan No. KK ini sudah ada
        $family = \App\Models\Family::where('kk', $resident->family_card_number)->first();
        
        if (!$family) {
            // Jika belum ada, buat data keluarga baru
            // Cari kepala keluarga (biasanya yang pertama atau status Married/Male)
            $headResident = \App\Models\Resident::where('family_card_number', $resident->family_card_number)
                ->where('gender', 'Male')
                ->where('marital_status', 'Married')
                ->first() ?? $resident;
            
            // Hitung total anggota keluarga
            $totalMembers = \App\Models\Resident::where('family_card_number', $resident->family_card_number)->count();
            
            \App\Models\Family::create([
                'kk' => $resident->family_card_number,
                'head_name' => $headResident->name,
                'head_nik' => $headResident->nik,
                'hamlet' => $resident->hamlet,
                'address' => $resident->address,
                'total_members' => $totalMembers,
            ]);
        } else {
            // Jika sudah ada, update jumlah anggota
            $totalMembers = \App\Models\Resident::where('family_card_number', $resident->family_card_number)->count();
            $family->update(['total_members' => $totalMembers]);
        }
    }
    
    // Forgot Password Methods
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }
    
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar dalam sistem'
        ]);
        
        // Generate token
        $token = \Illuminate\Support\Str::random(64);
        
        // Delete old tokens for this email
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();
        
        // Insert new token
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => \Illuminate\Support\Facades\Hash::make($token),
            'created_at' => now()
        ]);
        
        // Create reset link
        $resetLink = route('password.reset', ['token' => $token, 'email' => $request->email]);
        
        // Get user
        $user = \App\Models\User::where('email', $request->email)->first();
        
        // Send email notification
        try {
            $user->notify(new ResetPasswordNotification($resetLink, $user->name));
            return back()->with('status', 'Link reset password telah dikirim ke email Anda. Silakan cek inbox atau folder spam.');
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to send reset password email: ' . $e->getMessage());
            // Fallback: show link if email fails
            return back()->with('status', 'Link reset password: ' . $resetLink . ' (Email gagal dikirim, gunakan link ini untuk reset password)');
        }
    }
    
    public function showResetPassword(Request $request, $token)
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->email
        ]);
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.exists' => 'Email tidak terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok'
        ]);
        
        // Check if token exists and not expired (24 hours)
        $passwordReset = \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();
        
        if (!$passwordReset) {
            return back()->withErrors(['email' => 'Token reset password tidak valid atau sudah expired']);
        }
        
        // Check if token expired (24 hours)
        if (now()->diffInHours($passwordReset->created_at) > 24) {
            \Illuminate\Support\Facades\DB::table('password_reset_tokens')
                ->where('email', $request->email)
                ->delete();
            return back()->withErrors(['email' => 'Token reset password sudah expired. Silakan request ulang.']);
        }
        
        // Update user password
        $user = \App\Models\User::where('email', $request->email)->first();
        $user->update([
            'password' => bcrypt($request->password)
        ]);
        
        // Delete token
        \Illuminate\Support\Facades\DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->delete();
        
        return redirect()->route('login')->with('success', 'Password berhasil direset! Silakan login dengan password baru Anda.');
    }
    
    private function redirectBasedOnRole($user)
    {
        if ($user->role === 'admin') {
            return redirect()->intended(route('dashboard'))
                ->with('success', 'Selamat datang, Admin ' . $user->name . '!');
        }
        
        // User biasa redirect ke homepage frontend
        return redirect()->intended(route('home'))
            ->with('success', 'Selamat datang, ' . $user->name . '!');
    }
}
