<x-app-layout>
    <x-slot name="cssLink">
        <link rel='stylesheet' href='{{ asset('css/custom.css') }}'>
    </x-slot>

    @if (session('logout_successful'))
        <x-alert type="success" :message="session('logout_successful')" />
    @endif

</x-app-layout>
