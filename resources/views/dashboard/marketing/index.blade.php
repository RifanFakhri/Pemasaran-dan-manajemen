@extends('layouts.dashboard')

@section('content')
 <div class="left-6  ml-8 top-6"> 
    <h1 class="text-lg sm:text-xl font-bold text-gray-800 mb-1">
        Welcome Back, {{ Auth::user()->name }}!
    </h1>
    <p class="text-sm text-gray-500">
        {{ now()->format('d F Y | h.iA') }} WIB
    </p>
</div>
<div class="w-full px-6 py-6 mx-auto">
    <!-- row 1 -->
    <div class="flex flex-wrap -mx-3">
      
      <!-- card1 -->
      @php
      $jumlahTerjual = \App\Models\Rumah::where('status', 'terjual')->count();
      $jumlahTersedia = \App\Models\Rumah::where('status', 'tersedia')->count();
      $jumlahBooking = \App\Models\customer::where('status', 'booking')->count();
      $jumlahCancelled = \App\Models\customer::where('status', 'cancelled')->count();
      @endphp

        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Rumah Terjual</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $jumlahTerjual }}
                                    <span class="leading-normal text-sm font-weight-bolder text-lime-500">
                                        {{-- Optional: % atau tren --}}
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                            <i class="fas fa-home text-lg relative top-2.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


      <!-- card2 -->
            <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
          <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                  <div class="flex flex-row -mx-3">
                      <div class="flex-none w-2/3 max-w-full px-3">
                          <div>
                              <p class="mb-0 font-sans font-semibold leading-normal text-sm">Rumah Tersedia</p>
                              <h5 class="mb-0 font-bold">
                                  {{ $jumlahTersedia }}
                                  <span class="leading-normal text-sm font-weight-bolder text-lime-500">
                                      {{-- Optional: % atau tren --}}
                                  </span>
                              </h5>
                          </div>
                      </div>
                      <div class="px-3 text-right basis-1/3">
                          <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                              <i class="fas fa-check-circle text-lg relative top-2.5 text-white"></i>  
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>


      <!-- card3 -->
      <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Booking Rumah</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $jumlahBooking }}
                                    <span class="leading-normal text-sm font-weight-bolder text-lime-500">
                                        {{-- Optional: % atau tren --}}
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                            <i class="fas fa-home text-lg relative top-2.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      <!-- card4 -->
      <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Batal Membeli</p>
                                <h5 class="mb-0 font-bold">
                                    {{ $jumlahCancelled }}
                                    <span class="leading-normal text-sm font-weight-bolder text-lime-500">
                                        {{-- Optional: % atau tren --}}
                                    </span>
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                            <i class="fas fa-home text-lg relative top-2.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Kolom Kiri - Produk Terlaris -->
        <div class="col-span-1">
            @livewire('marketing.produk-terlaris')
        </div>
        
        <!-- Kolom Kanan - Status Pemesanan -->
        <div class="col-span-1">
            @livewire('marketing.status-pemesanan')
        </div>
    </div>
</div>
    

      
  </div>
  @endsection
  
  <!-- end cards -->

