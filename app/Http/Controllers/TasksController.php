<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Tasklist;

use App\User;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        if (\Auth::check()) {
            $user = \Auth::user();
            $tasklists = $user->tasklists()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasklists,
            ];
            $data += $this->counts($user);
            return view('tasks.index', $data);
        }else {
            return view('welcome');
        }

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
        return redirect()->back();
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $this->validate($request, [
            'content' => 'required|max:191',
            'status' => 'required|max:10' ,
        ]);

        $request->user()->tasklists()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Tasklist::find($id);
        $data = [
            'task' => $task,
        ];

        return view('tasks.show', $data);
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
                return redirect('/');
    }
    
 public function update(Request $request, $id)
    {
        
        $this->validate($request, 
        [
        'status' => 'required|max:10',
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
        $tasklist = \App\Tasklist::find($id);

        if (\Auth::user()->id === $tasklist->user_id) {
            $tasklist->delete();
        }

        return redirect()->back();
    }
}