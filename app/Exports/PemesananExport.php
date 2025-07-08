<?php

namespace App\Exports;

use App\Models\Pemesanan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PemesananExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $statusFilter;
    protected $jenisPembayaranFilter;
    protected $searchTerm;

    public function __construct($startDate, $endDate, $statusFilter, $jenisPembayaranFilter, $searchTerm)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->statusFilter = $statusFilter;
        $this->jenisPembayaranFilter = $jenisPembayaranFilter;
        $this->searchTerm = $searchTerm;
    }

    public function collection()
    {
        $query = Pemesanan::with(['customer', 'rumah'])
            ->when($this->startDate, function ($query) {
                return $query->where('tanggal_pesan', '>=', $this->startDate);
            })
            ->when($this->endDate, function ($query) {
                return $query->where('tanggal_pesan', '<=', $this->endDate);
            })
            ->when($this->statusFilter, function ($query) {
                return $query->where('status_transaksi', $this->statusFilter);
            })
            ->when($this->jenisPembayaranFilter, function ($query) {
                return $query->where('jenis_pembayaran', $this->jenisPembayaranFilter);
            })
            ->when($this->searchTerm, function ($query) {
                return $query->where(function ($q) {
                    $q->where('invoice', 'like', '%'.$this->searchTerm.'%')
                      ->orWhereHas('customer', function ($q) {
                          $q->where('nama', 'like', '%'.$this->searchTerm.'%');
                      });
                });
            })
            ->orderBy('tanggal_pesan', 'desc')
            ->get();

        return $query;
    }

    public function headings(): array
    {
        return [
            'Invoice',
            'Tanggal Pesan',
            'Nama Customer',
            'Nomor Rumah',
            'Jenis Pembayaran',
            'Uang Booking',
            'Uang Muka',
            'Lama Angsuran',
            'Status Transaksi',
            'Keterangan'
        ];
    }

    public function map($pemesanan): array
    {
        return [
            $pemesanan->invoice,
            $pemesanan->tanggal_pesan,
            $pemesanan->customer->nama,
            $pemesanan->rumah->nomor_rumah,
            ucfirst($pemesanan->jenis_pembayaran),
            $pemesanan->uang_booking,
            $pemesanan->uang_muka,
            $pemesanan->lama_angsuran,
            ucfirst($pemesanan->status_transaksi),
            $pemesanan->keterangan
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => ['font' => ['bold' => true]],
            
            // Set header row background color
            'A1:J1' => ['fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => 'D9E1F2']]],
            
            // Set border for all cells
            'A1:J'.$sheet->getHighestRow() => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => 'thin',
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}