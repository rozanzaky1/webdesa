<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AccountApprovedNotification;
use App\Services\WhatsAppService;

class UserVerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with('resident')->where('role', 'user');
        
        // Filter berdasarkan status
        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('is_approved', false);
            } elseif ($request->status === 'approved') {
                $query->where('is_approved', true);
            }
        }
        // Jika tidak ada filter status, tampilkan semua user
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }
        
        // Load all data for client-side search and pagination
        $users = $query->orderBy('is_approved', 'asc')->orderBy('created_at', 'desc')->get();
        
        // Count statistics
        $stats = [
            'pending' => User::where('role', 'user')->where('is_approved', false)->count(),
            'approved' => User::where('role', 'user')->where('is_approved', true)->count(),
            'total' => User::where('role', 'user')->count(),
        ];
        
        return view('pages.user-verification.index', compact('users', 'stats'));
    }
    
    public function approve($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak bisa mengubah status admin!');
        }
        
        $user->update([
            'is_approved' => true,
            'approved_at' => now(),
            'approved_by' => Auth::id(),
        ]);
        
        // Kirim notifikasi WhatsApp ke user
        try {
            $whatsapp = new WhatsAppService();
            $sent = $whatsapp->sendAccountApproval($user);
            
            if ($sent) {
                return redirect()->back()->with('success', 'User ' . $user->name . ' berhasil disetujui dan notifikasi WhatsApp telah dikirim!');
            } else {
                return redirect()->back()->with('success', 'User ' . $user->name . ' berhasil disetujui! (Notifikasi WhatsApp gagal dikirim)');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('success', 'User ' . $user->name . ' berhasil disetujui! (Notifikasi WhatsApp gagal: ' . $e->getMessage() . ')');
        }
    }
    
    public function reject($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak bisa mengubah status admin!');
        }
        
        $user->update([
            'is_approved' => false,
            'approved_at' => null,
            'approved_by' => null,
        ]);
        
        return redirect()->back()->with('success', 'User ' . $user->name . ' ditolak/dibatalkan!');
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->role === 'admin') {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun admin!');
        }
        
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        
        $userName = $user->name;
        $user->delete();
        
        return redirect()->back()->with('success', 'User ' . $userName . ' berhasil dihapus!');
    }
}
