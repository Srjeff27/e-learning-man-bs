@extends('layouts.guest')

@section('title', 'Reset Password')
@section('header', 'Buat Password Baru')
@section('subheader', 'Masukkan password baru untuk akun Anda')

@section('content')
    <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}"
                class="input @error('email') input-error @enderror" required autofocus>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru</label>
            <input id="password" type="password" name="password" class="input @error('password') input-error @enderror"
                placeholder="Minimal 8 karakter" required>
            @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi
                Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="input"
                placeholder="Ulangi password" required>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full btn btn-primary">
            Reset Password
        </button>
    </form>
@endsection