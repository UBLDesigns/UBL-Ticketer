<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Settings') }}
        </h2>
    </x-slot>
  
    <div class="py-12">
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
                      <x-forms :inputs="$inputs" :type="$type" :route="$route" :image="$image" />
                  </div>
              </div>
        </div>
    </div>
  </x-app-layout>