@extends('include.layout')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-4">Add Task</h6>
                    </div>
                    <div class="d-flex">
                        <a href="{{ URL::previous() }}" class="btn btn-primary text-nowrap">Back</a>
                    </div>
                </div>

                <form method="post" onsubmit="return addtask()" id="AddTask">
                @csrf
                    <div class="form-floating mb-3">
                        <input type="text" name="title" class="form-control" placeholder="Title">
                        <label for="floatingInput">Title</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="date" name="due_date" class="form-control" placeholder="Password">
                        <label for="floatingPassword">Due Date</label>
                    </div>

                    <div class="form-floating mb-3">
                        <select class="form-select" name="priority_level" aria-label="Floating label select example">
                            <option value="" disabled selected>--select--</option>
                            <option value="High">High</option>
                            <option value="Low">Low</option>
                            <option value="Planning">Planning</option>
                        </select>
                        <label for="floatingSelect">Priority Level</label>
                    </div>

                    @if(Auth::user()->user_role == 'admin')
                        <div class="form-floating mb-3">
                            <select class="form-select" name="user_id" aria-label="Floating label select example">
                                <option value="" disabled selected>--select--</option>
                                @if($users)
                                @foreach($users as $key => $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                                @endif
                            </select>
                            <label for="floatingSelect">Assign To</label>
                        </div>
                    @endif
                    <div class="form-floating">
                        <textarea class="form-control" name="description" placeholder="Description" style="height: 150px;"></textarea>
                        <label for="floatingTextarea">Description</label>
                    </div>

                    <fieldset class="row mb-3">
                        <legend class="col-form-label col-sm-2 pt-0">Status</legend>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status"
                                    id="gridRadios1" value="0" checked>
                                <label class="form-check-label" for="gridRadios1">
                                    Pending
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status"
                                    id="gridRadios2" value="1">
                                <label class="form-check-label" for="gridRadios2">
                                    Completed
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <button type="submit" id="submitfrm" class="btn btn-primary">Add Task</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function addtask() {
        $('#AddTask').find('.text-danger').remove(); 
        $.ajax({
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            url: "{{ route('task_save') }}",
            data: new FormData($('#AddTask')[0]),
            dataType: 'json',
            beforeSend: function() {
                $('#submitfrm').prop('disabled', true).text('Processing..');
            },
            success: function(res) {
                $('#submitfrm').prop('disabled', false).text('Add Task');
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
                $('#submitfrm').prop('disabled', false).text('Add Task');
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