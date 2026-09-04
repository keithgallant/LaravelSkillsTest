<!DOCTYPE html>
<html>
<head>
    <title>Coalition Task Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">Task Project - Coalition</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('tasks.index') }}">Tasks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('projects.index') }}">Projects</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="d-flex justify-content-between align-items-center flex-row">
            <h2>All Projects</h2>
            <a class="btn btn-success btn-sm" href="{{ route('projects.create') }}">Create a Project</a>
        </div>

        @if(session('success'))
            <div>{{ session('success') }}</div>
        @endif

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                @if($projects->count() === 0) 
                    <tr>
                        <td colspan="3">
                            Please create a project to get started.
                            <a class="btn btn-success btn-sm" href="{{ route('projects.create') }}">Create a Project</a>
                        </td>
                    </tr>
                @endif
                @foreach($projects as $project)
                    <tr>
                        <td>{{ $project->id }}</td>
                        <td>{{ $project->name }}</td>
                        <td>
                            <div class="d-flex">
                                <a class="btn btn-secondary btn-sm" href="{{ route('projects.edit', $project->id) }}">Edit</a>
                                
                                <form action="{{ route('projects.destroy', $project->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to remove this project? This will remove all tasks associated with this project.')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
</body>
</html>