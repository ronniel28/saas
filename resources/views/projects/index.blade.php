@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">Projects</h1>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach($projects as $project)
            <tr class="border-t">
                <td class="p-3">{{ $project->name }}</td>
                <td class="p-3">{{ $project->status }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
