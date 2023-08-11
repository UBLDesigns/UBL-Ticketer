<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
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
    public function show(Setting $setting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Setting $setting)
    {
        $outputArray = [
            'type' => 'update',
            'image' => true,
            'route' => route('setting.update', $setting),
            'inputs' => [
                [
                    'type' => 'check',
                    'name' => 'tasks',
                    'label' => 'Tasks Availability',
                    'width' => 'w-1/2 float-left inline-block mb-10 text-right px-6',
                    'value' => $setting->tasks
                ],
                [
                    'type' => 'check',
                    'name' => 'hours',
                    'width' => 'w-1/2 float-left inline-block mb-10',
                    'label' => 'Hourly Rates Availability',
                    'value' => $setting->hours
                ],
                [
                    'type' => 'files',
                    'name' => 'logo',
                    'label' => 'Logo',
                    'value' => ''
                ]
            ]
        ];

        if(intval($setting->hours) > 0){
            $outputArray['inputs'][] = [
                'type' => 'text',
                'width' => 'w-1/3 float-left inline-block',
                'name' => 'standard',
                'label' => 'Default Standard Rate',
                'value' => $setting->standard
            ];
            $outputArray['inputs'][] = [
                'type' => 'text',
                'width' => 'w-1/3 float-left inline-block px-4',
                'name' => 'asap',
                'label' => 'Default ASAP Rate',
                'value' => $setting->asap
            ];
            $outputArray['inputs'][] = [
                'type' => 'text',
                'width' => 'w-1/3 float-left inline-block',
                'name' => 'urgent',
                'label' => 'Default Urgent Rate',
                'value' => $setting->urgent
            ];
        }

        if(!intval($setting->hours) > 0){
            $outputArray['inputs'][] = [
                'type' => 'hidden',
                'name' => 'standard',
                'label' => '',
                'value' => $setting->standard
            ];
            $outputArray['inputs'][] = [
                'type' => 'hidden',
                'name' => 'asap',
                'label' => '',
                'value' => $setting->asap
            ];
            $outputArray['inputs'][] = [
                'type' => 'hidden',
                'name' => 'urgent',
                'label' => '',
                'value' => $setting->urgent
            ];
        }

        return view('setting.edit', $outputArray);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Setting $setting)
    {
        $request->validate([
            'logo' => 'sometimes|nullable|image|mimes:jpg,png,jpeg,gif|max:5048',
            'standard' => 'required|numeric',
            'asap' => 'required|numeric',
            'urgent' => 'required|numeric'
        ]); 

        $tasks = $hours = 0;
        if(null !== $request->input('tasks')){ $tasks = 1; }
        if(null !== $request->input('hours')){ $hours = 1; }

        $logo = $setting->logo;

        if($request->hasFile('logo')){
            $originalName = pathinfo(str_replace(' ', '', $request->file('logo')->getClientOriginalName()), PATHINFO_FILENAME);
            $newImageName = time().'-'.$originalName.'.'.$request->file('logo')->guessClientExtension();
            $logo = $newImageName;

            $newImage = Image::make($request->file('logo'));

            $newImage->resize(null, 200, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/full/'.$newImageName));

            $newImage->resize(null, 36, function ($constraint) {
                $constraint->aspectRatio();
            })->save(public_path('uploads/icons/'.$newImageName));
        }

        $setting->update([
            'tasks' => $tasks,
            'hours' => $hours,
            'logo' => $logo,
            'standard' => number_format($request->input('standard'), 2, '.'),
            'asap' => number_format($request->input('asap'), 2, '.'),
            'urgent' => number_format($request->input('urgent'), 2, '.')
        ]);

        return redirect()->route('setting.edit', $setting)->with('success', 'Settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Setting $setting)
    {
        //
    }
}
