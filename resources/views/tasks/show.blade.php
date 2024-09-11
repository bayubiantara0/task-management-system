<!DOCTYPE html>
<html>

<head>
    <title>View Task</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h1>Task Details</h1>
        <p><strong>Name:</strong> {{ $task->name }}</p>
        <p><strong>Description:</strong> {{ $task->description ?? 'No description provided' }}</p>
        <p><strong>Date:</strong> {{ $task->date ? $task->date->format('d M Y') : 'No date set' }}</p>
        <a href="{{ route('tasks.index') }}" class="btn btn-primary">Back to Tasks</a>
    </div>
</body>

</html>