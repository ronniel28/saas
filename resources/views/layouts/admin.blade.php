<!DOCTYPE html>
<html>
<head>
    <title>SaaS Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

<div class="flex">

    <aside class="w-64 bg-white h-screen shadow p-4">
        <h2 class="text-xl font-bold mb-6">SaaS Panel</h2>

        <ul class="space-y-3">
            <li><a href="/dashboard" class="block">Dashboard</a></li>
            <li><a href="/companies" class="block">Companies</a></li>
            <li><a href="/projects" class="block">Projects</a></li>
            <li><a href="/users" class="block">Users</a></li>
        </ul>
    </aside>

    <main class="flex-1 p-6">
        @yield('content')
    </main>

</div>

</body>
</html>
