@component('mail::message')
@if (Hash::check($password, $usuario->password))
	Estimando {{ $usuario->nombre }} {{ $usuario->apellido }} su registro fue realizado exitosamente y sus credenciales de acceso son:

	Correo: {{ $usuario->email }}
	Contraseña: {{ $password }}
@else
	Estimando {{ $usuario->nombre }} {{ $usuario->apellido }} su información fue actualizada exitosamente y sus credenciales de acceso son:

	Correo: {{ $usuario->email }}
	SU CONTRASEÑA NO FUE MODIFICADA


@endif
{{-- @component('mail::button', ['url' => route('register')])
{{ __('Create Account') }}
@endcomponent --}}

{{-- {{ __('If you already have an account, you may accept this invitation by clicking the button below:') }} --}}

@component('mail::button', ['url' => route('login')])
{{ __('Iniciar Sesión') }}
@endcomponent

{{-- {{ __('If you did not expect to receive an invitation to this team, you may discard this email.') }} --}}
@endcomponent
