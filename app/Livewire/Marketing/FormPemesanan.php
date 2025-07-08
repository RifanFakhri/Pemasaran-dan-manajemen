<?php

namespace App\Livewire\Marketing;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Pemesanan;
use App\Models\Rumah;
use App\Models\Blok;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class FormPemesanan extends Component
{
    use WithFileUploads;

    public $blok_id, $rumah_id, $customer_id, $jenis_pembayaran, $tanggal_pesan;
    public $status_transaksi, $lama_angsuran;
    public $uang_booking = 1000000, $uang_muka = 0;
    public $bukti_booking, $bukti_dp;
    public $daftarBlok = [], $daftarCustomer = [], $daftarRumah = [];

    protected $messages = [
        'blok_id.required' => 'Blok harus dipilih.',
        'rumah_id.required' => 'Rumah harus dipilih.',
        'customer_id.required' => 'Customer harus dipilih.',
        'jenis_pembayaran.required' => 'Jenis pembayaran harus dipilih.',
        'tanggal_pesan.required' => 'Tanggal pemesanan harus diisi.',
        'status_transaksi.required' => 'Status transaksi harus diisi.',
        'lama_angsuran.in' => 'Lama angsuran tidak valid.',
        'lama_angsuran.required' => 'Lama angsuran wajib diisi untuk KPR.',
        'bukti_booking.required' => 'Bukti booking wajib diupload.',
        'bukti_booking.file' => 'Bukti booking harus berupa file.',
        'bukti_booking.mimes' => 'Bukti booking harus berupa jpg, png, atau pdf.',
        'bukti_booking.max' => 'Ukuran bukti booking maksimal 2MB.',
        'bukti_dp.file' => 'Bukti DP harus berupa file.',
        'bukti_dp.mimes' => 'Bukti DP harus berupa jpg, png, atau pdf.',
        'bukti_dp.max' => 'Ukuran bukti DP maksimal 2MB.',
    ];

    public function mount()
    {
        $this->daftarBlok = Blok::all();
        $this->daftarCustomer = Customer::whereIn('status', ['baru', 'follow_up'])->get();

        if ($this->daftarBlok->isNotEmpty()) {
            $this->blok_id = $this->daftarBlok->first()->id;
            $this->daftarRumah = Rumah::where('blok_id', $this->blok_id)
                ->where('status', '!=', 'terjual')
                ->get();
        }
    }

    public function updatedBlokId($value)
    {
        $this->rumah_id = null;
        $this->daftarRumah = Rumah::where('blok_id', $value)
            ->where('status', '!=', 'terjual')
            ->get();
    }

    public function updatedRumahId($value)
    {
        $rumah = Rumah::find($value);

        if ($rumah) {
            $this->uang_muka = $rumah->harga * 0.10;
            $this->uang_booking = 1000000;
        }
    }

    public function removeBuktiBooking()
    {
        $this->reset('bukti_booking');
        $this->resetErrorBag('bukti_booking');
    }

    public function removeBuktiDp()
    {
        $this->reset('bukti_dp');
        $this->resetErrorBag('bukti_dp');
    }

    public function submit()
{
    $rules = [
        'blok_id' => 'required|exists:bloks,id',
        'rumah_id' => 'required|exists:rumah,id',
        'customer_id' => 'required|exists:customers,id',
        'jenis_pembayaran' => 'required|in:KPR,Cash',
        'tanggal_pesan' => 'required|date',
        'status_transaksi' => 'required|in:lunas,belum',
        'uang_muka' => 'required|numeric',
        'uang_booking' => 'required|numeric',
        'bukti_booking' => 'required|file|mimes:jpg,png,pdf|max:2048',
    ];

    if ($this->jenis_pembayaran === 'KPR') {
        $rules['lama_angsuran'] = 'required|in:10,15,20,25';
    }

    // Default: bukti_dp nullable
    $rules['bukti_dp'] = 'nullable|file|mimes:jpg,png,pdf|max:2048';

    $this->validate($rules, $this->messages);

    // Tambahan validasi manual jika status_transaksi lunas
    if ($this->status_transaksi === 'lunas' && !$this->bukti_dp) {
        $this->addError('bukti_dp', 'Bukti DP wajib diupload jika status lunas.');
        return;
    }

    try {
        $today = now()->format('Ymd');
        $countToday = Pemesanan::whereDate('created_at', now()->toDateString())->count() + 1;
        $invoice = 'GTR-' . $today . '-' . str_pad($countToday, 3, '0', STR_PAD_LEFT);

        $customer = Customer::find($this->customer_id);

        $uploadDir = 'bukti_pembayaran';
        if (!Storage::disk('public')->exists($uploadDir)) {
            Storage::disk('public')->makeDirectory($uploadDir);
        }

        $buktiBookingPath = $this->bukti_booking->storeAs(
            $uploadDir,
            'booking_' . $invoice . '.' . $this->bukti_booking->getClientOriginalExtension(),
            'public'
        );

        $buktiDpPath = null;
        if ($this->bukti_dp) {
            $buktiDpPath = $this->bukti_dp->storeAs(
                $uploadDir,
                'dp_' . $invoice . '.' . $this->bukti_dp->getClientOriginalExtension(),
                'public'
            );
        }

        $pemesanan = Pemesanan::create([
            'invoice' => $invoice,
            'rumah_id' => $this->rumah_id,
            'customer_id' => $this->customer_id,
            'jenis_pembayaran' => $this->jenis_pembayaran,
            'tanggal_pesan' => $this->tanggal_pesan,
            'status_transaksi' => $this->status_transaksi,
            'lama_angsuran' => $this->jenis_pembayaran === 'KPR' ? $this->lama_angsuran : null,
            'uang_booking' => $this->uang_booking,
            'uang_muka' => $this->uang_muka,
            'bukti_booking' => $buktiBookingPath,
            'bukti_dp' => $buktiDpPath,
            'created_by' => Auth::id(),
        ]);

        $customer->status = $this->status_transaksi === 'lunas' ? 'pembeli' : 'booking';
        $customer->save();

        $rumah = Rumah::find($this->rumah_id);
        if ($rumah) {
            $rumah->status = $this->status_transaksi === 'lunas' ? 'terjual' : 'booking';
            $rumah->save();
        }

        $this->reset([
            'rumah_id', 'customer_id', 'jenis_pembayaran',
            'tanggal_pesan', 'status_transaksi', 'lama_angsuran',
            'uang_booking', 'uang_muka', 'bukti_booking', 'bukti_dp'
        ]);

        $this->dispatch('tambah-transaksi');
        session()->flash('success', 'Pemesanan berhasil dibuat!');

    } catch (\Exception $e) {
        session()->flash('error', 'Gagal menyimpan pemesanan: ' . $e->getMessage());
        logger()->error('Pemesanan error: ' . $e->getMessage());
    }
}

    public function render()
    {
        return view('livewire.marketing.form-pemesanan', [
            'daftarBlok' => $this->daftarBlok,
            'daftarCustomer' => $this->daftarCustomer,
            'daftarRumah' => $this->daftarRumah,
        ])->layout('layouts.marketing');
    }
}