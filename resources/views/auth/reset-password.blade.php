@extends('layouts.auth')

@section('title', 'Обновить пароль')

@section('content')
    <x-forms.auth-form title="Обновить пароль" action="{{route('password.update')}}" method="POST">
        <input type="hidden" name="token" value="{{$token}}">
        <x-forms.text-input type="email" name="email" placeholder="E-mail" required='true' />
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <div>
                <x-forms.text-input type="password" name="password" placeholder="Пароль" required='true' :isError="$errors->has('password')" />
                @error('password')
                    <x-forms.error>{{ $message }}</x-forms.error>
                @enderror
            </div>
            <div>
                <x-forms.text-input type="password" name="password_confirmation" placeholder="Повторно пароль" required='true'
                    :isError="$errors->has('password_confirmation')" />
                @error('password_confirmation')
                    <x-forms.error>{{ $message }}</x-forms.error>
                @enderror
                <div class="mt-3 text-pink text-xxs xs:text-xs"></div>
            </div>
        </div>
        <x-forms.primary-button>Обновить</x-forms.primary-button>
        <x-slot:social>
        </x-slot:social>
        <x-slot:links>
        </x-slot:links>
    </x-forms.auth-form>
@endsection
