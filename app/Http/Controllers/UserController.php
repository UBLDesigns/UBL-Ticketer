<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private function isAdminText($text): string
    {
        return match($text){
            0 => 'Client',
            1 => 'Admin'
        };
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::select('id', 'name', 'client', 'isadmin')->latest()->paginate(10);
        
        $tableBuilder = [];
        $tableHeader = [
            'Name',
            'Client',
            'Position',
            'Options'
        ];

        foreach($users as $user){
            $tableBuilder[] = [
                'name' => $user->name,
                'client' => $user->client,
                'isadmin' => $this->isAdminText($user->isadmin),
                'buttons' => [
                    [
                        'class' => 'p-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150',
                        'route' => route('user.edit', $user),
                        'icon' => 'fa-solid fa-pen-fancy',
                        'type' => 'link'
                    ]
                ]
            ];
        }

        return view('users.index', ['rows' => $tableBuilder, 'headers' => $tableHeader, 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $settings = Setting::where('id', '=', 1)->first();
        
        $output = [
            'type' => 'update',
            'user' => $user,
            'route' => route('user.update', $user),
            'inputs' => [
                [
                    'type' => 'text',
                    'name' => 'client',
                    'width' => 'w-full mb-6',
                    'label' => 'Clients Name',
                    'value' => $user->client,
                ],
                [
                    'type' => 'select',
                    'name' => 'isadmin',
                    'width' => 'w-full mb-6',
                    'label' => 'Admin',
                    'value' => $user->isadmin,
                    'inputs' => [
                        [
                            'name' => 'Not Admin',
                            'value' => '0'
                        ],
                        [
                            'name' => 'Is Admin',
                            'value' => '1'
                        ]
                    ]
                ]
            ]
        ];

        if($settings->hours){
            $output['inputs'][] = [
                'type' => 'text',
                'name' => 'standard',
                'width' => 'w-1/3 float-left inline-block',
                'label' => 'Standard Rate',
                'value' => $user->standard,
            ];
            $output['inputs'][] = [
                'type' => 'text',
                'name' => 'asap',
                'width' => 'w-1/3 float-left inline-block px-4',
                'label' => 'ASAP Rate',
                'value' => $user->asap,
            ];
            $output['inputs'][] = [
                'type' => 'text',
                'name' => 'urgent',
                'width' => 'w-1/3 float-left inline-block',
                'label' => 'Urgent Rate',
                'value' => $user->urgent,
            ];
        }

        return view('users.edit', $output);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validation = $request->validate([
            'client' => 'required|string',
            'isadmin' => 'required|numeric',
            'standard' => 'sometimes|numeric',
            'asap' => 'sometimes|numeric',
            'urgent' => 'sometimes|numeric'
        ]);

        $user->update($validation);

        return redirect()->route('user.edit', $user)->with('success', 'You have successfully updated the user');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
