<div class="max-w-7xl mx-auto pb-8 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
      <div class="p-6 text-gray-900 flex">
          <div class="w-full">
            <div class="sm:flex sm:items-center sm:justify-between">
                <a href="{{ route('dashboard') }}" alt="{{ config('app.name', 'UBL Designs') }}" class="h-8 mr-3">
                    <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                </a>
                <ul class="flex flex-wrap mt-3 items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0">
                    <li>
                        <a href="{{ route('dashboard') }}" class="mr-4 hover:underline md:mr-6 ">Dashboard</a>
                    </li>
                    <li>
                        <a href="{{route('tickets.index')}}" class="mr-4 hover:underline md:mr-6">Tickets</a>
                    </li>
                    @if (Auth::user()->isadmin)
                    <li>
                        <a href="{{route('options.index')}}" class="mr-4 hover:underline md:mr-6 ">Options</a>
                    </li>
                    <li>
                        <a href="{{route('setting.edit', $settings[0]->id)}}" class="hover:underline">Settings</a>
                    </li>
                    <li class="pl-5">
                        <a href="{{route('user.index')}}" class="hover:underline">Manage Users</a>
                    </li>
                    @endif
                </ul>
            </div>
                <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
                <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">Developed By: &copy;{{date('Y')}} <a href="https://www.derbyweb.dev" class="hover:underline">UBL Designs</a>. All Rights Reserved.</span>
          </div>
      </div>
</div>