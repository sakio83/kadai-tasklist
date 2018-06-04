<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tasklist; 

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                $tasks = Tasklist::all();

        return view('tasks.index', [
            'tasks' => $tasks,
        ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Tasklist;

        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, 
        ['status' => 'required|max:10',
        'content' => 'required|max:10',
        ]);
        
        $task = new Tasklist;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tasks = Tasklist::find($id);

        return view('tasks.show', [
            'task' => $tasks,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Tasklist::find($id);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }
    
 public function update(Request $request, $id)
    {
        
        $this->validate($request, 
        ['status' => 'required|max:10',
        'content' => 'required|max:10',
        ]);
        
        $task = Tasklist::find($id);
        $task->status = $request->status; 
        $task->content = $request->content;
        $task->save();

        return redirect('/');
    }
    // "Delete processing" when `messages/id` is accessed by DELETE
    public function destroy ($id)
    {
         $task = Tasklist::find($id);
        $task->delete();

        return redirect('/');
    }
}