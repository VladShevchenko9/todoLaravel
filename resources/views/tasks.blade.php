@extends("layouts.auth")
@section('pageTitle', 'Tasks')
@section("content")
    <h1>Tasks</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">
            {{ $error }}
        </div>
    @endforeach

    <table class="table">
        <thead>
        <tr>
            <th scope="col">ID</th>
            <th scope="col">User ID</th>
            <th scope="col">Description</th>
            <th scope="col">Priority</th>
            <th scope="col">Status</th>
            <th scope="col">Created At</th>
            <th scope="col">Action</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->id }}</td>
                <td>{{ $task->user_id }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->priority }}</td>
                <td>{{ $task->status }}</td>
                <td>{{ $task->created_at }}</td>
                <td>
                    <a href="{{ route('tasks.edit.view', ['id' => $task->id]) }}" class="btn btn-primary btn-lg">Update</a>
                    <form action="{{ route('tasks.delete', ['id' => $task->id]) }}"
                          method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-secondary btn-lg">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center mt-3">
        {{ $tasks->links() }}
    </div>
    <a href="{{ route('tasks.create.view') }}" class="btn btn-primary btn-lg">Create</a>
    <div class="modal fade modal-dark" id="taskModal" tabindex="-1" aria-labelledby="taskModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="taskModalLabel">Edit task</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="taskForm" method="post">
                        @csrf
                        <div class="mb-3">
                            <div class="form-floating">
                                <textarea class="form-control" name="taskDescription"
                                          placeholder="Task description here"
                                          id="taskDescription" required></textarea>
                                <label for="taskDescription">Description</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-floating">
                                <select class="form-select" name="taskPriority" id="taskPriority"
                                        aria-label="Task priority">
                                    <option value="1" selected>Very low</option>
                                    <option value="2">Low</option>
                                    <option value="3">Mid</option>
                                    <option value="4">High</option>
                                    <option value="5">Very high</option>
                                </select>
                                <label for="taskPriority">Task priority</label>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check form-switch">
                                <input type="hidden" name="taskStatus" value="0">
                                <input class="form-check-input" type="checkbox" id="taskStatus" name="taskStatus"
                                       value="1">
                                <label class="form-check-label" for="taskStatus">Task completed</label>
                            </div>
                        </div>
                        <button type="submit" id="taskFormSubmitBtn" style="display: none;">Submit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveTaskBtn" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection
