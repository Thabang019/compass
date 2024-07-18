@props(['disabled' => false, 'type' => 'text'])

<input 
    type="{{ $type }}" 
    {{ $disabled ? 'disabled' : '' }} 
    {!! $attributes->merge([
        'class' => 'border-2 border-blue-400 focus:ring-2 focus:ring-blue-200  shadow-custom-light'
    ]) !!}
>
