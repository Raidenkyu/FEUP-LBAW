<?php

namespace App\Http\Controllers;

use App\Task;
use App\SubTask;
use App\Http\Resources\TaskResource as TaskResource;
use Illuminate\Http\Request;
use App\ProjectMember;
use App\AssignedTo as AssignedTo;
use App\Http\Controllers\ImageController as ImageController;
use Illuminate\Support\Facades\Auth as Auth;

class TasksController extends Controller
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
    public function create($id_project)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($id_project)
    {
        request()->validate([
            'name' => 'required|min:3|max:255'
        ]);

        $task_list = 'To Do';

        switch (request('list_name')) {
            case 'to-do':
                $task_list = 'To Do';
                break;
            case 'in-progress':
                $task_list = 'In Progress';
                break;
            case 'pending':
                $task_list = 'Pending Approval';
                break;
            case 'done':
                $task_list = 'Done';
                break;
            default:
                $task_list = 'To Do';
                break;
        }

        $task = Task::create([
            'id_project' => $id_project,
            'name' => request('name'),
            'list_name' => $task_list
        ]);

        return $task;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
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
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update($id_project, $id_task)
    {
        $task = \App\Task::find($id_task);

        //$this->authorize('update', $task); TODO: uncomment and test when code is fixed

        if ($task->name != request('name') && request('name') != "") {
            $task->name = request('name');
        }

        if ($task->description != request('description')) {
            $task->description = request('description');
        }

        if ($task->issue != request('issue')) {
            $task->issue = request('issue');
        }

        $checklist = $task->checklist();
        $updatedChecklist = request('tasklist');


        $task->save();
        return $task;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

    public function retrieve($id_project, $id_task)
    {
        $task = \App\Task::find($id_task);
        $json = new TaskResource($task);
        $this->authorize('view', $task);
        return $json;
    }

    public function upgradeTask($task)
    {

        switch ($task->list_name) {
            case 'To Do':
                $task->list_name = 'In Progress';
                break;
            case 'In Progress':
                $task->list_name = 'Pending Approval';
                $devs = ProjectMember::getManagers($task->id_project);
                foreach ($devs as $dev) { 
                    \App\Notification::create([
                        'id_member' => $dev->id_member,
                        'id_project' => $task->id_project,
                        'interactable' => false,
                        'action' => 'checkPending'
                    ]);
                }
                break;
            case 'Pending Approval':
                $task->list_name = 'Done';
                break;
            case 'Done':
                // TODO: Lançar erro
                break;
            default:
                // TODO: Lançar erro
                break;
        }

        return $task;
    }

    public function downgradeTask($task)
    {

        switch ($task->list_name) {
            case 'To Do':
                // TODO: Lançar erro
                break;
            case 'In Progress':
                $task->list_name = 'To Do';
                break;
            case 'Pending Approval':
                $task->list_name = 'In Progress';
                break;
            case 'Done':
                $task->list_name = 'Pending Approval';
                break;
            default:
                // TODO: Lançar erro
                break;
        }

        return $task;
    }

    public function changeList($id_project, $id_task)
    {
        $task = \App\Task::find($id_task);

        $this->authorize('update', $task);

        $old_list = $task->list_name;
        $action = request('action');

        if ($action == 'upgrade') {
            $task = $this->upgradeTask($task);
            $task->save();
        } else if ($action == 'downgrade') {
            $task = $this->downgradeTask($task);
            $task->save();
        } else {
            // TODO: Errors
        }

        // Return both the new task and the old list to update the page
        return ['task' => $task, 'old_list' => $old_list, 'action' => $action];
    }

    public function delete($id_project, $id_task){
        $task = \App\Task::find($id_task);
        $task->delete();

        $remainingTasks = \App\Task::where([
            ['id_project','=',$id_project],
            ['list_name', '=', $task->list_name]
        ])->get();

        return ['tasks' => $remainingTasks, 'list_name' => $task->list_name];
    }


    public function selfAssign($id_project, $id_task){
        
        $id = Auth::user()->id_member;
        $assignTo = AssignedTo::create([
            'id_member' => $id,
            'id_task' => $id_task
        ]);

        
        $ret =[
            'id_member' => $id,
            'id_task' => $id_task,
            'img_src' => ImageController::getImage($id)
        ];
        return $ret;
    }

}
