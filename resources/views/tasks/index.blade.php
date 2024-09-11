<!DOCTYPE html>
<html>

<head>
    <title>Task Management</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Task Management</h1>
        <button id="create-task-btn" class="btn btn-primary">Create New Task</button>
        <table class="table table-bordered" id="task-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
        </table>
    </div>

    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#task-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tasks.index') }}",
                columns: [{
                        data: null, // Data tidak digunakan
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Menghitung nomor urut
                        }
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });

            // Handle delete button click
            $('#task-table').on('click', '.delete', function() {
                var id = $(this).data('id');
                if (confirm("Are you sure you want to delete this task?")) {
                    $.ajax({
                        url: '/tasks/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            table.ajax.reload(null, false);
                            alert('Task deleted successfully');
                        },
                        error: function(xhr) {
                            alert('An error occurred while trying to delete the task.');
                        }
                    });
                }
            });

            // Handle show button click
            $('#task-table').on('click', '.show', function() {
                var id = $(this).data('id');
                window.location.href = '/tasks/' + id; // redirect to show page
            });

            // Handle edit button click
            $('#task-table').on('click', '.edit', function() {
                var id = $(this).data('id');
                window.location.href = '/tasks/' + id + '/edit'; // redirect to edit page
            });

            // Handle create task button click
            $('#create-task-btn').on('click', function() {
                window.location.href = '/tasks/create'; // redirect to create page
            });
        });
    </script>
</body>

</html>