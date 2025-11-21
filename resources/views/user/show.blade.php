@extends('layout.layouts')
@section('content')
<div class="content-wrapper">
    <h1>Workflow: {{ $workflow->name }}</h1>
    <p>{{ $workflow->description }}</p>
    <h3>Stages</h3>
    @foreach($workflow->stages as $stage)
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">{{ $stage->name }}</h5>
            <p class="card-text">{{ $stage->description }}</p>
            <p><strong>Evidence Required:</strong> {{ ucfirst($stage->required_evidence_type) }}</p>
            @php
            $userEvidence = $stage->evidences()->where('user_id', auth()->id())->first();
            @endphp
            @if($userEvidence)
            <p class="text-success">Evidence Submitted: <a href="{{ Storage::url($userEvidence->file_path) }}" target="_blank">View File</a></p>
            @else
            <form action="{{ route('user.evidence.upload', $stage) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="evidence" class="form-label">Upload {{ ucfirst($stage->required_evidence_type) }}</label>
                    <input type="file" name="evidence" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endsection