<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\KprController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MarketingController;

// Livewire Admin
use App\Livewire\Admin\ManageBloks as AdminManageBloks;
use App\Livewire\Admin\RumahList as AdminRumahList;
use App\Livewire\Admin\CustomerList as AdminCustomerList;
use App\Livewire\Admin\CustomerForm as AdminCustomerForm;
use App\Livewire\Admin\EditCustomer as AdminEditCustomer;
use App\Livewire\Admin\TambahUser as AdminTambahUser;
use App\Livewire\Admin\FormPemesanan as AdminFormPemesanan;
use App\Livewire\Admin\DataTransaksi as AdminDataTransaksi;
use App\Livewire\Admin\DataPembeli as AdminDataPembeli;
use App\Livewire\Admin\EditTransaksi as AdminEditTransaksi;
use App\Livewire\Admin\UserTable as AdminUserTable;
use App\Livewire\Admin\PerformaStaf as AdminPerformaStaf;
use App\Livewire\Admin\LaporanTransaksi as AdminLaporanTransaksi;
use App\Livewire\Admin\BerkasKprForm as AdminBerkasKprForm;
use App\Livewire\Admin\BerkasKprTable as AdminBerkasKprTable;
use App\Livewire\Admin\BerkasKprEdit as AdminBerkasKprEdit;

// Livewire Marketing
use App\Livewire\Marketing\ManageBloks as MarketingManageBloks;
use App\Livewire\Marketing\RumahList as MarketingRumahList;
use App\Livewire\Marketing\CustomerList as MarketingCustomerList;
use App\Livewire\Marketing\CustomerForm as MarketingCustomerForm;
use App\Livewire\Marketing\EditCustomer as MarketingEditCustomer;
use App\Livewire\Marketing\TambahUser as MarketingTambahUser;
use App\Livewire\Marketing\FormPemesanan as MarketingFormPemesanan;
use App\Livewire\Marketing\DataTransaksi as MarketingDataTransaksi;
use App\Livewire\Marketing\DataPembeli as MarketingDataPembeli;
use App\Livewire\Marketing\EditTransaksi as MarketingEditTransaksi;
use App\Livewire\Marketing\LaporanTransaksi as MarketingLaporanTransaksi;
use App\Livewire\Marketing\BerkasKprForm as MarketingBerkasKprForm;
use App\Livewire\Marketing\BerkasKprTable as MarketingBerkasKprTable;
use App\Livewire\Marketing\BerkasKprEdit as MarketingBerkasKprEdit;

// Homepage
Route::get('/', [KprController::class, 'index'])->name('home');
Route::get('/simulasi-kpr', [KprController::class, 'home'])->name('kpr.index');
Route::get('/detail-properti', function () {
    return view('detail');
})->name('detail');

// Login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'Login']);

// Group route untuk Admin dengan middleware dan prefix
Route::middleware(['admin.only'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.user');
    Route::get('/performa-staf', AdminPerformaStaf::class)->name('admin.performa-staf');
    Route::get('/detail-blok/{blokId}', AdminRumahList::class)->name('admin.detailBlok');
    Route::get('/data-customer', AdminCustomerForm::class)->name('admin.tambahPengguna');
    Route::get('/laporan-transaksi', AdminLaporanTransaksi::class)->name('admin.laporan-transaksi');
    Route::get('/tambah-berkas', AdminBerkasKprForm::class)->name('admin.tambah-berkas');
    Route::get('/berkas', AdminBerkasKprTable::class)->name('admin.data-berkas');
    Route::get('/customer/edit/{id}', AdminEditCustomer::class)->name('admin.editCustomer');
    Route::get('/tambah-user', AdminTambahUser::class)->name('admin.tambah-user');
    Route::get('/tambah-transaksi', AdminFormPemesanan::class)->name('admin.tambah-transaksi');
    Route::get('/data-transaksi', AdminDataTransaksi::class)->name('admin.data-transaksi');
    Route::get('/data-pembeli', AdminDataPembeli::class)->name('admin.data-pembeli');
    Route::get('/edit-transaksi/edit/{id}', AdminEditTransaksi::class)->name('admin.edit-transaksi');
    Route::get('/edit-berkas/edit/{id}', AdminBerkasKprEdit::class)->name('admin.edit-berkas');
    Route::get('/users/edit/{id}', [AdminController::class, 'editUser'])->name('admin.edit-user');
    Route::post('/users/update/{id}', [AdminController::class, 'updateUser'])->name('admin.update-user');
    Route::delete('/users/delete/{id}', [AdminController::class, 'deleteUser'])->name('admin.delete-user');
    Route::delete('/berkas-kpr/{id}', [AdminController::class, 'destroy'])->name('berkas-kpr.destroy');
    Route::get('/bloks', AdminManageBloks::class)->name('admin.rumah');
    Route::get('/customers', AdminCustomerList::class)->name('admin.dataCustomer');
    Route::get('/admin/transaksi/cetak/{id}', [AdminController::class, 'cetak'])->name('admin.surat_keterangan_penjual');

    
});

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// Group route untuk Marketing dengan middleware dan prefix
Route::middleware(['auth','marketing.only'])->prefix('marketing')->group(function () {
    Route::get('/dashboard', [MarketingController::class, 'index'])->name('marketing.index');

    Route::get('/manage-bloks', MarketingManageBloks::class)->name('marketing.rumah');
    Route::get('/detail-blok/{blokId}', MarketingRumahList::class)->name('marketing.detailBlok');
    Route::get('/data-customer', MarketingCustomerForm::class)->name('marketing.tambahPengguna');
    Route::get('/customer/edit/{id}', MarketingEditCustomer::class)->name('marketing.editCustomer');
    Route::get('/tambah-transaksi', MarketingFormPemesanan::class)->name('marketing.tambah-transaksi');
    Route::get('/data-transaksi', MarketingDataTransaksi::class)->name('marketing.data-transaksi');
    Route::get('/data-pembeli', MarketingDataPembeli::class)->name('marketing.data-pembeli');
    Route::get('/edit-transaksi/edit/{id}', MarketingEditTransaksi::class)->name('marketing.edit-transaksi');
    Route::get('/customers', MarketingCustomerList::class)->name('marketing.dataCustomer');
    Route::get('/laporanTransaksi', MarketingLaporanTransaksi::class)->name('marketing.laporan-transaksi');
    Route::get('/tambah-berkas', MarketingBerkasKprForm::class)->name('marketing.tambah-berkas');
    Route::get('/berkas', MarketingBerkasKprTable::class)->name('marketing.data-berkas');
    Route::get('/edit-berkas/edit/{id}', MarketingBerkasKprEdit::class)->name('marketing.edit-berkas');
    Route::get('/marketing/transaksi/cetak/{id}', [MarketingController::class, 'cetak'])->name('marketing.surat_keterangan_penjual');
});
