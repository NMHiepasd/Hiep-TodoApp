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
    </style>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col">
                    <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                        <div class="card-body py-4 px-4 px-md-5">
                            <div class="d-flex justify-content-between align-items-center mb-4 pt-2 pb-3">
                                <a href="{{route('index')}}" class="btn btn-primary" title="Back"><i class="fas fa-solid fa-arrow-left"></i></a>
                            </div>
                            <hr class="my-4">
                            <form id="filterForm" method="GET" action="{{ route('tasks.trash') }}">
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
                                            <option value="{{ $user->name }}" {{ request('name') == $user->name ? 'selected' : '' }}>{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                    <p class="small mb-0 ms-4 me-2 text-muted">Sort</p>
                                    <select class="select" name="sort"
                                            onchange="document.getElementById('filterForm').submit()">
                                        <option
                                            value="create_date" {{ request('sort') == 'create_date' ? 'selected' : '' }}>
                                            Create date
                                        </option>
                                        <option value="end_date" {{ request('sort') == 'end_date' ? 'selected' : '' }}>End
                                            date
                                        </option>
                                    </select>
                                    <input type="hidden" name="direction" id="directionInput" value="{{ request('direction') ?? 'asc' }}">

                                    <a href="#!" id="sortToggle" style="color: #23af89;" data-mdb-toggle="tooltip" title="{{ request('direction') == 'asc' ? 'Ascending' : 'Descending' }}" onclick="toggleSort()"><i id="sortIcon" class="fas {{ request('direction') == 'asc' ? 'fa-sort-amount-down-alt' : 'fa-sort-amount-up-alt' }} ms-2"></i></a>
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
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tasks as $task)
                                                <tr>
                                                    <td>{{ $task->title }}</td>
                                                    <td>{{ $task->user ? $task->user->name : 'No user assigned' }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($task->create_date)->format('Y-m-d') }}</td>
                                                    <td>{{ \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') }}</td>
                                                    <td>{{ $task->status }}</td>
                                                    <td class="justify-item-end">
                                                        <a href="{{ route('tasks.restore', $task->id) }}" class="text-info" data-mdb-toggle="tooltip" title="Restore">
                                                            <i class="fas fa-sync-alt"></i>
                                                        </a>
                                                        <form action="{{ route('tasks.destroyForever', $task->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <a href="#" class="text-danger" data-mdb-toggle="tooltip" title="Delete forever" onclick="event.preventDefault(); confirmDeleteForever(event);">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                        </form>
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
    </section>
    <script>
        window.onload = function () {
            var searchInput = document.querySelector('input[name="search"]');
            searchInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    document.getElementById('filterForm').submit();
                }
            });
        };

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

        function confirmDeleteForever(event) {
            if (confirm('Are you sure you want to delete this task forever?')) {
                event.target.closest('form').submit();
            }
        }
    </script>
@endsection
