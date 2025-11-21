@extends('layout.layouts')
@section('content')
<div class="content-wrapper">
    <h1>Workflow: {{ $workflow->name }}</h1>
    <p>{{ $workflow->description }}</p>
    <a href="{{ route('admin.workflows.stages.create', $workflow) }}" class="btn btn-primary">Add Stage</a>
    <h3>Stages</h3>
    <ul class="list-group">
        @foreach($workflow->stages as $stage)
        <li class="list-group-item">
            <strong>{{ $stage->name }}</strong> (Order: {{ $stage->order }}, Evidence: {{ $stage->required_evidence_type }})
            <p>{{ $stage->description }}</p>
        </li>
        <li>
            <td>
                <form action="{{ route('delete.stage', $stage->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
        </li>
        @endforeach
    </ul>
    <ul><a href="{{ route('admin.dashboard') }}" type="button" class="btn btn-default"><i class="fas fa-reply"></i> Back</a></ul>
</div>
@endsection