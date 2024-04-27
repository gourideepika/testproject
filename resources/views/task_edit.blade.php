@extends('include.layout')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-4">Edit Task</h6>
                    </div>
                    <div class="d-flex">
                        <a href="{{ URL::previous() }}" class="btn btn-primary text-nowrap">Back</a>
                    </div>
                </div>

                <form method="post" onsubmit="return edittasks()" id="EditTask">
                @csrf
                    <div class="form-floating mb-3">
                        <input type="hidden" name="id" value="{{$task->id}}" class="form-control" >
                        <input type="text" name="title" value="{{$task->title}}" class="form-control" placeholder="Title">
                        <label for="floatingInput">Title</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" name="due_date" value="{{$task->due_date}}" class="form-control" placeholder="Password">
                        <label for="floatingPassword">Due Date</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" name="priority_level" aria-label="Floating label select example">
                            <option value="" disabled selected>--select--</option>
                            <option value="High" {{ $task->priority_level == 'High' ? 'selected' : '' }}>High</option>
                            <option value="Low" {{ $task->priority_level == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Planning" {{ $task->priority_level == 'Planning' ? 'selected' : '' }}>Planning</option>
                        </select>
                        <label for="floatingSelect">Priority Level</label>
                    </div>

                    @if(Auth::user()->user_role == 'admin')
                        <div class="form-floating mb-3">
                            <select class="form-select" name="user_id" aria-label="Floating label select example">
                                <option value="" disabled selected>--select--</option>
                                @if($users)
                                @foreach($users as $key => $user)
                                <option value="{{ $user->id }}" {{ $task->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <label for="floatingSelect">Assign To</label>
                        </div>
                    @endif
                    <div class="form-floating">
                        <textarea class="form-control" name="description" placeholder="Description" style="height: 150px;">{{$task->description}}</textarea>
                        <label for="floatingTextarea">Description</label>
                    </div>

                    <button type="submit" id="submitfrm" class="btn btn-primary">Edit Task</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function edittasks() {
        $('#EditTask').find('.text-danger').hide();
        $.ajax({
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            url: "{{ route('update_task') }}",
            data: new FormData($('#EditTask')[0]),
            dataType: 'json',
            beforeSend: function() {
                    $('#submitfrm').prop('disabled', true);
                    $('#submitfrm').text('Processing..');
                },
            success: function(res) {
                $('#submitfrm').prop('disabled', false);
                $('#submitfrm').text('Edit Task');
                    console.log(res);
                if (res.status == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message
                    }).then(function() {
                            window.location.href = "{{ route('task_list') }}";
                        });

                } else if(res.status == 0) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message
                });
            }
            },
            error: function(error) {
                $('#submitfrm').prop('disabled', false).text('Edit Task');
                console.log(error);
                if (error.responseJSON.errors) {
                    var errors = error.responseJSON.errors;
                    for (var field in errors) {
                        $.each(errors[field], function(index, error) {
                            $("[name='" + field + "']").after("<div class='text-danger'>" + error + "</div>");
                        });
                    }
                }
            }
        });
        return false;
    }
</script>
@endpush