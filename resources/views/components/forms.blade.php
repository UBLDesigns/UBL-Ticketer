<form class="" method="POST" action="{{$route}}" @if ($image) enctype="multipart/form-data" @endif>
    @csrf
    @if ($type === 'update')
        @method('PUT')
    @endif
    @if ($type === 'delete')
        @method('DELETE')
    @endif
    @foreach ($inputs as $input)
        @if ($input['type'] === 'hidden')
            <input type="hidden" name="{{$input['name']}}" value="{{$input['value']}}">
        @endif
        @if ($input['type'] === 'text')
            <div class="mb-4 {{ $input['width'] ?? 'w-full' }}">
                <label for="{{$input['name']}}" class="block mb-2 text-md font-medium text-gray-900">{{$input['label']}}</label>
                <input type="text" id="{{$input['name']}}" name="{{$input['name']}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full p-2.5" value="{{$input['value']}}">
            </div>
        @endif
        @if ($input['type'] === 'number')
            <div class="mb-4 {{ $input['width'] ?? 'w-full' }}">
                <label for="{{$input['name']}}" class="block mb-2 text-md font-medium text-gray-900">{{$input['label']}}</label>
                <input pattern="[0-9]" type="number" id="{{$input['name']}}" name="{{$input['name']}}" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full p-2.5" value="{{$input['value']}}" placeholder="0.00">
            </div>
        @endif
        @if ($input['type'] === 'textarea')
            <div class="mb-4 {{ $input['width'] ?? 'w-full' }}">
                <label for="{{$input['name']}}" class="block mb-2 text-md font-medium text-gray-900">{{$input['label']}}</label>
                <textarea id="{{$input['name']}}" name="{{$input['name']}}" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full p-2.5">{{$input['value']}}</textarea>
            </div>
        @endif
        @if ($input['type'] === 'files')
        <div class="mb-4 mt-8 {{ $input['width'] ?? 'w-full' }}">
            <label for="{{$input['name']}}" class="block mb-2 text-md font-medium text-gray-900">{{$input['label']}}</label>
            <input class="block w-full text-sm text-gray-600 bg-gray-100 border border-gray-300 rounded-md cursor-pointer" name="{{$input['name']}}@if (isset($input['multi']) && $input['multi'] === true)[]@endif" id="{{$input['name']}}" type="file" value="{{$input['value']}}"@if (isset($input['multi']) && $input['multi'] === true) multiple @endif>
            <p class="mt-1 text-sm text-gray-600 mb-10">JPG, JPEG, GIF or PNG</p>
        </div>
        @endif
        @if ($input['type'] === 'select')
        <div class="mb-4 {{ $input['width'] ?? 'w-full' }}">
            <label for="{{$input['name']}}" class="block mb-2 text-md font-medium text-gray-900">{{$input['label']}}</label>
            <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full p-2.5" name="{{$input['name']}}">
                @foreach ($input['inputs'] as $option)
                    <option value="{{$option['value']}}"@if (intval($input['value']) === intval($option['value'])) selected @endif>{{$option['name']}}</option>
                @endforeach
            </select>
        </div>
        @endif
        @if ($input['type'] === 'button')
        <div class="mb-4 text-center {{ $input['width'] ?? 'w-full' }}">
            <a href="{{$input['route']}}" class="w-full block mt-8 text-center px-4 py-3 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">{{$input['name']}}</a>
        </div>
        @endif
        @if ($input['type'] === 'radio')
        <div class="mb-4 {{ $input['width'] ?? 'w-full' }}">
            <label class="mb-2 text-md font-medium text-gray-900">{{$input['label']}}</label>
            <div class="text-lg flex items-center gap-6">
                @foreach ($input['inputs'] as $option)
                    <div class="mb-4 pt-2">
                        <input id="{{$input['name'].'-'.$option['value']}}" type="radio" value="{{$option['value']}}" name="{{$input['name']}}" class="w-4 h-4 text-gray-800 bg-gray-100 border-gray-300 focus:ring-blue-500  focus:ring-2">
                        <label for="{{$input['name'].'-'.$option['value']}}" class="ml-2 text-sm font-medium text-gray-900">{{$option['text']}}</label>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
        @if ($input['type'] === 'check')
        <div class="mb-4 {{ $input['width'] ?? 'w-full' }}">
            <label class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" value="1" name="{{$input['name']}}" class="sr-only peer" @if (intval($input['value']) === 1) checked @endif>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                <span class="ml-3 text-md font-medium text-gray-900">{{$input['label']}}</span>
              </label>
        </div>
        @endif
    @endforeach
    <div class="text-right">
        <button type="submit" class="mt-4 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150"><i class="fa-solid fa-floppy-disk mr-2"></i> Save</button>
    </div>
</form>