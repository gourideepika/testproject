@extends('include.layout')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-4">Tasks List</h6>
                    </div>
                    <div class="d-flex">
                        <a href="{{ URL::previous() }}" class="btn btn-primary text-nowrap">Back</a>
                        <a href="{{ route('task_add') }}" style="margin-left:5px;" class="btn btn-primary text-nowrap">Add Task</a>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Assigned To</th>
                            <th scope="col">Due Date</th>
                            <th scope="col">Priority Level</th>
                            <th scope="col">Description</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($tasks)
                        @php $i=1; @endphp 
                        @foreach($tasks as $key => $task)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $task->title}}</td>
                            <td>{{ $task->user->name}}</td>
                            <td>{{ $task->due_date}}</td>
                            <td>{{ $task->priority_level}}</td>
                            <td>{{ $task->description}}</td>
                            <td>
                                @if($task->status == 1)
                                <span style="color:green;">Completed</span>
                                @else
                                    <span style="color:red;">Pending</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('task_edit', ['id' => $task->id]) }}"
                                 class="btn btn-icon btn-light-primary text-primary p-1 fs-4">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="javascript:;"
                                    class="btn btn-icon btn-light-danger w-30px h-30px "
                                    data-bs-toggle="tooltip"
                                    title="Delete"data-kt-customer-payment-method="delete"
                                    id="delbtn<?= $task->id ?>" onclick="deleteTask(<?= $task->id ?>)">
                                    <i class="fa fa-trash" style="color: red;"></i>
                                </a>
                                <a href="javascript:;"
                                    class="btn btn-icon btn-light-primary w-30px h-30px "
                                    data-bs-toggle="tooltip"
                                    title="Status" id="taskbtn<?= $task->id ?>" onclick="statusTask(<?= $task->id ?>)">
                                    <i class="fa fa-tasks"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>                    
    </div>
</div>
@endsection

@push('scripts')
<script>
    function deleteTask(id) {
        if (confirm('Are you sure you want to delete this?')) {
            $.ajax({
                url: "{{ route('delete_task') }}",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function() {
                    $('#delbtn' + id).prop('disabled', true);
                },
                success: function(result) {
                    $('#delbtn' + id).prop('disabled', false);
                    if (result.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: result.message,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Got It',
                            denyButtonText: `Don't save`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })

                    } else {
                        $('.result1').show();
                        $('.result1').html(result.message);
                    }
                }
            });
        }
    }
</script>

<script>
    function statusTask(id) {
        if (confirm('Are you sure you want to change status?')) {
            $.ajax({
                url: "{{ route('task_status') }}",
                data: {
                    id: id,
                    _token: '{{ csrf_token() }}'
                },
                type: 'POST',
                dataType: 'json',
                beforeSend: function() {
                    $('#taskbtn' + id).prop('disabled', true);
                },
                success: function(result) {
                    $('#taskbtn' + id).prop('disabled', false);
                    if (result.status == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: result.message,
                            showDenyButton: false,
                            showCancelButton: false,
                            confirmButtonText: 'Got It',
                            denyButtonText: `Don't save`,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        })

                    } else {
                        $('.result1').show();
                        $('.result1').html(result.message);
                    }
                }
            });
        }
    }
</script>
@endpush