@extends('layouts.app')
@section('title', 'Masuk Admin - Banom NU')

@section('content')
<div class="max-w-md mx-auto px-4 py-16">
    <div class="bg-white rounded-3xl shadow-lg p-8">
        <h1 class="text-2xl font-bold text-nu-800">Masuk Admin</h1>
        <p class="text-sm text-gray-500 mt-1">Khusus pengurus.</p>

        <form method="POST" action="{{ route('login.attempt') }}" class="mt-6 space-y-4">
            @csrf
            <div>
                <label class="text-xs font-semibold text-gray-600">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                       class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-emerald-400">
                @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="text-xs font-semibold text-gray-600">Kata sandi</label>
                <input type="password" name="password" required
                       class="w-full mt-1 border border-gray-300 rounded-xl px-4 py-2.5 focus:outline-none focus:ring-2 focus:ring-emerald-400">
            </div>
            <label class="flex items-center gap-2 text-sm text-gray-600"><input type="checkbox" name="remember"> Ingat saya</label>
            <button class="w-full bg-nu-700 hover:bg-nu-800 text-white font-semibold rounded-xl py-3 transition">Masuk</button>
        </form>
    </div>
</div>
@endsection
