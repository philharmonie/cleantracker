<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data = Task::where('user_id', auth()->user()->id)
            ->orWhere('user_id', auth()->user()->partner_id)
            ->orderBy('date', 'DESC')
            ->get()
            ->groupBy('date')
            ->take(30)
            ->map(function ($item, $key) {
                $user_points = $item->where('user_id', auth()->user()->id)->sum('points');
                $partner_points = $item->where('user_id', auth()->user()->partner_id)->sum('points');
                return $user_points - $partner_points;
            })->values();

        $sum = 0;
        foreach ($data as $value) {
            $sum += $value;
        }
        $average = $sum / count($data);

        $sort = $request->query('sort');
        if ($sort) {
            if ($sort == 'latest') {
                return view('tasks.index', [
                    'tasks' => Task::orderBy('created_at', 'DESC')->simplePaginate(10),
                    'data' => $data,
                    'avg' => $average,
                ]);
            }
        }
        return view('tasks.index', [
            'tasks' => Task::orderBy('date', 'DESC')->simplePaginate(10),
            'data' => $data,
            'avg' => $average,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'task' => 'required|max:255',
            'date' => 'required|date|date_format:d.m.Y',
            'points' => 'required|numeric|min:1|max:3',
        ];

        $request->validate($rules);

        Task::create([
            'user_id' => auth()->user()->id,
            'date' => $request->date,
            'name' => $request->task,
            'points' => $request->points,
        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back();
    }
}
