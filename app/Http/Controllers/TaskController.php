<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private function taskOutput($text): string
    {
        return match($text){
            0 => '<span class="text-red-400 text-3xl"><i class="fa-solid fa-circle-xmark"></i></span>',
            1 => '<span class="text-green-500 text-3xl"><i class="fa-solid fa-circle-check"></i></span>'
        };
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $tasks = Task::where('ticket_id', '=', $request->ticket)->get();

        $tableBuilder = [];
        $tableHeader = [
            'Title',
            'Description',
            'Status',
            'Options'
        ];

        foreach($tasks as $task){
            $tableBuilder[] = [
                'title' => $task->title,
                'description' =>  $task->Description,
                'icon' =>  $this->taskOutput($task->status),
                'buttons' => [
                    [
                        'class' => 'p-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150',
                        'route' => route('tasks.edit', $task),
                        'icon' => 'fa-solid fa-pen-fancy',
                        'type' => 'link'
                    ],
                    [
                        'class' => 'p-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150',
                        'route' => route('tasks.destroy', $task),
                        'icon' => 'fa-solid fa-trash',
                        'type' => 'destroy'
                    ]
                ]
            ];
        }

        return view(
            'tasks.index',
            [
                'headers' => $tableHeader,
                'rows' => $tableBuilder
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $ticket = Ticket::where('id', '=', $request->ticket)->first();

        return view(
            'tasks.create',
            [
                'type' => 'store',
                'route' => route('tasks.store', ['ticket' => $ticket]),
                'inputs' => [
                    [
                        'type' => 'text',
                        'name' => 'title',
                        'label' => 'Task Title',
                        'value' => ''
                    ],
                    [
                        'type' => 'textarea',
                        'label' => 'Task Description',
                        'name' => 'Description',
                        'value' => ''
                    ],
                    [
                        'type' => 'select',
                        'name' => 'status',
                        'label' => 'Task Status',
                        'value' => '',
                        'inputs' => [
                            [
                                'name' => 'Not Completed',
                                'value' => '0'
                            ],
                            [
                                'name' => 'Completed',
                                'value' => '1'
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
    public function store(Request $request, Ticket $ticket)
    {
        $ticket = Ticket::where('id', '=', $request->ticket)->first();

        $authenticate = $request->validate([
            'title' => 'required|string',
            'Description' => 'required|string',
            'status' => 'required|integer'
        ]);

        $task = $ticket->tasks()->create($authenticate);

        return redirect()->route('tasks.edit', $task)->with('success', 'Task added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {

        return view(
            'tasks.edit',
            [
                'type' => 'update',
                'task' => $task,
                'route' => route('tasks.update', $task),
                'inputs' => [
                    [
                        'type' => 'text',
                        'name' => 'title',
                        'label' => 'Task Title',
                        'value' => $task->title
                    ],
                    [
                        'type' => 'textarea',
                        'label' => 'Task Description',
                        'name' => 'Description',
                        'value' => $task->Description
                    ],
                    [
                        'type' => 'select',
                        'name' => 'status',
                        'label' => 'Task Status',
                        'value' => $task->status,
                        'inputs' => [
                            [
                                'name' => 'Not Completed',
                                'value' => '0'
                            ],
                            [
                                'name' => 'Completed',
                                'value' => '1'
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
    public function update(Request $request, Task $task)
    {
        $authenticate = $request->validate([
            'title' => 'required|string',
            'Description' => 'required|string',
            'status' => 'required|integer'
        ]);

        $task->update($authenticate);

        return redirect()->route('tasks.edit', $task)->with('success', 'Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $ticket = $task->ticket_id;
        $task->delete();
        return redirect()->route('tasks.index', ['ticket' => $ticket])->with('success', 'Task was successfully deleted');
    }
}
