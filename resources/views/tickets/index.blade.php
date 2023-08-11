<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Tickets') }}
      </h2>
  </x-slot>

  @if (!Auth::user()->isadmin)
  <div class="pt-6">
        <div class="max-w-7xl text-right mx-auto sm:px-6 lg:px-8">
            <a href="{{route('tickets.create')}}" class="p-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-solid fa-plus"></i> Create New Ticket</a>
        </div>
    </div>
    @endif
  <div class="@if (!Auth::user()->isadmin) pt-6 @else pt-12 @endif pb-16">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if (session()->has('success'))
                    <div class="mx-10 my-5 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    {{session('success')}}.
                    </div>
                @endif
                <div class="p-6 text-gray-900">
                <x-tables :headers="$headers" :rows="$rows" />
                </div>
                @if ($tickets)
                    <div class="px-6 mb-8">{{$tickets->links()}}</div>    
                @endif
          </div>
          
      </div>
  </div>
</x-app-layout>
