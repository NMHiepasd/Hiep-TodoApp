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
                    <a href="{{route('index')}}" class="mb-2 btn btn-md btn-success">Back</a>

                    <ul class="list-group">
                        <li class="list-group-item active" aria-current="true">Create task</li>
                        <li class="list-group-item" aria-current="true">
                            <form method="POST" action="{{route('tasks.store')}}">
                                @csrf
                                <div class="form-group">
                                    <label for="taskTitle">Task title</label>
                                    <input type="text" name="title" class="form-control" id="taskTitle">
                                </div>
                                @if(auth()->user()->isAdmin())
                                    <div class="form-group">
                                        <label for="user_id">Implementer</label>
                                        <select class="form-control" id="user_id" name="user_id">
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="taskCreateDate">Create Date</label>
                                    <input type="date" name="created_at" class="form-control" id="taskCreateDate">
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
    </section>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const createDateInput = document.getElementById('taskCreateDate');
            const today = new Date().toISOString().split('T')[0];
            createDateInput.setAttribute('min', today);
        });
    </script>
@endsection
