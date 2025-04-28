<!-- resources/views/staff/tasks/index.blade.php -->

@extends('layouts.app')

@section('content')

<style>
    .tasks-header {
        font-size: 2rem;
        font-weight: bold;
        color: #ffcc00;
    }

    .task-item {
        background-color: black;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
        transition: all 0.3s ease;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .task-item:hover {
        background-color: black;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .task-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: white;
    }

    .task-desc {
        font-size: 1rem;
        color: #666;
        margin-top: 5px;
    }

    .task-date {
        font-size: 0.9rem;
        color: #999;
        margin-top: 10px;
    }

    .task-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
    }

    .btn-complete {
        background-color: #28a745;
        color: white;
        border: none;
        padding: 5px 15px;
        border-radius: 20px;
        font-size: 0.9rem;
        cursor: pointer;
        margin-top: 10px;
    }

    .btn-complete:hover {
        background-color: #218838;
    }

    .no-tasks-message {
        font-size: 1.2rem;
        color: #888;
    }



    .completed-task {
        background-color: #f8f9fa;
        border-left: 4px solid #28a745; /* Green color to highlight completed task */
        opacity: 0.6;
    }

    .completed-task .task-title {
        text-decoration: line-through;
        color: #6c757d;
    }


</style>

<div class="container mt-5">
    <div class="tasks-header mb-4">
        <h2>Your Assigned Tasks</h2>
    </div>

    @if($tasks->isEmpty())
        <p class="no-tasks-message">You have no assigned tasks at the moment. Stay tuned!</p>
    @else
   @foreach($tasks as $task)
    <div class="task-item mb-4 p-3 shadow-sm rounded ">
        <div class="d-flex justify-content-between align-items-center">
            <div class="task-title fw-bold text-primary fs-5">{{ $task->task->task_name }}</div>
            
            <div class="task-actions">
                @if($task->is_completed == 0)
              <button class="btn btn-success btn-sm mark-completed-btn" data-task-id="{{ $task->id }}">
    Mark as Completed
</button>

                @else
                    <button class="btn btn-secondary btn-sm" disabled>
                        Completed
                    </button>
                @endif
            </div>
        </div>

        <div class="task-desc mt-2 text-muted">{{ $task->task->description }}</div>
        <div class="task-date mt-2 text-muted">
            Assigned on: {{ \Carbon\Carbon::parse($task->created_at)->format('M d, Y') }}
        </div>
    </div>
@endforeach

    @endif
</div>

@endsection



@section('scripts')


<script>
document.addEventListener('DOMContentLoaded', function() {
    const completeButtons = document.querySelectorAll('.mark-completed-btn');
    
    completeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const taskId = button.getAttribute('data-task-id');
            markAsCompleted(taskId);
        });
    });
});

function markAsCompleted(taskId) {
    fetch(`/staff/complete-task/${taskId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}', // CSRF token
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ task_id: taskId }) // Pass task_id in the body
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message); // Show success message
            location.reload();  // Reload the page to reflect the updated status
        } else {
            alert('Failed to mark task as completed!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('An error occurred while marking the task as completed.');
    });
}

</script>
@endsection
