<x-table id="city-table-component" sort-criteria='' :bodyId="'city-table-body'">
  @slot('sortById')
    <button id="id-sort" class="flex" onclick="handleSort('id')" data-state='unsorted'>
      <span id="id-not-sorted" class="ml-2 flex-none rounded-sm bg-gray-100 text-gray-900 group-hover:bg-gray-200">
        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
          <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
        </svg>
      </span>
      <span id="id-sorted" class="ml-2 flex-none rounded-sm bg-gray-100 text-gray-900 group-hover:bg-gray-200 hidden">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
          <path fill-rule="evenodd" d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z" clip-rule="evenodd" />
        </svg>                          
      </span>
    </button>
  @endslot
  @slot('remainingColumns')
    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
      <div class="flex">
      Name
      <button id="name-sort" class="flex" onclick="handleSort('name')" data-state="unsorted">
        <span id="name-not-sorted"  class="ml-2 flex-none rounded-sm bg-gray-100 text-gray-900 group-hover:bg-gray-200">
          <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
            <path fill-rule="evenodd" d="M5.22 8.22a.75.75 0 0 1 1.06 0L10 11.94l3.72-3.72a.75.75 0 1 1 1.06 1.06l-4.25 4.25a.75.75 0 0 1-1.06 0L5.22 9.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
          </svg>                      
        </span>
        <span id="name-sorted" class="ml-2 flex-none rounded-sm bg-gray-100 text-gray-900 group-hover:bg-gray-200 hidden">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="size-5">
            <path fill-rule="evenodd" d="M9.47 6.47a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 1 1-1.06 1.06L10 8.06l-3.72 3.72a.75.75 0 0 1-1.06-1.06l4.25-4.25Z" clip-rule="evenodd" />
          </svg>
        </span>
      </button>
    </div>
    </th>
    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Number of incoming flights</th>
    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Number of outgoing flights</th>
  @endslot
</x-table>
  
  <script>
    const allSortCriteria = ['id', 'name'];

    async function loadCities(page = 1, sort = '', filter = '') {
    try {
        const response = await getCities(page, sort, filter); 

        let rows = '';
        const totalPages = response.pagination.totalPages;

        response.data.forEach(city => {
            rows += createCityRow(city);
        });

        $('#city-table-body').html(rows);
        $('#city-table-component').attr('current-page', page);
        updatePagination(page, totalPages, sort);
    } catch (error) {
        console.error('Error cargando ciudades:', error);
    }
}

    function createCityRow(city) {
      return `
          <tr>
            <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-6">${city.id}</td>
            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">${city.name}</td>
            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">${city.arrival_flights.length}</td>
            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">${city.departure_flights.length}</td>
            <td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6">
                <button class="text-indigo-600 hover:text-indigo-900" onclick="handleEdit(${city.id}, '${city.name}', '${city.timezone}')">Edit</button>
            </td>
            <td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6">
                <button class="text-indigo-600 hover:text-indigo-900" onclick="handleDelete(${city.id}, '${city.name}')">Delete</button>
            </td>
          </tr>
        `
    }

    function updatePagination(currentPage, totalPages, sortCriteria) {
      const paginationComponent = $('#pagination-component');
      const filterCriteria = $('#city-table-component').attr('filter-criteria') ?? ''

      let pageLinks = '';
      for (let i = 1; i <= totalPages; i++) {
        pageLinks += `<button class="inline-flex items-center border-t-2 ${i === currentPage ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'} px-4 pt-4 text-sm font-medium" onclick="loadCities(${i}, '${sortCriteria}', '${filterCriteria}')">${i}</button>`;
      }      
      
      paginationComponent.html(`
            <div class="-mt-px flex w-0 flex-1">
            <button onclick="loadCities(${currentPage - 1}, '${sortCriteria}', '${filterCriteria}')" 
                    class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:text-gray-700 ${currentPage === 1 ? 'disabled:text-gray-300 cursor-not-allowed' : ''}" 
                    ${currentPage === 1 ? 'disabled' : ''}>                    
                    <svg class="mr-3 size-5 ${currentPage === 1 ? 'text-gray-300' : 'text-gray-400'}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M18 10a.75.75 0 0 1-.75.75H4.66l2.1 1.95a.75.75 0 1 1-1.02 1.1l-3.5-3.25a.75.75 0 0 1 0-1.1l3.5-3.25a.75.75 0 1 1 1.02 1.1l-2.1 1.95h12.59A.75.75 0 0 1 18 10Z" clip-rule="evenodd" />
                    </svg>
                    Previous
                </button>
            </div>
            <div class="hidden md:-mt-px md:flex">
                ${pageLinks}
            </div>
            <div class="-mt-px flex w-0 flex-1 justify-end">
              <button onclick="loadCities(${currentPage + 1}, '${sortCriteria}', '${filterCriteria}')" 
                                  class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:text-gray-700 ${currentPage === totalPages ? 'disabled:text-gray-300 cursor-not-allowed' : ''}" 
                                  ${currentPage === totalPages ? 'disabled' : ''}>                      
                                  Next
                    <svg class="mr-3 size-5 ${currentPage === totalPages ? 'text-gray-300' : 'text-gray-400'}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M2 10a.75.75 0 0 1 .75-.75h12.59l-2.1-1.95a.75.75 0 1 1 1.02-1.1l3.5 3.25a.75.75 0 0 1 0 1.1l-3.5 3.25a.75.75 0 1 1-1.02-1.1l2.1-1.95H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        `);
    }

    const handleSort = (criteria) => {
      const currentPage = parseInt($('#city-table-component').attr('current-page'));
      const sortButton = $(`#${criteria}-sort`);
      const unsorted = sortButton.attr('data-state') === 'unsorted';
      $('#city-table-component').attr('sort-criteria', unsorted ? criteria : '');

      sortButton.attr('data-state', unsorted ? 'sorted' : 'unsorted');

      $(`#${criteria}-sorted`).toggleClass('hidden');
      $(`#${criteria}-not-sorted`).toggleClass('hidden');

      allSortCriteria.forEach( (crit) => {
        if (crit!==criteria) {
          $(`#${crit}-sorted`).addClass('hidden');
          $(`#${crit}-not-sorted`).removeClass('hidden');
          $(`#${crit}-sort`).attr('data-state', 'unsorted');
        }
      });

      const filterCriteria = $('#city-table-component').attr('filter-criteria');
      loadCities(currentPage, unsorted ? criteria : '', filterCriteria);
    }

    const handleEdit = (cityId, cityName, cityTimezone) => {
      openForm('edit-city-modal');
      $('#edit-city-form').attr('action', `/api/cities/${cityId}`);
      $('#edit-city-name').attr('placeholder', cityName);
      $('#edit-city-timezone').attr('placeholder', cityTimezone);
    }


    const handleDelete = (cityId, cityName) => {
      const title = `Delete ${cityName}`;
      const message = "Are you sure you want to delete this city? It will be permanently removed from our servers. This action cannot be undone."
      $('#confirmation-dialog').attr('url', 'cities');
      openConfirmationDialog(title, message, cityId);
    }

    $(document).ready(function() {
      loadCities();
});
</script>


