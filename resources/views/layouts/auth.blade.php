@extends('layouts.bootstrap')

@section('navbar')
    @php
        $user = auth()->user();
    @endphp

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">

            <span class="navbar-brand">Welcome, {{ $user->name }}</span>

            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbar"
                aria-controls="navbar"
                aria-expanded="false"
                aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbar">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{ route('tasks.index') }}">Tasks</a>
                    </li>
                </ul>
                <button type="button"
                        class="btn btn-outline-primary mx-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#taskSearchModal">
                    🔍 Search tasks
                </button>

                <form class="d-flex" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link p-0">
                        Logout
                    </button>
                </form>
            </div>
        </div>
        <div class="modal fade" id="taskSearchModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <form method="GET" action="{{ route('tasks.index') }}">
                        <div class="modal-header">
                            <h5 class="modal-title">Search tasks</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Search text</label>
                                <input type="text"
                                       class="form-control"
                                       name="description"
                                       value="{{ request('description') }}"
                                       placeholder="Title or description">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Priority</label>
                                <select class="form-select" name="priority">
                                    <option value="">Any</option>
                                    <option value="1" {{ request('priority') == '1' ? 'selected' : '' }}>Very low</option>
                                    <option value="2" {{ request('priority') == '2' ? 'selected' : '' }}>Low</option>
                                    <option value="3" {{ request('priority') == '3' ? 'selected' : '' }}>Medium</option>
                                    <option value="4" {{ request('priority') == '4' ? 'selected' : '' }}>High</option>
                                    <option value="5" {{ request('priority') == '5' ? 'selected' : '' }}> Very high</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-select" name="status">
                                    <option value="">Any</option>
                                    <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>In progress</option>
                                    <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Done</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Exact Match</label>
                                <select class="form-select" name="exactMatch">
                                    <option value="1" {{ request('exactMatch') == '1' ? 'selected' : '' }}>Yes</option>
                                    <option value="0" {{ request('exactMatch') == '0' ? 'selected' : '' }}>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('tasks.index') }}"
                               class="btn btn-outline-secondary">
                                Reset
                            </a>
                            <button type="submit" class="btn btn-primary">
                                Apply filters
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </nav>
@endsection
