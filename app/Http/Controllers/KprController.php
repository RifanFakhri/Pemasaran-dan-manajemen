<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class KprController extends Controller
{
    public function index()
    {
        $banks = [
            [
                'name' => 'KPR Bank Mandiri',
                'description' => 'Lihat lebih lengkap persyaratan serta bunga tahunan mengenai rencana KPR melalui bank Mandiri.',
                'link' => 'https://www.bankmandiri.co.id/kpr',
            ],
            [
                'name' => 'KPR Bank BTN',
                'description' => 'Lihat lebih lengkap persyaratan serta bunga tahunan mengenai rencana KPR melalui bank BTN.',
                'link' => 'https://www.btnproperti.co.id/',
            ],
            [
                'name' => 'KPR Bank BRI',
                'description' => 'Lihat lebih lengkap persyaratan serta bunga tahunan mengenai rencana KPR melalui bank BRI.',
                'link' => 'https://bri.co.id/kpr',
            ],
            [
                'name' => 'KPR Bank BSI',
                'description' => 'Lihat lebih lengkap persyaratan serta bunga tahunan mengenai rencana KPR melalui bank BSI.',
                'link' => 'https://www.bankbsi.co.id/produk&layanan/tipe/individu/parent/produk/bsi-griya',
            ],
            
        ];
    
        $faqs = [
            ['question' => 'Dimana letak perumahan Grand Telar Residence?', 'answer' => 'Grand Telar Residence terletak di Muktiwari, Cibitung.'],
            ['question' => 'Pembayaran apa saja yang bisa dilakukan saat membeli rumah?', 'answer' => 'Pembayaran dapat dilakukan melalui KPR, cash keras, atau cicilan bertahap.'],
            ['question' => 'Perusahaan mana yang mengembangkan perumahan Grand Telar Residence?', 'answer' => 'Perusahaan yang mengembangkan adalah PT. Sinar Dinamika Karya.'],
            ['question' => 'Apakah rumah di Grand Telar Residence cocok untuk keluarga?', 'answer' => 'Sangat cocok, karena lingkungan nyaman dan dekat fasilitas umum.'],
            ['question' => 'Berapa harga rumah di Grand Telar Residence?', 'answer' => 'Harga rumah mulai dari Rp425 juta, tergantung Blok rumah.'],
        ];
    
        $places = [
            ['image' => 'img/sd.jpg', 'distance' => '0,38 KM', 'name' => 'SD Negeri Mukti Wari'],
            ['image' => 'img/sma.jpg', 'distance' => '0,96 KM', 'name' => 'SMA Negeri 4 Tambun Selatan'],
            ['image' => 'img/smp.jpg', 'distance' => '1,19 KM', 'name' => 'SMP Negeri 5 Tambun Selatan'],
            ['image' => 'img/alfa.jpg', 'distance' => '2,4 KM', 'name' => 'Alfamidi Griya Asri'],
            ['image' => 'img/permata.png', 'distance' => '4,54 KM', 'name' => 'RS Permata Bunda'],
        ];
    
        return view('index', compact('banks', 'faqs', 'places'));
    }
    
}
