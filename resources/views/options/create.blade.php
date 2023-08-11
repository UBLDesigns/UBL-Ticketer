<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Create New Option') }}
      </h2>
  </x-slot>

  <div class="pt-6">
    <div class="max-w-7xl text-right mx-auto sm:px-6 lg:px-8">
        <a href="{{route('options.index')}}" class="p-2 bg-indigo-400 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-solid fa-angle-left"></i> Back</a>
    </div>
</div>

  <div class="py-8">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900 flex">
                <div class="w-full">
                    @if (session()->has('success'))
                        <div class="my-5 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-200" role="alert">
                        {{session('success')}}.
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="my-5 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-200">{{ $errors->all()[0] }}</div>
                    @endif
                    <x-forms :inputs="$inputs" :type="$type" :route="$route" />
                </div>
            </div>
      </div>
  </div>
</x-app-layout>
