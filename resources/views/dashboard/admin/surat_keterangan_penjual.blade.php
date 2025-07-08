<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keterangan Penjual</title>
    <style>
        body { font-family: 'Times New Roman', Times, serif; font-size: 14pt; line-height: 1.8; margin: 40px; }
        table { width: 100%; }
        .center { text-align: center; }
        .signature { margin-top: 20px; }
    </style>
</head>
<body onload="window.print()">

    <div class="center">
        <h3>SURAT KETERANGAN PENJUAL</h3>
    </div>

    <p>Yang bertanda tangan dibawah ini :</p>
    <table>
        <tr><td>Nama</td><td>: Rafid Endika</td></tr>
        <tr><td>Jabatan</td><td>: Marketing</td></tr>
        <tr><td>Developer/Pengembang</td><td>: PT. SINAR DINAMIKA KARYA</td></tr>
        <tr><td>Perumahan</td><td>: GRAND TELAR RESIDENCE</td></tr>
    </table>

    <p>Melakukan penjualan atas tanah dan bangunan kepada pembeli dengan data berikut :</p>
    <table>
        <tr><td>Nama Pembeli</td><td>: {{ strtoupper($pemesanan->customer->nama ?? '-') }}</td></tr>
        <tr><td>Blok/Kavling</td><td>: {{ $pemesanan->rumah->nomor_rumah ?? '-' }}</td></tr>
        <tr><td>Type / Luas Tanah</td><td>: 36 / 72</td></tr>
        <tr><td>Harga Jual</td><td>: Rp. {{ number_format($pemesanan->rumah->harga ?? 0, 0, ',', '.') }}</td></tr>
        <tr><td>KPR</td>
            <td>: Rp. 
                {{ number_format(($pemesanan->rumah->harga ?? 0) - ($pemesanan->uang_muka ?? 0), 0, ',', '.') }}
            </td>
        </tr>
        <tr><td>Uang Muka</td><td>: Rp. {{ number_format($pemesanan->uang_muka ?? 0, 0, ',', '.') }}</td></tr>
    </table>

    <p>Demikian surat keterangan ini dibuat dengan sebenarnya dan untuk dipergunakan sebagaimana mestinya.</p>

    <table class="signature">
        <tr>
            <td width="50%" class="center">PEMBELI<br><br><br><br><u>{{ strtoupper($pemesanan->customer->nama ?? '-') }}</u></td>
            <td width="50%" class="center">Bekasi, {{ \Carbon\Carbon::parse($pemesanan->tanggal_pesan)->translatedFormat('d F Y') }}<br>PT. SINAR DINAMIKA KARYA<br><br><br><br><u>Rafid Endika</u><br>Marketing</td>
        </tr>
    </table>

</body>
</html>
