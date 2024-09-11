@extends('layouts.tasklayout')

@section('title', 'Task Details')

@section('content')
<h1>Task Details</h1>
<p><strong>Name:</strong> {{ $task->name }}</p>
<p><strong>Description:</strong> {{ $task->description }}</p>
<p><strong>Date:</strong> {{ $task->date ? $task->date->format('Y-m-d') : 'N/A' }}</p>
<a href="{{ route('tasks.index') }}" class="btn btn-primary">Back to List</a>
@endsection