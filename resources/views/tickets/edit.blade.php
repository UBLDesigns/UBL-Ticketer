<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          {{ __('Ticket: '.$model->title) }}
      </h2>
  </x-slot>

    @if (isset($adminoptions))
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-neutral-50 overflow-hidden shadow-lg px-5 pb-4 sm:rounded-lg">
                    @if($settings[0]->hours)
                    <div class="flex gap-6 mt-5">
                        <div class="w-1/3 p-6 bg-neutral-200/50 rounded-md hover:outline-none hover:ring-2 hover:ring-gray-800/10 hover:ring-offset-2 transition ease-in-out duration-150">
                            <h3 class="text-2xl">Total Hours</h3>
                            <p class="text-4xl">{{round($costs['totalHours'])}} hrs</p>
                        </div>
                        <div class="w-1/3 p-6 bg-neutral-200/50 rounded-md hover:outline-none hover:ring-2 hover:ring-gray-800/10 hover:ring-offset-2 transition ease-in-out duration-150">
                            <h3 class="text-2xl">Total Earnings</h3>
                            <p class="text-4xl">&pound;{{$costs['totalCost']}}</p>
                        </div>
                        <div class="w-1/3 p-6 bg-neutral-200/50 rounded-md hover:outline-none hover:ring-2 hover:ring-gray-800/10 hover:ring-offset-2 transition ease-in-out duration-150">
                            <h3 class="text-2xl">Hourly Rate</h3>
                            <p class="text-4xl">&pound;{{$costs['costPerHour']}}</p>
                        </div>
                    </div>
                    @else
                    <div class="w.full mb-6"></div>
                    @endif
                    <x-forms :inputs="$adminoptions['inputs']" :type="$adminoptions['type']" :route="$adminoptions['route']" />
                </div>
            </div>
        </div>
    @endif

    <div class="pt-8 pb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex gap-6">
                <div class="@if (count($tasks) > 0) w-2/3 @else w-full @endif bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    @if (session()->has('success'))
                    <div class="mr-4 ml-4 my-5 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-200" role="alert">
                      {{session('success')}}.
                    </div>
                    @endif
                    @if ($errors->any())
                    <div class="mr-4 ml-4 my-5 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-200">{{ $errors->all()[0] }}</div>
                    @endif
                    <div class="p-4 text-gray-900">
                    <div class="flex mb-4 gap-3">
                        <div class="bg-black/10 py-0.5 px-1.5 rounded-md text-sm"><i class="fa-solid fa-user mr-1"></i> {{$userInfo[0]->name}}</div>
                        <div class="bg-green-500/50 py-0.5 px-1.5 text-sm rounded-md"><i class="fa-solid fa-building mr-1"></i> {{$userInfo[0]->client}}</div>
                        <div class="@if (intval($model->priority) === 3) bg-red-700 @elseif (intval($model->priority) === 2) bg-orange-600 @elseif (intval($model->priority) === 1) bg-gray-600 @endif  rounded-md text-white py-0.5 px-1.5 text-sm"><i class="fa-solid fa-triangle-exclamation mr-1"></i> {{($priority === 'asap')? strtoupper($priority) : ucwords($priority) }}</div>
                        <div class="@if (intval($model->status) === 0) bg-red-600 @elseif (intval($model->status) === 1) bg-orange-600 @elseif (intval($model->status) === 2) bg-gray-600 @elseif (intval($model->status) === 3) bg-yellow-600 @elseif (intval($model->status) === 4) bg-green-600 @endif text-white py-0.5 px-1.5 text-sm rounded-md"><i class="fa-solid fa-signal mr-1"></i> {{$status}}</div>
                        <div class="bg-slate-950 py-0.5 px-1.5 text-white text-sm rounded-md"><i class="fa-solid fa-tag"></i> {{$option}}</div>
                    </div>
                        {!!nl2br($model->description)!!}
                        <x-images-output :images="$model->images" />
                    </div>
                </div>

                @if (count($tasks) > 0)
                <div class="w-1/3 bg-white overflow-hidden shadow-sm sm:rounded-lg pt-3 pb-4 px-4">
                    <h2 class="mb-2 text-lg font-semibold text-gray-900">Tasks:</h2>
                    <ul class="max-w-md space-y-1 text-gray-500 list-inside">
                        @foreach ($tasks as $task)
                        <li class="flex items-center py-1">
                            <svg class="
                            @if (intval($task['status']) > 0)
                                w-5 h-5 mr-2 text-green-500 dark:text-green-400 flex-shrink-0
                            @else
                                w-5 h-5 mr-2 text-gray-500 dark:text-gray-400 flex-shrink-0
                            @endif
                            " xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                            </svg>
                            {{$task['title']}}
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>

    <div class="pb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-5 text-gray-900">
                    <x-forms :inputs="$inputs" :type="$type" :route="$route" :image="$image" />
                </div>
            </div>
        </div>
    </div>

    @if ($replies)
    @foreach ($replies as $reply)
    <div class="pb-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm border-b-2 border-indigo-400 sm:rounded-lg hover:shadow-xl">
                <div class="p-4 text-gray-900">
                <div class="flex mb-6 gap-3">
                    <div class="bg-black/10 py-1 px-2 rounded-md"><i class="fa-solid fa-user mr-1"></i> {{$reply->name}}</div>
                    <div class="@if ($reply->isadmin) bg-indigo-400 text-white  @else bg-green-500/50  @endif py-1 px-2 rounded-md">
                        @if ($reply->isadmin) <i class="fa-regular fa-id-badge mr-1"></i> @else <i class="fa-solid fa-building mr-1"></i> @endif {{$reply->client}}
                    </div>
                </div>
                {!!nl2br($reply->description)!!}
                <x-images-output :images="$reply->images" />
                </div>
            </div>
        </div>
    </div>
    @endforeach
    @endif
    <div class="float-left inline-block text-3xl w-1/2 pr-2 pl-2"></div>
</x-app-layout>
