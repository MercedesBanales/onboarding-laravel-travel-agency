@props(['active' => false])
<a type="button" class="{{ $active ? 'bg-gray-50' : 'hover:bg-gray-50' }} flex w-full items-center gap-x-3 rounded-md px-6 py-2 text-left text-sm/6 font-semibold text-gray-700 transition-all duration-300" aria-controls="sub-menu-1" aria-expanded="false" {{ $attributes }}>
    {{ $slot }}
</a>