@extends('layouts.main')

@section('content')
    <section class="vh-100">
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
                    <div class="d-flex justify-content-between align-items-center mb-4 pt-2 pb-3">
                        <a href="{{route('index')}}" class="btn btn-primary" title="Back"><i class="fas fa-solid fa-arrow-left"></i></a>
                    </div>

                    <ul class="list-group">
                        <li class="list-group-item active" aria-current="true">Edit task</li>
                        <li class="list-group-item" aria-current="true">
                            <form action="{{route('tasks.update', [$task->id])}}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="taskTitle">Task title</label>
                                    <input type="text" name="title" class="form-control" id="taskTitle" value="{{ $task->title }}">
                                </div>
                                <div class="form-group">
                                    <label for="user_id">Implementer</label>
                                    <select class="form-control" id="user_id" name="user_id">
                                        <option value="{{ $users->id }}" {{ $users->id == $task->user_id ? 'selected' : '' }} {{ $users->id != auth()->user()->id ? 'disabled' : '' }}>{{ $users->name }}</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="taskEndDate">End Date</label>
                                    <input type="date" name="end_date" class="form-control" id="taskEndDate" value="{{ $task->end_date->format('Y-m-d') }}">
                                </div>
                                <div class="form-group">
                                    <label for="taskStatus">Status</label>
                                    <select name="status" class="form-control" id="taskStatus">
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
    </section>
@endsection
