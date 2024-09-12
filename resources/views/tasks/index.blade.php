@extends('layouts.tasklayout')

@section('title', 'Task List')

@section('content')
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

@if(session('success'))
<script type="text/javascript">
    // SweetAlert untuk notifikasi sukses
    Swal.fire({
        title: 'Success!',
        text: '{{ session("success") }}',
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#task-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('tasks.index') }}",
            columns: [{
                    data: null,
                    name: 'id',
                    render: function(data, type, row, meta) {
                        return meta.row + 1;
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
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/tasks/' + id,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            table.ajax.reload(null, false);
                            Swal.fire(
                                'Deleted!',
                                'Your task has been deleted.',
                                'success'
                            );
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Error!',
                                'An error occurred while trying to delete the task.',
                                'error'
                            );
                        }
                    });
                }
            });
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
@endsection