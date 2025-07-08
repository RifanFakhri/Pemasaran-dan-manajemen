<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Rumah;
use App\Models\BerkasKpr;
use App\Models\Pemesanan;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Membatasi akses ke admin hanya untuk yang sudah login
    }

    // Tampilkan halaman dashboard admin
    public function index()
    {
        return view('dashboard.admin.index');
    }
    
    public function cetak($id)
        {
            $pemesanan = Pemesanan::with(['customer', 'rumah'])->findOrFail($id);

            return view('dashboard.admin.surat_keterangan_penjual', [
                'pemesanan' => $pemesanan,
            ]);
        }
    

    // Tampilkan halaman tabel pengguna
    public function users()
    {
        return view('dashboard.admin.user-table');
    }

    public function tambahPengguna()
    {
        return view('dashboard.admin.tambahPengguna'); 
    }
        public function editUser($id)
    {
        $users = User::findOrFail($id);
        return view('dashboard.admin.edit-user', compact('users'));
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'role' => 'required|in:admin,marketing',
        ]);

        $users = User::findOrFail($id);
        $users->update([
            'name' => $request->name,
            'username' => $request->username,
            'role' => $request->role,
        ]);

        return redirect()->route('admin.user')->with('success', 'User updated successfully.');
        $this->dispatchBrowserEvent('user-updated');
    }

    public function deleteUser($id)
    {
        $users = User::findOrFail($id);
        $users->delete();

        return redirect()->route('admin.user')->with('success', 'User deleted successfully.');
    }

    public function destroy($id)
{
    try {
        $berkas = BerkasKpr::findOrFail($id);
        $berkas->delete();
        
        return redirect()->back()
               ->with('success', 'Data berhasil dihapus.');
               
    } catch (\Exception $e) {
        return redirect()->back()
               ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
    }
}
    
}
