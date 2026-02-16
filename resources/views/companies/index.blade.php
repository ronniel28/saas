@extends('layouts.admin')

@section('content')

<h1 class="text-2xl font-bold mb-6">Companies</h1>

<table class="w-full bg-white shadow rounded">
    <thead class="bg-gray-200">
        <tr>
            <th class="p-3 text-left">Name</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">Active</th>
        </tr>
    </thead>
    <tbody>
        @foreach($companies as $company)
            <tr class="border-t">
                <td class="p-3">{{ $company->name }}</td>
                <td class="p-3">{{ $company->email }}</td>
                <td class="p-3">{{ $company->is_active ? 'Yes' : 'No' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

@endsection
