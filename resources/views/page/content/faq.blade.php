<section id="faq" class="mx-auto px-4 sm:px-8 md:px-20 lg:px-40 py-10 mt-4 mb-20 overflow-hidden">
    <h2 class="text-2xl sm:text-3xl md:text-4xl font-bold text-center mb-10">
      Pertanyaan yang Sering Diajukan
    </h2>
  
    <div id="faq-container" class="bg-white rounded-lg shadow-md">
      @foreach ($faqs as $index => $faq)
        <div id="question-{{ $index }}" 
             class="faq-question min-h-[60px] sm:min-h-[80px] flex items-center px-4 sm:px-6 md:px-8 py-4 sm:py-6 cursor-pointer hover:bg-gray-100 transition-all border-b border-gray-200"
             onclick="toggleAnswer({{ $index }})">
          <div class="flex justify-between items-center w-full">
            <span class="text-base sm:text-lg md:text-xl text-gray-800 font-semibold">
              {{ $index + 1 }}. {{ $faq['question'] }}
            </span>
            <span id="arrow-{{ $index }}" class="text-gray-500 text-2xl">
              &#9662;
            </span>
          </div>
        </div>
        <div id="answer-{{ $index }}" 
             class="answer hidden text-gray-600 text-base sm:text-lg md:text-xl px-4 sm:px-6 md:px-8 pb-6 border-b border-gray-200">
          {{ $faq['answer'] }}
        </div>
      @endforeach
    </div>
  </section>
    
    @push('scripts')
    <script>
     function toggleAnswer(index) {
          const question = document.getElementById('question-' + index);
          const answer = document.getElementById('answer-' + index);
  
          answer.classList.toggle('hidden');
  
          if (answer.classList.contains('hidden')) {
              question.classList.add('border-b');
          } else {
              question.classList.remove('border-b');
          }
      }
    </script>
    @endpush