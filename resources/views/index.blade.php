@extends('layouts.main')

@section('content')
    <style>
        #list1 .form-control {
            border-color: transparent;
        }

        #list1 .form-control:focus {
            border-color: transparent;
            box-shadow: none;
        }

        #list1 .select-input.form-control[readonly]:not([disabled]) {
            background-color: #fbfbfb;
        }

        .filter-margin {
            margin-right: 20px; /* Adjust this value as needed */
        }

        .task-row .task-action {
            display: none;
        }

        .task-row:hover .task-action {
            display: inline-block;
        }
    </style>

    <main class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                        <div class="card-body py-4 px-4 px-md-5">
                            <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
                                <img src="{{ asset('assets/img/logo-index2.png') }}" alt="Logo" style="width: 10%; height: auto;">
                            </p>
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <a href="{{ route('admin') }}" class="btn btn-primary">Go to Admin Page</a>
                                <a href="{{route('tasks.create')}}" class="btn btn-primary" title="New task"><i
                                        class="fas fa-solid fa-folder-plus"></i></a>
                                <a href="{{route('tasks.trash')}}" class="btn btn-secondary ml-2" title="Go to trash"><i
                                        class="fas fa-trash"></i></a>
                                <a href="{{route('profile.edit')}}" class="btn btn-info ml-2" title="Profile"><i
                                        class="fas fa-user"></i></a>
                                <a href="#"
                                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                   class="btn btn-danger ml-2" title="Sign out">
                                    <i class="fas fa-sign-out-alt"></i>
                                </a>
                                <form id="logout-form" method="POST" action="{{ route('logout') }}"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                            <hr class="my-4">
                            <form id="filterForm" method="GET" action="{{ route('index') }}">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                                            <p class="small mb-0 me-2 text-muted">Search</p>
                                            <input type="text" class="form-control" name="search"
                                                   value="{{ request('search') }}" placeholder="Search by task title"
                                                   onchange="document.getElementById('filterForm').submit()">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                                            <p class="small mb-0 me-2 text-muted">Quantity</p>
                                            <select class="select" name="quantity"
                                                    onchange="document.getElementById('filterForm').submit()">
                                                <option value="5" {{ request('quantity') == 5 ? 'selected' : '' }}>5
                                                </option>
                                                <option value="10" {{ request('quantity') == 10 ? 'selected' : '' }}>10
                                                </option>
                                                <option value="20" {{ request('quantity') == 20 ? 'selected' : '' }}>20
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                                    <p class="small mb-0 me-2 text-muted">Filter by User</p>
                                    <select class="select filter-margin" name="name"
                                            onchange="document.getElementById('filterForm').submit()">
                                        <option value="">All</option>
                                        @foreach($users as $user)
                                            <option
                                                value="{{ $user->name }}" {{ request('name') == $user->name ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="small mb-0 me-2 text-muted">Filter by Status</p>
                                    <select class="select" name="filter"
                                            onchange="document.getElementById('filterForm').submit()">
                                        <option value="" {{ request('filter') == '' ? 'selected' : '' }}>All</option>
                                        <option
                                            value="in progress" {{ request('filter') == 'in progress' ? 'selected' : '' }}>
                                            In Progress
                                        </option>
                                        <option value="finish" {{ request('filter') == 'finish' ? 'selected' : '' }}>
                                            Finish
                                        </option>
                                        <option
                                            value="over due" {{ request('filter') == 'over due' ? 'selected' : '' }}>
                                            Over Due
                                        </option>
                                    </select>
                                    <p class="small mb-0 ms-4 me-2 text-muted">Sort</p>
                                    <select class="select" name="sort"
                                            onchange="document.getElementById('filterForm').submit()">
                                        <option
                                            value="create_date" {{ request('sort') == 'create_date' ? 'selected' : '' }}>
                                            Create date
                                        </option>
                                        <option value="end_date" {{ request('sort') == 'end_date' ? 'selected' : '' }}>
                                            End
                                            date
                                        </option>
                                    </select>
                                    <input type="hidden" name="direction" id="directionInput"
                                           value="{{ request('direction') ?? 'asc' }}">

                                    <a href="#!" id="sortToggle" style="color: #23af89;" data-mdb-toggle="tooltip"
                                       title="{{ request('direction') == 'asc' ? 'Ascending' : 'Descending' }}"
                                       onclick="toggleSort()"><i id="sortIcon"
                                                                 class="fas {{ request('direction') == 'asc' ? 'fa-sort-amount-down-alt' : 'fa-sort-amount-up-alt' }} ms-2"></i></a>
                                </div>
                            </form>
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table">
                                            <thead>
                                            <tr>
                                                <th>Task Title</th>
                                                <th>Implementer</th>
                                                <th>Create Date</th>
                                                <th>End Date</th>
                                                <th>Status</th>
                                                <th>Option</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tasks as $task)

                                                <tr class="task-row">
                                                    <td>{{ $task->title }}</td>
                                                    <td>{{ $task->user ? $task->user->name : 'No user assigned' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($task->created_at)->format('Y-m-d') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') }}</td>
                                                    <td>{{ $task->status }}</td>
                                                    <td class="justify-item-end">
                                                        @if(auth()->user()->isAdmin() || $task->status == 'in progress')
                                                            <a href="{{ route('tasks.edit', $task->id) }}"
                                                               class="text-info task-action" data-mdb-toggle="tooltip"
                                                               title="Edit task">
                                                                <i class="fas fa-pencil-alt me-3"></i>
                                                            </a>

                                                            <div class="task-action">
                                                                <form action="{{ route('tasks.destroy', $task->id) }}"
                                                                      method="POST">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <a href="#"
                                                                       onclick="event.preventDefault(); deleteTask(event);"
                                                                       class="text-danger" data-mdb-toggle="tooltip"
                                                                       title="Delete task">
                                                                        <i class="fas fa-trash-alt"></i>
                                                                    </a>
                                                                </form>
                                                            </div>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        function toggleSort() {
            var directionInput = document.getElementById('directionInput');
            var sortToggle = document.getElementById('sortToggle');
            var sortIcon = document.getElementById('sortIcon');
            if (directionInput.value == 'asc') {
                directionInput.value = 'desc';
                sortToggle.setAttribute('title', 'Descending');
                sortIcon.className = 'fas fa-sort-amount-up-alt ms-2';
            } else {
                directionInput.value = 'asc';
                sortToggle.setAttribute('title', 'Ascending');
                sortIcon.className = 'fas fa-sort-amount-down-alt ms-2';
            }
            document.getElementById('filterForm').submit();
        }

        function deleteTask(event) {
            if (confirm('Are you sure you want to move this task to trash?')) {
                event.target.closest('form').submit();
            }
        }
    </script>
@endsection
