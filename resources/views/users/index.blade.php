<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Manage Users') }}
      </h2>
  </x-slot>

  <div class="py-12">
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
              @if ($users)
                    <div class="px-6 mb-8">{{$users->links()}}</div>    
                @endif
          </div>
      </div>
  </div>
</x-app-layout>
