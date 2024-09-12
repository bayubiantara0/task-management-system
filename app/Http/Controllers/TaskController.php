<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Services\TaskService;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Builder;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function index(Request $request, Builder $builder)
    {
        if ($request->ajax()) {
            $tasks = Task::select(['id', 'name', 'description', 'date']);

            return DataTables::of($tasks)
                ->addColumn('action', function ($row) {
                    $btn = '<button class="show btn btn-success btn-sm" data-id="' . $row->id . '">Show</button>';
                    $btn .= ' <button class="edit btn btn-success btn-sm" data-id="' . $row->id . '">Edit</button>';
                    $btn .= ' <button class="delete btn btn-danger btn-sm" data-id="' . $row->id . '">Delete</button>';
                    return $btn;
                })
                ->editColumn('date', function ($row) {
                    return $row->date ? $row->date->format('Y-m-d') : 'No Date';
                })
                ->make(true);
        }

        $html = $builder->columns([
            ['data' => 'id', 'name' => 'id', 'title' => 'ID'],
            ['data' => 'name', 'name' => 'name', 'title' => 'Name'],
            ['data' => 'description', 'name' => 'description', 'title' => 'Description'],
            ['data' => 'date', 'name' => 'date', 'title' => 'Date'],
            ['data' => 'action', 'name' => 'action', 'title' => 'Action', 'orderable' => false, 'searchable' => false],
        ])
            ->parameters([
                'dom' => 'Bfrtip',
                'buttons' => [
                    'excel', // Enable Excel export button
                ],
            ]);

        return view('tasks.index', compact('html'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $this->taskService->createTask($request->all());
        return redirect()->route('tasks.index')->with('success', 'Task successfully created!');
    }

    public function show($id)
    {
        $task = $this->taskService->getTask($id);
        return view('tasks.show', compact('task'));
    }

    public function edit($id)
    {
        $task = $this->taskService->getTask($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        $this->taskService->updateTask($id, $request->all());
        return redirect()->route('tasks.index')->with('success', 'Task successfully updated!');
    }

    public function destroy($id)
    {
        $this->taskService->deleteTask($id);
        return response()->json(['success' => 'Task deleted successfully']);
    }
}
