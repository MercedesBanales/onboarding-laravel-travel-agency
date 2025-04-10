<x-table id="airline-table-component" :bodyId="'airline-table-body'">
    @slot('sortById')
    @endslot

    @slot('remainingColumns')
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Number of Flights</th>
    @endslot
</x-table>
  
  <script>
    function createAirlineRow(airline) {
      return `
          <tr>
            <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-6">${airline.id}</td>
            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">${airline.name}</td>
            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">${airline.description}</td>
            <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">${airline.flights.length}</td>
            <td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6">
                <button class="text-indigo-600 hover:text-indigo-900 edit-airline-btn" data-airline='${JSON.stringify(airline).replace(/'/g, "&apos;")}'>Edit</button>
            </td>
            <td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6">
                <button class="text-indigo-600 hover:text-indigo-900" onclick="handleAirlineDelete(${airline.id}, '${airline.name}')">Delete</button>
            </td>
          </tr>
        `
    }

    function updatePagination(currentPage, totalPages) {
      const paginationComponent = document.getElementById('pagination-component');

      let pageLinks = '';
      for (let i = 1; i <= totalPages; i++) {
        pageLinks += `<button class="inline-flex items-center border-t-2 ${i === currentPage ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'} px-4 pt-4 text-sm font-medium" onclick="loadAirlines(${i})">${i}</button>`;
      }      
      
      paginationComponent.innerHTML = `
            <div class="-mt-px flex w-0 flex-1">
            <button onclick="loadAirlines(${currentPage - 1})" 
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
              <button onclick="loadAirlines(${currentPage + 1})" 
                                  class="inline-flex items-center border-t-2 border-transparent pt-4 pr-1 text-sm font-medium text-gray-500 hover:text-gray-700 ${currentPage === totalPages ? 'disabled:text-gray-300 cursor-not-allowed' : ''}" 
                                  ${currentPage === totalPages ? 'disabled' : ''}>                      
                                  Next
                    <svg class="mr-3 size-5 ${currentPage === totalPages ? 'text-gray-300' : 'text-gray-400'}" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true" data-slot="icon">
                        <path fill-rule="evenodd" d="M2 10a.75.75 0 0 1 .75-.75h12.59l-2.1-1.95a.75.75 0 1 1 1.02-1.1l3.5 3.25a.75.75 0 0 1 0 1.1l-3.5 3.25a.75.75 0 1 1-1.02-1.1l2.1-1.95H2.75A.75.75 0 0 1 2 10Z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        `;
    }

    $(document).ready(function() {
        $(document).on("click", ".edit-airline-btn", function() {
            const airline = JSON.parse($(this).attr("data-airline"));
            handleAirlineEdit(airline);
        });
        
        loadAirlines(1, '');
    });

    function handleAirlineEdit(airline) {
        loadOptions('#options-body-edit', 'edit', airline.enabledCities);
        openForm('edit-airline-modal');
        $('#edit-airline-form').attr('action', `/api/airlines/${airline.id}`);
        $('#edit-airline-name').attr('placeholder', airline.name);
        $('#edit-airline-description').attr('placeholder', airline.description);

    }

const handleAirlineDelete = (airlineId, airlineName) => {
      const title = `Delete ${airlineName}`;
      const message = "Are you sure you want to delete this airline? It will be permanently removed from our servers. This action cannot be undone."
      $('#confirmation-dialog').attr('url', 'airlines');
      openConfirmationDialog(title, message, airlineId);
    }
</script>


