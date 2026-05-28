@props([
    'id',
    'name',
    'placeholder' => '••••••••',
    'autocomplete' => 'new-password',
])

<div x-data="{ show: false, value: '' }" class="relative w-full">
    <input
        id="{{ $id }}"
        name="{{ $name }}"
        x-model="value"
        :type="show ? 'text' : 'password'"
        autocomplete="{{ $autocomplete }}"
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge(['class' => 'block w-full pr-11 border-none bg-transparent py-3 focus:ring-0 text-gray-700']) }}
    />

    <button
        type="button"
        class="absolute right-3 top-1/2 -translate-y-1/2 flex items-center text-gray-500 focus:outline-none"
        x-show="value.length > 0"
        x-cloak
        @click="show = !show"
    >
        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        </svg>
        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.269-2.943-9.543-7a9.956 9.956 0 012.223-3.607m1.855-1.57A9.956 9.956 0 0112 5c4.477 0 8.268 2.943 9.542 7a10.05 10.05 0 01-1.548 3.163m-3.195 2.53A9.955 9.955 0 0112 17c-1.02 0-2.015-.136-2.958-.388" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18" />
        </svg>
    </button>
</div>
