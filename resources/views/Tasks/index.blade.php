<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta http-equiv="x-ua-compatible" content="ie=edge"/>
    <title>Tasks list</title>
    <link rel="icon" href="img/mdb-favicon.ico" type="image/x-icon"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.2/css/all.css"/>
    <link rel="stylesheet"
          href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/tasks/index.css"/>
</head>

<body>
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
</style>
<section class="vh-100">
    <div class="container py-5 h-100">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col">
                <div class="card" id="list1" style="border-radius: .75rem; background-color: #eff1f2;">
                    <div class="card-body py-4 px-4 px-md-5">
                        <p class="h1 text-center mt-3 mb-4 pb-3 text-primary">
                            <i class="fas fa-check-square me-1"></i>
                            <u>My Todo List</u>
                        </p>
                        <div class="d-flex justify-content-between align-items-center mb-4 pt-2 pb-3">
                            <a href="{{route('tasks.create')}}" class="btn btn-primary">Create new task</a>
                            <div class="d-flex align-items-center">
                                <p class="small mb-0 me-2 text-muted">Search</p>
                                <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search by task title" onchange="document.getElementById('filterForm').submit()">
                            </div>
                        </div>
                        <hr class="my-4">
                        <form id="filterForm" method="GET" action="{{ route('tasks.index') }}">
                            <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                                <p class="small mb-0 me-2 text-muted">Quantity</p>
                                <select class="select" name="quantity"
                                        onchange="document.getElementById('filterForm').submit()">
                                    <option value="5" {{ request('quantity') == 5 ? 'selected' : '' }}>5</option>
                                    <option value="10" {{ request('quantity') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="20" {{ request('quantity') == 20 ? 'selected' : '' }}>20</option>
                                </select>
                            </div>

                            <div class="d-flex justify-content-end align-items-center mb-4 pt-2 pb-3">
                                <p class="small mb-0 me-2 text-muted">Filter</p>
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
                                    <option value="over due" {{ request('filter') == 'over due' ? 'selected' : '' }}>
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
                                    <option value="end_date" {{ request('sort') == 'end_date' ? 'selected' : '' }}>End
                                        date
                                    </option>
                                </select>
                                <select class="select" name="direction"
                                        onchange="document.getElementById('filterForm').submit()">
                                    <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>
                                        Ascending
                                    </option>
                                    <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>
                                        Descending
                                    </option>
                                </select>
                            </div>
                        </form>
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>Task Title</th>
                                            <th>Task Description</th>
                                            <th>Create Date</th>
                                            <th>End Date</th>
                                            <th>Status</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($tasks as $task)
                                            <tr>
                                                <td>{{ $task->title }}</td>
                                                <td>{{ $task->description }}</td>
                                                <td>{{ $task->create_date }}</td>
                                                <td>{{ $task->end_date }}</td>
                                                <td>{{ $task->status }}</td>
                                                <td>
                                                    @if($task->status == 'in progress')
                                                        <a href="{{ route('tasks.edit', $task->id) }}"
                                                           class="btn btn-primary">Edit</a>
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
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="../../js/tasks/mdb.min.js"></script>
<script type="text/javascript"></script>
</body>

</html>
