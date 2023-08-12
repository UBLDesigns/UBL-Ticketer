<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ticketing Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h1 class="text-6xl font-extrabold">{{ str_replace('-', ' ', config('app.name', 'UBL Designs')) }}
                        <br>
                        <small class="ml-2 text-lg font-semibold text-gray-500 dark:text-gray-400">
                            Welcome <span class="bg-gray-800 text-indigo-400 px-2 py-1 rounded-md">{{Auth::user()->name}}</span> to your ticketing dashboard
                        </small>
                    </h1>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
