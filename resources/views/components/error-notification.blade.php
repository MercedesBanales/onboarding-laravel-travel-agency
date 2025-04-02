<div id="error-notification" class="z-20 fixed top-0 right-0 mt-4 mr-4 rounded-md bg-red-50 p-4 shadow-lg transition-transform transform translate-x-full opacity-0 duration-200 ease-in-out">
  <div class="flex">
    <div class="shrink-0">
      <button onclick="closeErrorNotification()">
        <svg class="size-5 text-red-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
          <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z" clip-rule="evenodd" />
        </svg>
    </button>
    </div>
    <div class="ml-3">
      <h3 id="num-errors" class="text-sm font-medium text-red-800"></h3>
      <div class="mt-2 text-sm text-red-700">
        <ul id="errors-list" role="list" class="list-disc space-y-1 pl-5">
        </ul>
      </div>
    </div>
  </div>
</div>
