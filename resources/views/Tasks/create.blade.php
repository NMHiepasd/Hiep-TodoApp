<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
          integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <title>Task list</title>
</head>
<body>
<div class="container">
    <div class="mt-5 row justify-content-center">
        <div class="col-lg-8">
            @if($errors->any())
                <div class="mb-3 alert alert-danger">
                    <ul class="list-group">
                        @foreach($errors->all() as $error)
                            <li class="list-group-item">{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session()->has('message'))
                <div class="mb-3 alert alert-success">
                    <ul class="list-group">
                        <li class="list-group-item">{{session()->get('message')}}</li>
                    </ul>
                </div>
            @endif
            <a href="{{route('tasks.index')}}" class="mb-2 btn btn-md btn-success">Back</a>

            <ul class="list-group">
                <li class="list-group-item active" aria-current="true">Create task</li>
                <li class="list-group-item" aria-current="true">
                    <form method="POST" action="{{route('tasks.store')}}">
                        @csrf
                        <div class="form-group">
                            <label for="taskTitle">Task title</label>
                            <input type="text" name="title" class="form-control" id="taskTitle">
                        </div>
                        <div class="form-group">
                            <label for="taskDescription">Task description</label>
                            <input type="text" name="description" class="form-control" id="taskDescription">
                        </div>
                        <div class="form-group">
                            <label for="taskCreateDate">Create Date</label>
                            <input type="date" name="create_date" class="form-control" id="taskCreateDate">
                        </div>
                        <div class="form-group">
                            <label for="taskEndDate">End Date</label>
                            <input type="date" name="end_date" class="form-control" id="taskEndDate">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
        crossorigin="anonymous"></script>

<script>
    /*REVIEW: refactor*/
    /*Có thể dùng attribute html min thay thế cho đoạn code này được không? */
    document.addEventListener('DOMContentLoaded', (event) => {
        const createDateInput = document.getElementById('taskCreateDate');
        const today = new Date().toISOString().split('T')[0];
        createDateInput.setAttribute('min', today);
    });
</script>
</body>
</html>
