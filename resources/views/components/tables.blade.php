<table class="w-full text-sm text-left text-slate-700">
    <thead class="text-xs text-gray-800 uppercase bg-black/10">
        <tr class="border-b border-r border-l">
            @foreach ($headers as $header)
                <th class="px-6 py-3">{{$header}}</th>                
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($rows as $row)
        <tr class="border-b border-r border-l bg-neutral-50 border-neutral-200">
            @foreach ($row as $key => $column)
                @if ($key === 'buttons')
                <td class="px-6 py-4 flex gap-2 align-middle">
                    @foreach ($column as $button)
                        @if ($button['type'] === 'destroy')
                            <form method="post" action="{{$button['route']}}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="{{$button['class']}}"><i class="{{$button['icon']}}"></i></button>
                            </form>
                        @else
                            <a href="{{$button['route']}}" class="{{$button['class']}}"><i class="{{$button['icon']}}"></i></a>
                        @endif
                    @endforeach
                </td>
                @elseif ($key === 'icon')
                <td class="px-6 py-4 align-top">
                    {!!$column!!}
                </td>
                @else
                    <td class="px-6 py-4">
                        {{$column}}
                    </td>
                @endif
            @endforeach    
        </tr>          
        @endforeach
    </tbody>
</table>