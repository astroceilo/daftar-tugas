<?php

namespace App\Controllers;

use App\Models\TaskModel;
use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Task extends ResourceController
{
    protected $modelName = TaskModel::class;
    protected $format = 'json';

    public function index()
    {
        $data['title'] = 'Daftar Tugas';
        return view('tasks/index', $data);
    }

    public function getData()
    {
        // $model = new TaskModel();
        $tasks = $this->model->getAllTasks();

        $data = [];
        foreach ($tasks as $task) {
            $statusBadge = $task['status'] == 1
                ? '<span class="badge bg-success">Selesai</span>'
                : '<span class="badge bg-warning">Belum Selesai</span>';

            $checkbox = $task['status'] == 1
                ? '<input type="checkbox" class="task-status" data-id="' . $task['id'] . '" checked>'
                : '<input type="checkbox" class="task-status" data-id="' . $task['id'] . '">';

            $actions = '
                <button class="btn btn-sm btn-primary edit-task" data-id="' . $task['id'] . '" data-judul="' . $task['judul'] . '" data-status="' . $task['status'] . '">
                    <i class="fas fa-edit"></i> Edit
                </button>
                <button class="btn btn-sm btn-danger delete-task" data-id="' . $task['id'] . '">
                    <i class="fas fa-trash"></i> Hapus
                </button>';

            $data[] = [
                'id' => $task['id'],
                'judul' => $task['judul'],
                'status' => $statusBadge,
                'checkbox' => $checkbox,
                'actions' => $actions
            ];
        }

        return $this->respond([
            'data' => $data
        ]);
    }

    public function create()
    {
        $rules = [
            'judul' => 'required|min_length[3]|max_length[255]'
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ], 400);
        }

        // $model = new TaskModel();
        $data = [
            'judul' => $this->request->getPost('judul'),
            'status' => 0
        ];

        if ($this->model->createTask($data)) {
            return $this->respond([
                'success' => true,
                'message' => 'Tugas berhasil ditambahkan'
            ]);
        }

        return $this->respond([
            'success' => false,
            'message' => 'Gagal menambahkan tugas'
        ], 500);
    }

    public function show($id = null)
    {
        // $model = new TaskModel();
        $task = $this->model->getTask($id);

        if (!$task) {
            return $this->respond([
                'success' => false,
                'message' => 'Tugas tidak ditemukan'
            ], 404);
        }

        return $this->respond([
            'success' => true,
            'data' => $task
        ]);
    }

    public function update($id = null)
    {
        $rules = [
            'judul' => 'required|min_length[3]|max_length[255]',
            'status' => 'required|in_list[0,1]'
        ];

        if (!$this->validate($rules)) {
            return $this->respond([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $this->validator->getErrors()
            ], 400);
        }

        // $model = new TaskModel();
        $data = [
            'judul' => $this->request->getRawInput()['judul'],
            'status' => $this->request->getRawInput()['status']
        ];

        if ($this->model->updateTask($id, $data)) {
            return $this->respond([
                'success' => true,
                'message' => 'Tugas berhasil diperbarui'
            ]);
        }

        return $this->respond([
            'success' => false,
            'message' => 'Gagal memperbarui tugas'
        ], 500);
    }

    public function delete($id = null)
    {
        // $model = new TaskModel();

        if ($this->model->deleteTask($id)) {
            return $this->respond([
                'success' => true,
                'message' => 'Tugas berhasil dihapus'
            ]);
        }

        return $this->respond([
            'success' => false,
            'message' => 'Gagal menghapus tugas'
        ], 500);
    }

    public function updateStatus()
    {
        $id = $this->request->getPost('id');
        $status = $this->request->getPost('status');

        // $model = new TaskModel();
        if ($this->model->updateStatus($id, $status)) {
            return $this->respond([
                'success' => true,
                'message' => 'Status tugas berhasil diperbarui'
            ]);
        }

        return $this->respond([
            'success' => false,
            'message' => 'Gagal memperbarui status tugas'
        ], 500);
    }
}
