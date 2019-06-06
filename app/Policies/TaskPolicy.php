<?php

namespace App\Policies;

use App\DefaultAuth;
use App\Task;
use Illuminate\Auth\Access\HandlesAuthorization;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the task.
     *
     * @param  \App\DefaultAuth  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function view(DefaultAuth $user, Task $task)
    {
        //
        return \App\ProjectMember::where([
            ['id_member', '=', $user->id_member],
            ['id_project', '=', $task->id_project]
        ])->exists();
    }

    /**
     * Determine whether the user can create tasks.
     *
     * @param  \App\DefaultAuth  $user
     * @return mixed
     */
    public function create(DefaultAuth $user)
    {
        //
    }

    /**
     * Determine whether the user can update the task.
     *
     * @param  \App\DefaultAuth  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function update(DefaultAuth $user, Task $task)
    {
        //
        return \App\ProjectMember::where([
            ['id_member', '=', $user->id_member],
            ['id_project', '=', $task->id_project]
        ])->exists();
    }

    /**
     * Determine whether the user can delete the task.
     *
     * @param  \App\DefaultAuth  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function delete(DefaultAuth $user, Task $task)
    {
        // TODO:
    }

    /**
     * Determine whether the user can restore the task.
     *
     * @param  \App\DefaultAuth  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function restore(DefaultAuth $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the task.
     *
     * @param  \App\DefaultAuth  $user
     * @param  \App\Task  $task
     * @return mixed
     */
    public function forceDelete(DefaultAuth $user, Task $task)
    {
        //
    }
}
