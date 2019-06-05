<div class="container-fluid title-row">
    <div class="row">
      <div class="col-2 align-self-center">
      <div class="title-line" data-color="{{$project->color}}"></div>
      </div>
    <div class="col-* title-box" id="title-box" data-id="{{$project->id_project}}" data-isManager="{{$isManager}}">{{$project->name}}</div>
      <div class="col-3 title-buttons">
        <div class="container">
          <div class="btn-group">
            <a href="/projects/{{ $project->id_project }}"><button type="button"
                class="btn btn-primary selection-button">•••Tasks</button></a>
            <a href="/projects/{{ $project->id_project }}/forums"><button type="button"
                class="btn btn-primary selection-button">•••Discussion</button></a>
            <a><button type="button" id="sidebarCollapse"
                class="btn btn-primary selection-button">•••Settings</button></a>
          </div>
        </div>
      </div>
      <div class="col-*"></div>
    </div>
  </div>