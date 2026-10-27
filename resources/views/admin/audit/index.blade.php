@extends('layouts.admin')
@section('title', 'Audit Log')
@section('heading', 'Audit Log')
@section('content')
<div class="grid gap-3">
    @forelse($auditLogs as $log)
        <article class="rounded-lg border border-slate-200 bg-white p-4 shadow-sm">
            <strong>{{ $log->action }}</strong>
            <p class="text-sm text-slate-500">{{ $log->user?->email ?: 'system' }} - {{ $log->created_at->format('d M Y H:i') }} - {{ $log->ip_address ?: '-' }}</p>
        </article>
    @empty
        <p class="text-slate-600">Belum ada audit log.</p>
    @endforelse
</div>
<div class="mt-4">{{ $auditLogs->links() }}</div>
@endsection
