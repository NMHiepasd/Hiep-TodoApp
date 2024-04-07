<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Models\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Request $request): View|\Illuminate\Foundation\Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $query = Task::with('user')->where('status', '!=', 'trash');

        if ($request->has('filter') && $request->filter != '') {
            $query->where('status', $request->filter);
        }

        if ($request->has('name') && $request->name != '') {
            $query->join('users', 'tasks.user_id', '=', 'users.id')
                ->where('users.name', $request->name);
        }

        if ($request->has('sort') && $request->has('direction')) {
            $sortColumn = $request->sort === 'create_date' ? 'tasks.created_at' : 'tasks.' . $request->sort;
            $query->orderBy($sortColumn, $request->direction);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $quantity = $request->has('quantity') ? $request->quantity : 5; // Default to 5 if no quantity is selected
        $tasks = $query->paginate($quantity);

        $users = User::all();

        return view('index', compact('tasks', 'users'));
    }

    public function create(): View|\Illuminate\Foundation\Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $validated['title'] = $request->title;
        $validated['status'] = 'in progress';
        $validated['created_at'] = $request->created_at;
        $validated['end_date'] = $request->end_date;

        if (auth()->user()->isAdmin()) {
            $validated['user_id'] = $request->user_id;
        } else {
            $validated['user_id'] = auth()->user()->id;
        }

        $task = Task::create($validated);

        session()->flash('message', 'Task created successfully!');
        return redirect()->back();
    }

    public function edit($id)
    {
        $task = Task::with('user')->find($id);

        if (!$task) {
            abort(404, 'Task not found.');
        }

        if ((int)auth()->user()->id != (int)$task->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $users = $task->user;
        return view('Tasks.edit', compact('task', 'users'));
    }

    public function destroy(Task $task): \Illuminate\Http\RedirectResponse
    {
        if ((int)auth()->user()->id != (int)$task->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $task->status = 'trash';
        $task->save();

        session()->flash('message', 'Task moved to trash successfully!');
        return redirect()->route('tasks.trash');
    }

    public function update(UpdateTaskRequest $request, Task $task)
    {
        if ((int)auth()->user()->id != (int)$task->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validated();

        $task->title = $validatedData['title'];
        $task->end_date = $validatedData['end_date'];
        $task->status = $validatedData['status'];
        $task->user_id = auth()->user()->id;
        $task->save();

        session()->flash('message', 'Task edited successfully!');
        return redirect()->back();
    }

    public function trash(Request $request): View|\Illuminate\Foundation\Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $query = Task::query()->where('status', 'trash');

        if ($request->has('filter') && $request->filter != '') {
            $query->where('status', $request->filter);
        }

        if ($request->has('name') && $request->name != '') {
            $query->join('users', 'tasks.user_id', '=', 'users.id')
                ->where('users.name', $request->name);
        }

        if ($request->has('sort') && $request->has('direction')) {
            $sortColumn = $request->sort === 'create_date' ? 'tasks.created_at' : 'tasks.' . $request->sort;
            $query->orderBy($sortColumn, $request->direction);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $quantity = $request->has('quantity') ? $request->quantity : 5; // Default to 5 if no quantity is selected
        $tasks = $query->paginate($quantity);

        $users = User::all();
        return view('tasks.trash', compact('tasks', 'users'));
    }

    public function restore(Task $task): \Illuminate\Http\RedirectResponse
    {
        if ((int)auth()->user()->id != (int)$task->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $task->status = 'in progress'; // Set the status back to 'in progress'
        $task->save();

        session()->flash('message', 'Task restored successfully!');
        return redirect()->back();
    }

    public function destroyForever(Task $task): \Illuminate\Http\RedirectResponse
    {
        if ((int)auth()->user()->id != (int)$task->user_id && !auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized action.');
        }

        $task->delete();

        session()->flash('message', 'Task deleted forever successfully!');
        return redirect()->back();
    }

}




