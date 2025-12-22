@extends('layouts.guest')

@section('title', 'Lupa Password')
@section('header', 'Reset Password')
@section('subheader', 'Masukkan email Anda dan kami akan mengirimkan link reset password')

@section('content')
    @if (session('status'))
        <div class="mb-4 p-3 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}"
                class="input @error('email') input-error @enderror" placeholder="nama@email.com" required autofocus>
            @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full btn btn-primary">
            Kirim Link Reset Password
        </button>
    </form>
@endsection

@section('footer')
    <p class="text-sm text-gray-600">
        Ingat password?
        <a href="{{ route('login') }}" class="font-medium text-slate-900 hover:underline">Masuk di sini</a>
    </p>
@endsection