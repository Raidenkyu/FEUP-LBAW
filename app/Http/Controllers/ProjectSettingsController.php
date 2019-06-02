<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProjectSettingsController extends Controller
{
    //

    public function show($id){
        $project = \App\Project::where('id_project', $id)->first();
        return ['project' => $project];
    }

    public function update($id){
        $project = \App\Project::where('id_project', $id)->first();
        request()->validate([
            'name' => 'required | min:3',
            'color' => 'required'
        ]);

        $project->name = request('name');
        $project->color = $this->colorPicker(request('color'));
        $project->save();
        return $project;
    }

    private function colorPicker($color) {
        switch ($color) {
            case 'color-1':
                return 'Orange';

            case 'color-2':
                return 'Yellow';

            case 'color-3':
                return 'Red';

            case 'color-4':
                return 'Green';

            case 'color-5':
                return 'Lilac';

            case 'color-6':
                return 'Sky';

            case 'color-7':
                return 'Brown';

            case 'color-8':
                return 'Golden';

            case 'color-9':
                return 'Bordeaux';

            case 'color-10':
                return 'Emerald';

            case 'color-11':
                return 'Purple';

            case 'color-12':
                return 'Blue';
            
            default:
                return 'Orange';
                break;
        }
    }
}
