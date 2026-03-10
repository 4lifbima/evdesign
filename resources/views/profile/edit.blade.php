@extends('layouts.dashboard')
@section('title', 'Pengaturan Profil')

@section('content')
<div class="space-y-6 max-w-4xl">

    {{-- Alert Success Umum --}}
    @if (session('status'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" class="bg-[#28A745]/10 text-[#28A745] px-4 py-3 rounded-xl flex items-center gap-3 font-medium text-sm border border-[#28A745]/20">
        <iconify-icon icon="solar:check-circle-bold" class="text-xl"></iconify-icon>
        Profil berhasil diperbarui.
    </div>
    @endif

    {{-- Update Profile Form Card --}}
    <div class="bg-white dark:bg-[#1E1E1E] rounded-2xl p-6 lg:p-8 border border-[#E9ECEF] dark:border-[#334155] shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
        <div class="max-w-xl">
            @include('profile.partials.update-profile-information-form')
        </div>
    </div>

    {{-- Update Password Form Card --}}
    <div class="bg-white dark:bg-[#1E1E1E] rounded-2xl p-6 lg:p-8 border border-[#E9ECEF] dark:border-[#334155] shadow-[0_2px_8px_rgba(0,0,0,0.04)]">
        <div class="max-w-xl">
            @include('profile.partials.update-password-form')
        </div>
    </div>

    {{-- Delete User Card --}}
    <div class="bg-red-50 dark:bg-red-900/10 rounded-2xl p-6 lg:p-8 border border-red-100 dark:border-red-900/30">
        <div class="max-w-xl">
            @include('profile.partials.delete-user-form')
        </div>
    </div>

</div>
@endsection
