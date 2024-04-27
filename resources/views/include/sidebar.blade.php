<!-- Sidebar Start -->
<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="{{ route('home')}}" class="navbar-brand mx-4 mb-3">
            <h3 class="text-primary" style="font-size: 1.30rem;"><i class="fa fa-hashtag me-2"></i>{{ env('APP_NAME')}}</h3>
        </a>
        <div class="d-flex align-items-center ms-4 mb-4">
            <div class="position-relative">
                <img class="rounded-circle" src="{{ asset('assets/img/user.jpg') }}" alt="" style="width: 40px; height: 40px;">
                <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
            </div>
            <div class="ms-3">
                <h6 class="mb-0">{{ Auth::user()->name }}</h6>
                <span>{{ Auth::user()->user_role }}</span>
            </div>
        </div>
        <div class="navbar-nav w-100">
            <a href="{{ route('home')}}" class="nav-item nav-link active"><i class="fa fa-home"></i>Dashboard</a>
        </div>
        @if(Auth::user()->user_role == "admin")
        <div class="navbar-nav w-100">
            <a href="{{ route('userlist')}}" class="nav-item nav-link active"><i class="fa fa-users"></i>User Management</a>
        </div>
        @endif
        <div class="navbar-nav w-100">
            <a href="{{ route('task_list')}}" class="nav-item nav-link active"><i class="fa fa-tasks"></i>Task Management</a>
        </div>
        @if(Auth::user()->user_role == "admin")
        <div class="navbar-nav w-100">
            <a href="{{ route('activity_list')}}" class="nav-item nav-link active"><i class="fa fa-users"></i>Activity Management</a>
        </div>
        @endif
    </nav>
</div>

<!-- Sidebar End -->
