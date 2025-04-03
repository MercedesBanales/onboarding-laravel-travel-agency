<x-layout.layout>
    <div class="flex w-full justify-end px-4 sm:px-6 lg:px-8 lg:pt-6">
      <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
        <button type="button" onclick="openForm('create-city-modal')" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
          Create city
        </button>
      </div>
    </div>
    <div class="px-4 sm:px-6 lg:px-8">
      <div class="-mr-px grid grow grid-cols-1 focus-within:relative">
        <input type="text" name="query" id="query" onkeyup="filterByAirline()" class="col-start-1 row-start-1 block w-full rounded-l-md bg-white py-1.5 pr-3 pl-10 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:pl-9 sm:text-sm/6" placeholder="Airline name">
        <svg class="pointer-events-none col-start-1 row-start-1 ml-3 size-5 self-center text-gray-400 sm:size-4" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path d="M8.5 4.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0ZM10.9 12.006c.11.542-.348.994-.9.994H2c-.553 0-1.01-.452-.902-.994a5.002 5.002 0 0 1 9.803 0ZM14.002 12h-1.59a2.556 2.556 0 0 0-.04-.29 6.476 6.476 0 0 0-1.167-2.603 3.002 3.002 0 0 1 3.633 1.911c.18.522-.283.982-.836.982ZM12 8a2 2 0 1 0 0-4 2 2 0 0 0 0 4Z" />
        </svg>
      </div>
    </div>
    <x-city.table />
    <div id="pagination-component" class="flex items-center justify-between px-8"></div>
</x-layout.layout>
<x-city.create-form />
<x-city.edit-form />

<script>
    const filterByAirline = debounce(() => {
      const airlineName = document.getElementById('query').value ?? '';
      const currentPage = parseInt($('#city-table-component').attr('current-page'))
      const sortCriteria = $('#city-table-component').attr('sort-criteria')
      const encodedName = encodeURIComponent(airlineName);  
      $('#city-table-component').attr('filter-criteria', encodedName);
      loadCities(currentPage, sortCriteria, encodedName);
    });

    const handleSubmit = (successMessage) => {
        const currentPage = parseInt($('#city-table-component').attr('current-page'))
        const sortCriteria = $('#city-table-component').attr('sort-criteria')
        const filterCriteria = $('#city-table-component').attr('filter-criteria')
        loadCities(currentPage, sortCriteria, filterCriteria);
    }
    
</script>

