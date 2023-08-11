@if (!empty($images))
    <div class="flex gap-4 my-6">
        @foreach(explode(',', $images) as $image)
            <a class="rounded-full w-24 h-24 hover:outline-none hover:ring-4 hover:ring-indigo-500 hover:ring-offset-4 transition ease-in-out duration-150" href="{{asset('uploads/full/'.$image)}}" target="_blank"><img src="{{asset('uploads/icons/'.$image)}}" alt="Reply Image" class="rounded-full w-24 h-24"></a>
        @endforeach
    </div>
@endif