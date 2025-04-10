@props(['optionsId', 'buttonId', 'label', 'data'])
<div {{$attributes->merge(['class'=>"relative inline-block text-left w-full"])}}>
    <div class="flex w-full">
      <button id="{{ $buttonId }}" type="button" class="inline-flex w-full text-start whitespace-nowrap text-gray-400 justify-between gap-x-1.5 rounded-md bg-white px-3 py-2 text-sm ring-1 shadow-xs ring-gray-300 ring-inset hover:bg-gray-50 divide divide-gray-300" id="menu-button" aria-expanded="true" aria-haspopup="true" onclick="toggleOptions('{{ $optionsId }}')">
       {{  $label }}
        <svg class="-mr-1 size-5 text-gray-400 arrow" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
          <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
        </svg>
      </button>
    </div>
  
    <div id="{{ $optionsId }}-div" class="absolute left-0 z-20 max-h-30 w-full overflow-y-auto mt-2 w-56 origin-top-right rounded-md bg-white ring-1 shadow-lg ring-black/5 focus:outline-hidden hidden" role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1" style="white-space: nowrap;">
      <div id="{{ $optionsId }}" class="py-1" role="none"></div>
    </div>
</div>
  