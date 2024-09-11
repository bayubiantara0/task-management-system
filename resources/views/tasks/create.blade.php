@extends('layouts.tasklayout')

@section('title', 'Create Task')

@section('content')
<h1>Create Task</h1>
<form action="{{ route('tasks.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="description">Description:</label>
        <textarea id="description" name="description" class="form-control"></textarea>
    </div>
    <div class="form-group">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Save</button>
</form>
@endsection