<?php

namespace App\Policies;

use App\DefaultAuth;
use App\Project;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\ProjectMember;

class ProjectPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the project.
     *
     * @param  \App\DefaultAuth  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function view(DefaultAuth $user, Project $project)
    {
        //
        return ProjectMember::where([
            ['id_member', '=', $user->id_member],
            ['id_project', '=', $project->id_project]
        ])->exists();
    }

    /**
     * Determine whether the user can create projects.
     *
     * @param  \App\DefaultAuth  $user
     * @return mixed
     */
    public function create(DefaultAuth $user)
    {
        //
    }

    /**
     * Determine whether the user can update the project.
     *
     * @param  \App\DefaultAuth  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function update(DefaultAuth $user, Project $project)
    {
        //
        return ProjectMember::where([
            ['id_member', '=', $user->id_member],
            ['id_project', '=', $project->id_project],
            ['manager', '=', true]
        ])->exists();
    }

    /**
     * Determine whether the user can delete the project.
     *
     * @param  \App\DefaultAuth  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function delete(DefaultAuth $user, Project $project)
    {
        //
        return ProjectMember::where([
            ['id_member', '=', $user->id_member],
            ['id_project', '=', $project->id_project],
            ['manager', '=', true]
        ])->exists();
    }

    /**
     * Determine whether the user can restore the project.
     *
     * @param  \App\DefaultAuth  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function restore(DefaultAuth $user, Project $project)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the project.
     *
     * @param  \App\DefaultAuth  $user
     * @param  \App\Project  $project
     * @return mixed
     */
    public function forceDelete(DefaultAuth $user, Project $project)
    {
        //
    }
}
