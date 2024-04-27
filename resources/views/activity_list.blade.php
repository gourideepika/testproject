@extends('include.layout')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="mb-4">Activity List</h6>
                    </div>
                    <div class="d-flex">
                        <a href="{{ URL::previous() }}" class="btn btn-primary text-nowrap">Back</a>
                    </div>
                </div>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Task</th>
                            <th scope="col">Done By</th>
                            <th scope="col">Activity</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($activity)
                        @php $i=1; @endphp 
                        @foreach($activity as $key => $activity)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $activity->task_id }}</td>
                            <td>{{ $activity->user->name}}</td>
                            <td>{{ $activity->activity}}</td>
                            <td>{{ $activity->created_at}}</td>
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
