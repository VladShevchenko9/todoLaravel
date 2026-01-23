@extends('layouts.auth')
@section('pageTitle', 'Create Task')
@section('content')
    <form action="{{ route('tasks.create') }}" id="taskForm" method="post">
        @csrf

        <div class="mb-3">
            <div class="form-floating">
                <textarea
                    class="form-control @error('description') is-invalid @enderror"
                    name="description"
                    placeholder="Task description here"
                    id="taskDescription"
                    required
                >{{ old('description') }}</textarea>

                <label for="taskDescription">Description</label>

                @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        {{-- Priority --}}
        <div class="mb-3">
            <div class="form-floating">
                <select
                    class="form-select @error('priority') is-invalid @enderror"
                    name="priority"
                    id="taskPriority"
                    aria-label="Task priority"
                >
                    <option value="1" {{ old('priority', 1) == 1 ? 'selected' : '' }}>Very low</option>
                    <option value="2" {{ old('priority') == 2 ? 'selected' : '' }}>Low</option>
                    <option value="3" {{ old('priority') == 3 ? 'selected' : '' }}>Mid</option>
                    <option value="4" {{ old('priority') == 4 ? 'selected' : '' }}>High</option>
                    <option value="5" {{ old('priority') == 5 ? 'selected' : '' }}>Very high</option>
                </select>

                <label for="taskPriority">Task priority</label>

                @error('priority')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <div class="form-check form-switch">
                <input type="hidden" name="status" value="0">

                <input
                    class="form-check-input @error('status') is-invalid @enderror"
                    type="checkbox"
                    id="taskStatus"
                    name="status"
                    value="1"
                    {{ old('status') == 1 ? 'checked' : '' }}
                >

                <label class="form-check-label" for="taskStatus">
                    Task completed
                </label>

                @error('status')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <button class="btn btn-success" type="submit">Submit</button>
    </form>
@endsection
