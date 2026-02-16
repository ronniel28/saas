@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">Dashboard</h1>

<div class="bg-white shadow p-6 rounded mb-6">
    <h2 class="text-lg font-semibold">Current User</h2>
    <p><strong>Name:</strong> {{ auth()->user()->name }}</p>
    <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
    <p><strong>Company:</strong> {{ auth()->user()->company->name ?? 'N/A' }}</p>
    <p><strong>Super Admin:</strong> {{ auth()->user()->is_super_admin ? 'Yes' : 'No' }}</p>
</div>

<div class="bg-white shadow p-6 rounded">
    <h2 class="text-lg font-semibold mb-2">Roles</h2>
    @foreach(auth()->user()->roles as $role)
        <span class="px-3 py-1 bg-blue-200 rounded text-sm">{{ $role->name }}</span>
    @endforeach
</div>

@endsection
