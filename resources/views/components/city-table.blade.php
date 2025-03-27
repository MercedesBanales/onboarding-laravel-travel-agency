
  <div class="px-4 sm:px-6 lg:px-8">
    <div class="flow-root">
      <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
          <div class="overflow-hidden ring-1 shadow-sm ring-black/5 sm:rounded-lg">
            <table class="min-w-full divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th scope="col" class="py-3.5 pr-3 pl-4 text-left text-sm font-semibold text-gray-900 sm:pl-6">ID</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Name</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Number of incoming flights</th>
                  <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Number of outgoing flights</th>
                  <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-6">
                    <span class="sr-only">Edit</span>
                  </th>
                  <th scope="col" class="relative py-3.5 pr-4 pl-3 sm:pr-6">
                    <span class="sr-only">Delete</span>
                  </th>
                </tr>
              </thead>
              <tbody id="city-table-body" class="divide-y divide-gray-200 bg-white">
                </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
    function loadCities() {
        $.ajax({
        url: '/api/cities',
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            let rows = '';
            response.data.forEach(city => {
            rows += `<tr>
                        <td class="py-4 pr-3 pl-4 text-sm font-medium whitespace-nowrap text-gray-900 sm:pl-6">${city.id}</td>
                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">${city.name}</td>
                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">${city.arrival_flights.length}</td>
                        <td class="px-3 py-4 text-sm whitespace-nowrap text-gray-500">${city.departure_flights.length}</td>
                        <td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                        </td>
                        <td class="relative py-4 pr-4 pl-3 text-right text-sm font-medium whitespace-nowrap sm:pr-6">
                            <a href="#" class="text-indigo-600 hover:text-indigo-900">Delete</a>
                        </td>
                        </tr>`;
            });
            $('#city-table-body').html(rows);
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
        }
        });
    }

    $(document).ready(function() {
        loadCities();
    });
</script>


