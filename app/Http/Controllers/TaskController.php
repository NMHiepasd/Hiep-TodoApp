<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use JetBrains\PhpStorm\NoReturn;

class TaskController extends Controller
{
    // REVIEW: refactor
    // Với view chỉ cần để return type là: \Illuminate\Contracts\Support\Renderable
    public function index(Request $request): View|\Illuminate\Foundation\Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $query = Task::query();
        // REVIEW: security
        // Cần validate dữ liệu trước khi thao tác để tránh lỗi runtime hoặc lỗi khi truy vấn dữ liệu
        // nghiêm trọng hơn để tránh hacker tấn công/phá hoại hệ thống
        // REVIEW: refactor
        // Cân nhắc sử dụng: $query->when($request->get('filter'), function($query, $status) {
        //   return $query->where('status', $status);
        // })
        if ($request->has('filter') && $request->filter != '') {
            $query->where('status', $request->filter);
        }
        if ($request->has('sort') && $request->has('direction')) {
            $query->orderBy($request->sort, $request->direction);
        }
        if ($request->has('search') && $request->search != '') {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // REVIEW: refactor
        // Cân nhắc sử dụng `$request->get('quantity', 5)` thay cho `$request->has('quantity') ? $request->quantity : 5`
        $quantity = $request->has('quantity') ? $request->quantity : 5; // Default to 5 if no quantity is selected
        // REVIEW: refactor
        // $tasks này không được dùng ?
        $tasks = $query->paginate($quantity);
        $tasks = $query->get();

        return view('tasks.index', compact('tasks'));
    }

    public function create(): View|\Illuminate\Foundation\Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();
        $validated['status'] = 'in progress'; // Set a default status
        // REVIEW: security
        // Dữ liệu create_date, end_date chưa được validate nên có thể sẽ bị lỗi nếu không truyền lên hoặc truyền lên sai kiểu dữ liệu mong muốn
        $validated['create_date'] = $request->create_date;
        $validated['end_date'] = $request->end_date;

        Task::create($validated);

        session()->flash('message', 'Task created successfully!');
        return redirect()->back();
    }

    public function edit(Task $task): View|\Illuminate\Foundation\Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('Tasks.edit', compact('task'));
    }

    public function show(Task $task): View|\Illuminate\Foundation\Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('Tasks.show', compact('task'));
    }

    public function destroy(Task $task): \Illuminate\Http\RedirectResponse
    {
        $task->delete();
        session()->flash('message', 'Task deleted successfully!');
        return redirect()->back();
    }

    public function update(UpdateTaskRequest $request, Task $task): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validated();
        $task->title = $validatedData['title'];
        $task->description = $validatedData['description'];
        $task->end_date = $validatedData['end_date'];
        $task->status = $validatedData['status'];
        $task->save();

        session()->flash('message', 'Task edited successfully!');
        return redirect()->back();
    }

}


