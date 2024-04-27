@extends('include.layout')
@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Tasks List</h6>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($user)
                        @php $i=1; @endphp 
                        @foreach($user as $key => $user)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @if($user->status == 1)
                                    <span style="color:green;">Active</span>
                                @else
                                    <span style="color:red;">Block</span>
                                @endif
                            </td>
                            <td></td>
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