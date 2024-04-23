@foreach ($projects as $project)
    {{ view('project.listing', ['project' => $project]) }}
@endforeach

{{ $projects->links() }}
