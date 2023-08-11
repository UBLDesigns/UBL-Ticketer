<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Options') }}
      </h2>
  </x-slot>

  <div class="pt-6">
    <div class="max-w-7xl text-right mx-auto sm:px-6 lg:px-8">
        <a href="{{route('options.create')}}" class="p-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-solid fa-plus"></i> Add Option</a>
    </div>
</div>

  <div class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <div class="p-6 text-gray-900 flex">
                <div class="w-full">
                    @if (session()->has('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-200" role="alert">
                            {{session('success')}}.
                        </div>
                    @endif
                    <x-tables :headers="$headers" :rows="$rows" />
                </div>
              </div>
          </div>
          
      </div>
  </div>
</x-app-layout>
