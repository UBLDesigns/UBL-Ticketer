<?php

namespace App\Http\Controllers;

use App\Models\Option;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    private function statusOutput($text): string
    {
        return match($text){
            0 => '<span class="text-red-400 text-3xl"><i class="fa-solid fa-circle-xmark"></i></span>',
            1 => '<span class="text-green-500 text-3xl"><i class="fa-solid fa-circle-check"></i></span>'
        };
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $options = Option::get();

        $tableBuilder = [];
        $tableHeader = [
            'Name',
            'Status',
            'Options'
        ];

        foreach($options as $option){
            $tableBuilder[] = [
                'name' => $option->name,
                'icon' =>  $this->statusOutput($option->status),
                'buttons' => [
                    [
                        'class' => 'p-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150',
                        'route' => route('options.edit', $option),
                        'icon' => 'fa-solid fa-pen-fancy',
                        'type' => 'link'
                    ]
                ]
            ];
        }

        return view(
            'options.index',
            [
                'headers' => $tableHeader,
                'rows' => $tableBuilder
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'options.create',
            [
                'type' => 'store',
                'route' => route('options.store'),
                'inputs' => [
                    [
                        'type' => 'text',
                        'name' => 'name',
                        'label' => 'Option Name',
                        'width' => 'w-1/2 float-left inline-block px-4',
                        'value' => ''
                    ],
                    [
                        'type' => 'select',
                        'name' => 'status',
                        'label' => 'Status',
                        'value' => '',
                        'width' => 'w-1/2 float-left inline-block px-4',
                        'inputs' => [
                            [
                                'name' => 'Disabled',
                                'value' => 0
                            ],
                            [
                                'name' => 'Enabled',
                                'value' => 1
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $authenticate = $request->validate([
            'name' => 'required|string',
            'status' => 'required|boolean'
        ]);

        $option = Option::create($authenticate);

        return redirect()->route('options.edit', $option)->with('success', 'Option added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Option $option)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Option $option)
    {
        return view(
            'options.edit',
            [
                'type' => 'update',
                'option' => $option,
                'route' => route('options.update', $option),
                'inputs' => [
                    [
                        'type' => 'text',
                        'name' => 'name',
                        'label' => 'Option Name',
                        'width' => 'w-1/2 float-left inline-block pr-4',
                        'value' => $option->name
                    ],
                    [
                        'type' => 'select',
                        'name' => 'status',
                        'label' => 'Status',
                        'value' => $option->status,
                        'width' => 'w-1/2 float-left inline-block pl-4',
                        'inputs' => [
                            [
                                'name' => 'Disabled',
                                'value' => 0
                            ],
                            [
                                'name' => 'Enabled',
                                'value' => 1
                            ]
                        ]
                    ]
                ]
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Option $option)
    {
        $authenticate = $request->validate([
            'name' => 'required|string',
            'status' => 'required|boolean'
        ]);

        $option->update($authenticate);

        return redirect()->route('options.edit', $option)->with('success', 'Option updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Option $option)
    {
        //
    }
}
