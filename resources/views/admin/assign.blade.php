@extends('layout.layouts')
@section('content')
<div class="content-wrapper">
    <h1>Assign Workflow to User</h1>
    <form action="{{ route('admin.workflows.assign.store', $workflow) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>User</label>
            <select name="user_id" class="form-control" required>
                @foreach($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-success">Assign</button>
    </form>
</div>
@endsection