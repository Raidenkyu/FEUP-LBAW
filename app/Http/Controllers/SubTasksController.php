<?php

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\SubTask;

class SubTasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store($id_project, $id_task)
    {
    
        $subtask = SubTask::create([
            'id_task' => $id_task,
            'brief' => request('brief')
        ]);
        return $subtask;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id_project, $id_task, $id_subtask)
    {
        $subtask = SubTask::find($id_task);

        if($subtask->completed){
            $subtask->completed = false;
        }
        else{
            $subtask->completed = true;
        }
        $subtask->save();
        return $subtask;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id_project, $id_task, $id_subtask)
    {
        return SubTask::destroy($id_subtask);
    }
}
