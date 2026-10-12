@extends('layouts.public')

@section('title', 'Profile settings | eBarangay')

@section('content')
    <section class="page-intro" aria-labelledby="profile-title">
        <div class="content-width">
            <p class="eyebrow">Account settings</p>
            <h1 id="profile-title">Your profile</h1>
            <p>Update your name and email address. Confirm each sensitive change with your current password.</p>
        </div>
    </section>

    <section class="page-body">
        <div class="profile-layout content-width">
            <form class="profile-form" method="POST" action="{{ route('profile.update') }}">
                @csrf
                @method('PATCH')

                @if (session('status'))
                    <p class="status-message" role="status">{{ session('status') }}</p>
                @endif

                <div class="form-field">
                    <label class="form-label" for="name">Name</label>
                    <input class="form-input" id="name" name="name" type="text" value="{{ old('name', $user->name) }}" autocomplete="name" required>
                    @error('name')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="form-label" for="email">Email address</label>
                    <input class="form-input" id="email" name="email" type="email" value="{{ old('email', $user->email) }}" autocomplete="email" required>
                    @error('email')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-field">
                    <label class="form-label" for="current_password">Current password</label>
                    <input class="form-input" id="current_password" name="current_password" type="password" autocomplete="current-password" required>
                    @error('current_password')
                        <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <button class="action-link action-primary" type="submit">Save profile</button>
            </form>

            <section class="danger-zone" aria-labelledby="delete-account-title">
                <h2 id="delete-account-title">Delete account</h2>
                <p>This permanently removes your account and signs you out. This action cannot be undone.</p>
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('DELETE')

                    <div class="form-field">
                        <label class="form-label" for="delete_current_password">Current password</label>
                        <input class="form-input" id="delete_current_password" name="current_password" type="password" autocomplete="current-password" required>
                        @error('current_password')
                            <p class="field-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <button class="action-link action-danger" type="submit">Delete account</button>
                </form>
            </section>
        </div>
    </section>
@endsection