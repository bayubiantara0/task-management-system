@extends('layouts.tasklayout')

@section('title', 'Edit Task')

@section('content')
<h1>Edit Task</h1>
<form action="{{ route('tasks.update', $task->id) }}" method="POST">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $task->name) }}" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control">{{ old('description', $task->description) }}</textarea>
    </div>
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" class="form-control" value="{{ old('date', $task->date ? $task->date->format('Y-m-d') : '') }}">
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
</form>
@endsection