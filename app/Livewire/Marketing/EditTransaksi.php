<?php

namespace App\Livewire\marketing;

use Livewire\Component;
use App\Models\Pemesanan;
use App\Models\Customer;
use App\Models\Rumah;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class EditTransaksi extends Component
{
    use WithFileUploads;

    public $transaksiId;
    public $invoice;
    public $rumah_id;
    public $customer_id;
    public $jenis_pembayaran;
    public $tanggal_pesan;
    public $status_transaksi;
    public $lama_angsuran;
    public $status;
    
    // Untuk file upload
    public $bukti_booking;
    public $bukti_booking_path;
    public $bukti_dp;
    public $bukti_dp_path;

    public function mount($id)
    {
        $transaksi = Pemesanan::findOrFail($id);

        $this->transaksiId       = $transaksi->id;
        $this->invoice           = $transaksi->invoice;
        $this->rumah_id          = $transaksi->rumah_id;
        $this->customer_id       = $transaksi->customer_id;
        $this->jenis_pembayaran  = $transaksi->jenis_pembayaran;
        $this->tanggal_pesan     = $transaksi->tanggal_pesan;
        $this->status_transaksi  = $transaksi->status_transaksi;
        $this->lama_angsuran     = $transaksi->lama_angsuran;
        $this->bukti_booking_path = $transaksi->bukti_booking;
        $this->bukti_dp_path      = $transaksi->bukti_dp;

        $customer = Customer::find($this->customer_id);
        $this->status = $customer?->status ?? null;
    }

    public function removeBuktiBooking()
    {
        Storage::disk('public')->delete($this->bukti_booking_path);
        $this->bukti_booking_path = null;
        Pemesanan::find($this->transaksiId)->update(['bukti_booking' => null]);
    }

    public function removeBuktiDp()
    {
        Storage::disk('public')->delete($this->bukti_dp_path);
        $this->bukti_dp_path = null;
        Pemesanan::find($this->transaksiId)->update(['bukti_dp' => null]);
    }

    public function update()
{
    // Normalisasi
    $this->jenis_pembayaran = strtolower($this->jenis_pembayaran);
    if ($this->jenis_pembayaran === 'cash') {
        $this->lama_angsuran = null;
    }

    // Validasi dasar
    $this->validate([
        'invoice'           => 'required|string',
        'rumah_id'          => 'required|integer',
        'customer_id'       => 'required|integer',
        'jenis_pembayaran'  => 'required|in:kpr,cash',
        'tanggal_pesan'     => 'required|date',
        'status_transaksi'  => 'required|in:lunas,belum,cancelled',
        'lama_angsuran'     => 'nullable|integer|min:0',
        'status'            => 'required|in:pembeli,booking,cancelled',
        'bukti_booking'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        'bukti_dp'          => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
    ]);

    // Validasi tambahan: jika status lunas tapi tidak ada bukti dp sama sekali
    if ($this->status_transaksi === 'lunas' && !$this->bukti_dp && !$this->bukti_dp_path) {
        $this->addError('bukti_dp', 'Bukti DP wajib diupload jika status lunas.');
        return;
    }

    $data = [
        'invoice'           => $this->invoice,
        'rumah_id'          => $this->rumah_id,
        'customer_id'       => $this->customer_id,
        'jenis_pembayaran'  => $this->jenis_pembayaran,
        'tanggal_pesan'     => $this->tanggal_pesan,
        'status_transaksi'  => $this->status_transaksi,
        'lama_angsuran'     => $this->lama_angsuran,
        'status'            => $this->status,
    ];

    $uploadDir = 'bukti_pembayaran';
    if (!Storage::disk('public')->exists($uploadDir)) {
        Storage::disk('public')->makeDirectory($uploadDir);
    }

    // Upload bukti booking
    if ($this->bukti_booking) {
        if ($this->bukti_booking_path) {
            Storage::disk('public')->delete($this->bukti_booking_path);
        }

        $buktiBookingPath = $this->bukti_booking->storeAs(
            $uploadDir,
            'booking_' . $this->invoice . '.' . $this->bukti_booking->getClientOriginalExtension(),
            'public'
        );
        $data['bukti_booking'] = $buktiBookingPath;
    }

    // Upload bukti DP
    if ($this->status_transaksi === 'lunas' && $this->bukti_dp) {
        if ($this->bukti_dp_path) {
            Storage::disk('public')->delete($this->bukti_dp_path);
        }

        $buktiDpPath = $this->bukti_dp->storeAs(
            $uploadDir,
            'dp_' . $this->invoice . '.' . $this->bukti_dp->getClientOriginalExtension(),
            'public'
        );
        $data['bukti_dp'] = $buktiDpPath;
    } elseif ($this->status_transaksi !== 'lunas' && $this->bukti_dp_path) {
        Storage::disk('public')->delete($this->bukti_dp_path);
        $data['bukti_dp'] = null;
    }

    // Update transaksi
    $transaksi = Pemesanan::findOrFail($this->transaksiId);
    $transaksi->update($data);

    // Update rumah
    $rumah = Rumah::find($this->rumah_id);
    $rumah->status = $this->status === 'cancelled' ? 'tersedia' : ($this->status_transaksi === 'lunas' ? 'terjual' : 'booking');
    $rumah->save();

    // Update customer
    $customer = Customer::find($this->customer_id);
    $customer->status = $this->status;
    $customer->save();

    $this->reset(['bukti_booking', 'bukti_dp']);

    $this->dispatch('transaction-updated');
}

    public function render()
    {
        return view('livewire.marketing.edit-transaksi', [
            'customers' => Customer::all(),
            'rumah'     => Rumah::all(),
        ])->layout('layouts.marketing');
    }
}