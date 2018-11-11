@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Edit Task</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                            <form action="{{route('tasks.update', $task->id)}}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" name="description" value="{{ old('description') ?: $task->description }}">
                                </div>
                                <div class="form-group">
                                    <label for="command">Command</label>
                                    <input type="text" class="form-control" name="command" value="{{ old('command') ?: $task->command }}">
                                </div>
                                <div class="form-group">
                                    <label for="command">Cron Expression</label>
                                    <input type="text" class="form-control" name="expression" value="{{ old('expression') ?: $task->expression }}">
                                </div>
                                <div class="form-group">
                                    <label for="notification_email">Notifications Email Address</label>
                                    <input type="text" class="form-control" name="notification_email" value="{{ old('notification_email') ?: $task->notification_email }}">
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="dont_overlap" value="1" {{ (old('dont_overlap') ?: $task->dont_overlap) ? 'checked' : '' }}>
                                    <label for="dont_overlap" class="form-check-label">Don't Overlap</label>
                                </div>
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="run_in_maintenance" value="1" {{ (old('run_in_maintenance') ?: $task->run_in_mantenance) ? 'checked' : '' }}>
                                    <label for="run_in_maintenance" class="form-check-label">Run in maintenance</label>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 text-right">
                                        <button type="submit" class="btn btn-primary">Update Task</button>
                                        <a href="/tasks" class="btn btn-secondary">Cancel</a>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
