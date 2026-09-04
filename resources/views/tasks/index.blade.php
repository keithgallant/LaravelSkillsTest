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
            <h2>All Tasks</h2>
            <div class="form-group">
                <label for="filterProjects">Filter By Project</label>
                <select class="form-control" id="filterProjects" onchange="location = this.value;">
                        <option value="{{ route('tasks.index') }}" @selected(!isset($selectedProject))>All Projects</option>
                     @foreach($projects as $project)
                        <option value="{{ route('tasks.index').'?project_id='.$project->id }}" @selected(isset($selectedProject) && $project->id == $selectedProject->id)>{{ $project->name }}</option>
                    @endforeach
                </select>
            </div>
            <a class="btn btn-success btn-sm" href="{{ route('tasks.create') }}">Create a Task</a>
        </div>

        @if(session('success'))
            <div>{{ session('success') }}</div>
        @endif

        @if(isset($selectedProject))
            <h3>Showing tasks for the following project: {{ $selectedProject->name }}.</h3>
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th>Priority</th>
                    <th>Project</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody id="sortable">

                @if($tasks->count() === 0) 
                    <tr>
                        <td colspan="6">
                            Please create a task to get started.
                            <a class="btn btn-success btn-sm" href="{{ route('tasks.create') }}">Create a Task</a>
                        </td>
                    </tr>
                @endif
                @foreach($tasks as $index => $task)
                    <tr data-id="{{ $task->id }}"  style="cursor: grab;">
                        <td><span class="handle">☰</span></td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $index }}</td>
                        <td>{{ $task->project->name }}</td>
                        <td>
                            <div class="d-flex">
                                <a class="btn btn-secondary btn-sm" href="{{ route('tasks.edit', $task->id) }}">Edit</a>
                                
                                <form action="{{ route('tasks.destroy', $task->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.7/Sortable.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js"></script>
    <script>
        const el = document.getElementById('sortable');
        
        Sortable.create(el, {
            animation: 150,
            onUpdate: function (evt) {
                /* update the priority column in the table to match new sort order.
                Select the rows and then iterate through them and match col to the index
                */
                const rows = el.querySelectorAll('tr');
                rows.forEach((row, index) => {
                    const indexCell = row.querySelector('td:nth-child(3)');
                    indexCell.textContent = index + 1; //
                });
            },
            onEnd: function () {
                /* grab the row ids and send them to the reorder endpoint to update priority in the database. */

                let orderedIds = Array.from(el.querySelectorAll('tr')).map(row => row.dataset.id);
                
                fetch("{{ route('tasks.reorder') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ ids: orderedIds })
                })
                .then(response => response.json())
                .then(data => console.log('Order updated!'))
                .catch(error => console.error('Error:', error));
            }
        });
    </script>
</body>
</html>