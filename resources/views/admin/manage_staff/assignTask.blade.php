@extends('layouts.app')

@section('title', 'Assign Task to Staff')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h4 class="fw-bold mb-0">Assign Task to Staff</h4>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

         <form method="POST" action="{{ route('admin.manage_staff.assignTask') }}">
                @csrf

                <!-- Staff Selection -->
                <div class="mb-3">
                    <label for="staff_id" class="form-label">Select Staff</label>
                    <select name="staff_id" id="staff_id" class="form-select" required>
                        <option value="">-- Select Staff --</option>
                        @foreach(App\Models\User::where('role_id', 4)->where('company_id', auth()->user()->company_id)->get() as $staff)
                            <option value="{{ $staff->id }}">{{ $staff->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Task Selection -->
                <div class="mb-3">
                    <label for="task_id" class="form-label">Task</label>
                    <select name="task_id" id="task_id" class="form-select" required>
                        <option value="">-- Select Task --</option>
                        @foreach ($tasks as $task)
                            <option value="{{ $task->id }}">{{ $task->task_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button -->
                <div class="d-grid">
                    <button type="submit" class="btn ">Assign Task</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
