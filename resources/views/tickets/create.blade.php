<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Create New Ticket') }}
      </h2>
  </x-slot>
  <div class="pt-12 pb-16">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden p-5 text-gray-900 shadow-sm sm:rounded-lg">
              @if (session()->has('success'))
                  <div class="mx-10 my-5 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    {{session('success')}}.
                  </div>
              @endif
              @if ($errors->any())
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-200">{{ $errors->all()[0] }}</div>
                @endif
              <x-forms :inputs="$inputs" :type="$type" :route="$route" :image="$image" />
          </div>
      </div>
  </div>
</x-app-layout>
