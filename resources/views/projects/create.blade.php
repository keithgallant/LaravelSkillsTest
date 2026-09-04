<!DOCTYPE html>
<html>
<head>
    <title>Create Project</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="p-5 bg-light border">
            <h2>Create Project</h2>
            <form action="{{ route('projects.store') }}" method="POST">
                @csrf
                <div>
                    <label>Name:</label>
                    <input type="text" name="name" value="{{ old('name') }}">
                    @error('name') <div>{{ $message }}</div> @enderror
                </div>
        
                <div class="d-flex justify-content-between align-items-center flex-row">
                    <a class="btn btn-secondary btn-sm" href="{{ route('projects.index') }}">Cancel</a>
                    <button class="btn btn-success btn-sm" type="submit">Submit</button>
                </div>
                
            </form>
        </div>
    </div>
</body>
</html>