<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="text-center">
        <h1 class="text-3xl font-bold">👑 Admin Dashboard</h1>
        <p class="text-gray-500 mt-2">Selamat datang, {{ Auth::user()->name }}!</p>
        <form method="POST" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="text-red-500 hover:underline">Logout</button>
        </form>
    </div>
</body>
</html>