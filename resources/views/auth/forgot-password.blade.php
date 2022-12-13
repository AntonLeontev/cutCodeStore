@extends('layouts.auth')

@section('title', 'Восстановить пароль')
@section('content')
    <x-forms.auth-form title="Восстановить пароль" action="{{route('remind-password')}}" method="POST">
        <x-forms.text-input type="email" name="email" placeholder="E-mail" required='true' />
        @error('email')
            <x-forms.error>{{$message}}</x-forms.error>
        @enderror
        <x-forms.primary-button>Отправить</x-forms.primary-button>
		<x-slot:social>
		</x-slot:social>
        <x-slot:links>
            <div class="text-xxs md:text-xs"><a href="{{ route('register') }}"
                    class="text-white hover:text-white/70 font-bold">Регистрация</a></div>
        </x-slot:links>
    </x-forms.auth-form>
@endsection
