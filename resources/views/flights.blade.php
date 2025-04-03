<x-layout.layout>
    <div class="flex w-full justify-end px-4 sm:px-6 lg:px-8 lg:pt-6">
        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
            <button type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
              Create flight
            </button>
          </div>
    </div>
    <x-flight.table />
    <div id="pagination-component" class="flex items-center justify-between px-8"></div>
</x-layout.layout>