<section id="lokasi" class="py-12 bg-gray-50 overflow-hidden">
    <div class="container mx-auto px-4 sm:px-20">
      
      <div class="flex flex-col lg:flex-row items-start gap-10">
  
        <!-- Maps Section -->
        <div class="w-full lg:w-1/2 mt-20">
          <iframe 
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.348039004887!2d107.0852445752378!3d-6.2177512609000685!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e698f5cd99e2857%3A0xffd2c0b3c8803336!2sGRAND%20TELAR%20RESIDENCE!5e0!3m2!1sid!2sid!4v1745664702842!5m2!1sid!2sid" 
            width="100%" 
            height="400" 
            class="rounded-lg shadow-lg" 
            allowfullscreen="" 
            loading="lazy">
          </iframe>
        </div>
  
        <!-- List Tempat Section -->
        <div class="w-full lg:w-1/2 space-y-6">
  
          @foreach ($places as $place)
            <div class="flex items-center gap-4">
              <img src="{{ asset($place['image']) }}" alt="{{ $place['name'] }}" class="w-16 h-16 rounded-lg object-cover">
              <div>
                <p class="text-sm text-gray-500">{{ $place['distance'] }}</p>
                <h3 class="text-lg font-semibold text-gray-800">{{ $place['name'] }}</h3>
              </div>
            </div>
  
            @if (!$loop->last)
              <hr class="border-gray-300">
            @endif
          @endforeach
  
        </div>
  
      </div>
  
    </div>
  </section>
  