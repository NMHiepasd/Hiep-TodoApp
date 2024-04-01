{{-- REVIEW: refactoring --}}
{{-- Cân nhắc cấu trúc lại layout --}}
{{-- Tham khảo các blade auth có sẵn của laravek với các directive như: extends, section, yield, stack, push,... --}}
{{-- Để có thể xây dựng layout hợp lý --}}
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
                <li class="list-group-item active" aria-current="true">Edit task</li>
                <li class="list-group-item" aria-current="true">
                    {{-- REVIEW: Lưu ý --}}
                    {{-- Đối với route có 1 tham số uri thì chỉ cần truyền thẳng thôi cũng được không cần phải truyền mảng --}}
                    <form action="{{route('tasks.update', [$task->id])}}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="taskTitle">Task title</label>
                            {{-- REVIEW: cân nhắc --}}
                            {{-- Có thể sử dụng hàm old('title', $task->title) để có thể lấy giá trị user truyền trước đó nếu bị dính validate --}}
                            {{-- Mục đính là để họ có thể xem lại form mà họ đã nhập sai trước đó --}}
                            <input type="text" name="title" class="form-control" value="{{$task->title}}" id="editedTaskTitle">
                        </div>
                        <div class="form-group">
                            <label for="taskDescription">Task description</label>
                            {{-- REVIEW: cân nhắc --}}
                            {{-- Nếu tại migration e để là text, long text, small text,..  thì ở đây có thể là textarea thì sẽ phù hợp hơn với các dữ liệu đoạn văn bản --}}
                            <input type="text" name="description" class="form-control" value="{{$task->description}}" id="editedTaskDescription">
                        </div>
                        <div class="form-group">
                            <label for="taskEndDate">End Date</label>
                            <input type="date" name="end_date" class="form-control" value="{{$task->end_date}}" id="taskEndDate">
                        </div>
                        <div class="form-group">
                            <label for="taskStatus">Status</label>
                            <select name="status" class="form-control" id="taskStatus">
                                {{-- REVIEW: cân nhắc --}}
                                {{-- Có thể dùng directive @selected($task->status == 'in progress') thay cho đoạn code dưới --}}
                                <option value="in progress" {{ $task->status == 'in progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="finish" {{ $task->status == 'finish' ? 'selected' : '' }}>Finish</option>
                                <option value="over due" {{ $task->status == 'over due' ? 'selected' : '' }}>Over Due</option>
                            </select>
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
</body>
</html>
