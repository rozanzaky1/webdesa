<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $validated = $request->validate([
            // Data User & Akun
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            
            // Data Resident/Kependudukan
            'nik' => 'required|string|size:16|unique:residents,nik',
            'family_card_number' => 'nullable|string|max:16',
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
            'nik.unique' => 'NIK sudah terdaftar',
            'gender.required' => 'Jenis kelamin harus dipilih',
            'birth_date.required' => 'Tanggal lahir harus diisi',
            'birth_place.required' => 'Tempat lahir harus diisi',
            'address.required' => 'Alamat harus diisi',
            'hamlet.required' => 'Dusun harus diisi',
            'religion.required' => 'Agama harus dipilih',
            'marital_status.required' => 'Status perkawinan harus dipilih',
            'occupation.required' => 'Pekerjaan harus diisi',
            'phone.required' => 'No. telepon harus diisi',
            'status.required' => 'Status penduduk harus dipilih',
        ]);
        
        // Create User Account
        $user = \App\Models\User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => 'user',
            'is_approved' => false, // Menunggu verifikasi admin
        ]);
        
        // Create Resident Data (linked to user)
        \App\Models\Resident::create([
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
        
        // Tidak langsung login, user perlu diverifikasi dulu
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Akun Anda menunggu verifikasi dari administrator. Data kependudukan Anda telah tersimpan dan akan muncul di dashboard admin.');
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
