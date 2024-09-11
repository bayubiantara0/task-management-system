<?php

namespace App\Services;

use App\Repositories\TaskRepositoryInterface;

class TaskService
{
    protected $taskRepo;

    public function __construct(TaskRepositoryInterface $taskRepo)
    {
        $this->taskRepo = $taskRepo;
    }

    public function getAllTasks()
    {
        return $this->taskRepo->all();
    }

    public function getTask($id)
    {
        return $this->taskRepo->find($id);
    }

    public function createTask(array $data)
    {
        return $this->taskRepo->create($data);
    }

    public function updateTask($id, array $data)
    {
        return $this->taskRepo->update($id, $data);
    }

    public function deleteTask($id)
    {
        return $this->taskRepo->delete($id);
    }
}
