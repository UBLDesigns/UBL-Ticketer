<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reply;
use App\Models\Option;
use App\Models\Ticket;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class TicketController extends Controller
{
    private function priorityToText($text): string
    {
        return match($text){
            1 => 'low',
            2 => 'asap',
            3 => 'urgent'
        };
    }

    private function statusToText($text): string
    {
        return match($text){
            0 => 'awaiting response',
            1 => 'replied',
            2 => 'completed',
            3 => 'awaiting invoice',
            4 => 'invoiced'
        };
    }

    public function index()
    {
        $user = Auth::user();

        $tableBuilder = [];
        $tableHeader = [
            'Subject',
            'Priority',
            'Status',
            'Tag',
            'Created On',
            'Options'
        ];

        if($user->isadmin){
            $tickets = Ticket::select('tickets.id', 'tickets.title', 'tickets.priority', 'tickets.status', 'tickets.created_at', 'options.name AS option')->leftJoin('options', 'tickets.option', 'options.id')->whereIn('tickets.status', [0,1])->orderBy('tickets.created_at', 'desc')->paginate(10);

            foreach($tickets as $ticket){
                $tableBuilder[] = [
                    'title' => $ticket->title,
                    'priority' => $this->priorityToText($ticket->priority),
                    'status' => $this->statusToText($ticket->status),
                    'tag' => $ticket->option,
                    'created_at' => date('jS M, Y', strtotime($ticket->created_at)),
                    'buttons' => [
                        [
                            'class' => 'p-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150',
                            'route' => route('tickets.edit', $ticket),
                            'icon' => 'fa-solid fa-pen-fancy',
                            'type' => 'link'
                        ],
                        [
                            'class' => 'p-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150',
                            'route' => route('tickets.destroy', $ticket),
                            'icon' => 'fa-solid fa-trash',
                            'type' => 'destroy'
                        ]
                    ]
                ];
            }
        }

        if(!$user->isadmin){
            $tickets = Ticket::select('tickets.id', 'tickets.title', 'tickets.priority', 'tickets.status', 'tickets.created_at', 'options.name AS option')->leftJoin('options', 'tickets.option', 'options.id')->where('user_id', '=', $user->id)->whereIn('tickets.status', [0,1])->orderBy('tickets.created_at', 'desc')->paginate(10);

            foreach($tickets as $ticket){
                $tableBuilder[] = [
                    'title' => $ticket->title,
                    'priority' => $this->priorityToText($ticket->priority),
                    'status' => $this->statusToText($ticket->status),
                    'tag' => $ticket->option,
                    'created_at' => date('jS M, Y', strtotime($ticket->created_at)),
                    'buttons' => [
                        [
                            'class' => 'p-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150',
                            'route' => route('tickets.edit', $ticket),
                            'icon' => 'fa-solid fa-pen-fancy',
                            'type' => 'link'
                        ]
                    ]
                ];
            }
        }

        return view('tickets.index', ['rows' => $tableBuilder, 'headers' => $tableHeader, 'tickets' => $tickets]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $options = Option::where('status', '=', 1)->get();

        $optionInputs = [];

        foreach($options as $option){
            $optionInputs[] = [
                'text' => $option->name,
                'value' => $option->id
            ];
        }

        $outputArray = [
            'type' => 'store',
            'image' => true,
            'route' => route('tickets.store'),
            'inputs' => [
                [
                    'type' => 'radio',
                    'name' => 'option',
                    'label' => 'Enquery Type',
                    'value' => '',
                    'inputs' => $optionInputs
                ],
                [
                    'type' => 'text',
                    'name' => 'title',
                    'width' => 'w-1/2 float-left inline-block pr-2',
                    'label' => 'Ticket Subject',
                    'value' => ''
                ],
                [
                    'type' => 'select',
                    'name' => 'priority',
                    'width' => 'w-1/2 float-left inline-block pl-2',
                    'label' => 'Ticket Priority',
                    'value' => '',
                    'inputs' => [
                        [
                            'name' => 'Low',
                            'value' => 1
                        ],
                        [
                            'name' => 'ASAP',
                            'value' => 2
                        ],
                        [
                            'name' => 'Urgent',
                            'value' => 3
                        ]
                    ]
                ],
                [
                    'type' => 'textarea',
                    'name' => 'description',
                    'label' => 'Message',
                    'value' => ''
                ],
                [
                    'type' => 'hidden',
                    'name' => 'hours',
                    'label' => '',
                    'value' => '0.00'
                ],
                [
                    'type' => 'files',
                    'name' => 'images',
                    'multi' => true,
                    'label' => 'File Uploads',
                    'value' => ''
                ]
            ]
        ];

        return view('tickets.create', $outputArray);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'hours' => 'sometimes|numeric',
            'priority' => 'required|integer',
            'option' => 'required|integer',
            'files' => 'sometimes|mimes:jpg,png,jpeg,gif|max:5048'
        ]);    

        $images = [];

        if($request->hasFile('images')){

            foreach($request->file('images') as $image){
            
                $originalName = pathinfo(str_replace(' ', '', $image->getClientOriginalName()), PATHINFO_FILENAME);
                $newImageName = time().'-'.$originalName.'.'.$image->guessClientExtension();
                $images[] = $newImageName;
    
                $newImage = Image::make($image);
    
                $newImage->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/full/'.$newImageName));
    
                $newImage->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->crop(100, 100)->blur(10)->greyscale()->save(public_path('uploads/icons/'.$newImageName));
    
            }

        }

        $ticket = Ticket::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'images' => implode(',', $images),
            'priority' => $request->input('priority'),
            'status' => 0,
            'option' => $request->input('option'),
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('tickets.edit', $ticket)->with('success', 'Ticket added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ticket $ticket)
    {
        $selectCss = 'w-1/2 float-left inline-block px-4';

        $settings = Setting::where('id', '=', 1)->first();
        $user = Auth::user();
        
        $options = Option::select('name')->where('id', '=', $ticket->option)->first();
        
        $ticketUser = User::select('name', 'client', 'standard', 'asap', 'urgent')
                            ->where('id', '=', $ticket->user_id)->get();

        $replies = Reply::select('replies.*', 'users.name', 'users.client', 'users.isadmin')
                            ->leftJoin('users', 'replies.user_id', '=', 'users.id')
                            ->where('ticket_id', $ticket->id)
                            ->orderBy('created_at', 'DESC')
                            ->get();
                            
        $tasks = $ticket->tasks()->get();
        $hours = Reply::where('ticket_id', $ticket->id)->sum('hours');
        $cost = $ticketUser[0]->{$this->priorityToText($ticket->priority)};
        $totalCost = number_format($cost*$hours, 2);

        $outPutArray = [
            'type' => 'store',
            'image' => true,
            'route' => route('tickets.storereply', ['ticket' => $ticket->id]),
            'status' => $this->statusToText($ticket->status),
            'priority' => $this->priorityToText($ticket->priority),
            'model' => $ticket,
            'costs' => [
                'totalHours' => $hours,
                'totalCost' => $totalCost,
                'costPerHour' => number_format($cost, 2)
            ],
            'option' => $options->name,
            'replies' => $replies,
            'userInfo' => $ticketUser,
            'tasks' => []
        ];

        
        if($settings->tasks){
            $selectCss = 'w-1/3 float-left inline-block px-4';
            foreach($tasks as $task){
                $outPutArray['tasks'][] = [
                    'title' => $task->title,
                    'description' => $task->description,
                    'status' => $task->status
                ];
            }
        }

        if($user->isadmin){
            $outPutArray['inputs'] = [
                [
                    'type' => 'textarea',
                    'name' => 'description',
                    'label' => 'Message',
                    'value' => ''
                ],
                [
                    'type' => 'number',
                    'name' => 'hours',
                    'label' => 'Hours Worked',
                    'value' => ''
                ],
                [
                    'type' => 'files',
                    'name' => 'images',
                    'multi' => true,
                    'label' => 'File Uploads',
                    'value' => ''
                ]
            ];

            $outPutArray['adminoptions'] = [
                'route' => route('tickets.updatestatus', $ticket),
                'type' => 'update',
                'inputs' => [
                    [
                        'type' => 'select',
                        'name' => 'status',
                        'label' => 'Ticket Status',
                        'width' => $selectCss,
                        'value' => $ticket->status,
                        'inputs' => [
                                        [
                                            'name' => 'Awaiting Response',
                                            'value' => '0'
                                        ],
                                        [
                                            'name' => 'Replied',
                                            'value' => '1'
                                        ],
                                        [
                                            'name' => 'Completed',
                                            'value' => '2'
                                        ],
                                        [
                                            'name' => 'Awaiting Invoice',
                                            'value' => '3'
                                        ],
                                        [
                                            'name' => 'Invoiced',
                                            'value' => '4'
                                        ]
                                    ]
                        ],
                        [
                            'type' => 'select',
                            'name' => 'priority',
                            'label' => 'Ticket Priority',
                            'width' => $selectCss,
                            'value' => $ticket->priority,
                            'inputs' => [
                                [
                                    'name' => 'Low',
                                    'value' => '1'
                                ],
                                [
                                    'name' => 'ASAP',
                                    'value' => '2'
                                ],
                                [
                                    'name' => 'Urgent',
                                    'value' => '3'
                                ]
                            ]
                        ]
                    ]
            ];

            if($settings->tasks){
                array_unshift($outPutArray['adminoptions']['inputs'], [
                    'type' => 'button',
                    'name' => 'tasks',
                    'label' => '',
                    'width' => 'w-1/3 float-left inline-block px-2',
                    'route' => route('tasks.index', ['ticket' => $ticket])
                ]);
            }
        }

        if(!$user->isadmin){
            $outPutArray['inputs'] = [
                [
                    'type' => 'textarea',
                    'name' => 'description',
                    'label' => 'Message',
                    'value' => ''
                ],
                [
                    'type' => 'hidden',
                    'name' => 'hours',
                    'label' => '',
                    'value' => '0.00'
                ],
                [
                    'type' => 'files',
                    'name' => 'images',
                    'multi' => true,
                    'label' => 'File Uploads',
                    'value' => ''
                ]
            ];
        }

        return view(
            'tickets.edit', $outPutArray
        );
    }

    /**
     * Create a reply from the ticket page.
     */
    public function storereply(Request $request, Ticket $ticket){
        $request->validate([
            'description' => 'required',
            'hours' => 'sometimes|nullable|numeric',
            'files' => 'sometimes|mimes:jpg,png,jpeg,gif|max:5048'
        ]);     
        
        $hours = 0.00;
        if(!empty($request->input('hours'))){ $hours = $request->input('hours'); }

        $images = [];

        if($request->hasFile('images')){

            foreach($request->file('images') as $image){
                
                $originalName = pathinfo(str_replace(' ', '', $image->getClientOriginalName()), PATHINFO_FILENAME);
                $newImageName = time().'-'.$originalName.'.'.$image->guessClientExtension();
                $images[] = $newImageName;

                $newImage = Image::make($image);

                $newImage->resize(1000, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save(public_path('uploads/full/'.$newImageName));

                $newImage->resize(null, 200, function ($constraint) {
                    $constraint->aspectRatio();
                })->crop(100, 100)
                    ->blur(10)->
                    greyscale()->
                    save(public_path('uploads/icons/'.$newImageName));

            }

        }

        $ticket->replies()->create([
            'description' => $request->input('description'),
            'hours' => $hours,
            'images' => implode(',', $images),
            'user_id' => Auth::user()->id
        ]);

        return redirect()->route('tickets.edit', $ticket)->with('success', 'Reply added successfully');
    }

    /**
     * Update the ticket status
     */
    public function updatestatus(Request $request, Ticket $ticket)
    {
        
        $ticket->update($request->validate([
            'status' => 'required|integer',
            'priority' => 'required|integer'
        ]));

        return redirect()->route('tickets.edit', $ticket)->with('success', 'Ticket updated successfully');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ticket $ticket)
    {
        /* $replies = Reply::repliersName()->where('replies.ticket_id', $ticket->id)->orderBy('replies.created_at', 'DESC')->get();
        
        return view(
            'tickets.edit', [
                'inputs' => [
                    [
                        'type' => 'hidden',
                        'name' => 'id',
                        'label' => '',
                        'value' => $ticket->id
                    ],
                    [
                        'type' => 'text',
                        'name' => 'title',
                        'label' => 'Option Title',
                        'value' => $ticket->title
                    ]
                ],
                'type' => 'update',
                'route' => 'tickets.update',
                'status' => $this->statusToText($ticket->status),
                'priority' => $this->priorityToText($ticket->priority),
                'model' => $ticket,
                'replies' => $replies
            ]
        ); */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ticket $ticket)
    {
        $ticket->replies()->delete();
        $ticket->tasks()->delete();
        $ticket->delete();
        return redirect()->route('tickets.index')->with('success', 'Ticket was successfully deleted');
    }
}
