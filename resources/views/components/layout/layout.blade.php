<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Travel Agency</title>
        
        <!-- Styles / Scripts -->
        @vite('resources/css/app.css')

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    </head>
    <body class="flex w-full items-start justify-center">      
        <div id="side-bar" class="flex flex-col gap-y-5 overflow-y-auto border-r border-gray-200 bg-white w-1/6 h-full transition-all duration-300 w-64">
            <button id="menu-button" class="flex h-16 shrink-0 items-center px-4 justify-end duration-300 ease-in" onclick="toggleSideBar()">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6 shrink-0">
                <path fill-rule="evenodd" d="M3 6.75A.75.75 0 0 1 3.75 6h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 6.75ZM3 12a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75A.75.75 0 0 1 3 12Zm0 5.25a.75.75 0 0 1 .75-.75h16.5a.75.75 0 0 1 0 1.5H3.75a.75.75 0 0 1-.75-.75Z" clip-rule="evenodd" />
              </svg>                          
            </button>
            <nav class="flex flex-1 flex-col">
              <ul role="list" class="flex flex-1 flex-col gap-y-7">
                <li>
                  <ul role="list" class="-mx-2">
                    <li>
                        <div>
                          <x-nav-button href="{{ route('cities') }}" :active="request()->is('cities')" >
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12.75 3.03v.568c0 .334.148.65.405.864l1.068.89c.442.369.535 1.01.216 1.49l-.51.766a2.25 2.25 0 0 1-1.161.886l-.143.048a1.107 1.107 0 0 0-.57 1.664c.369.555.169 1.307-.427 1.605L9 13.125l.423 1.059a.956.956 0 0 1-1.652.928l-.679-.906a1.125 1.125 0 0 0-1.906.172L4.5 15.75l-.612.153M12.75 3.031a9 9 0 0 0-8.862 12.872M12.75 3.031a9 9 0 0 1 6.69 14.036m0 0-.177-.529A2.25 2.25 0 0 0 17.128 15H16.5l-.324-.324a1.453 1.453 0 0 0-2.328.377l-.036.073a1.586 1.586 0 0 1-.982.816l-.99.282c-.55.157-.894.702-.8 1.267l.073.438c.08.474.49.821.97.821.846 0 1.598.542 1.865 1.345l.215.643m5.276-3.67a9.012 9.012 0 0 1-5.276 3.67m0 0a9 9 0 0 1-10.275-4.835M15.75 9c0 .896-.393 1.7-1.016 2.25" />
                            </svg>
                            <label class="sidebar-label">Cities</label>
                          </x-nav-button>
                        </div>
                      </li>
                    <li>
                      <div>
                        <x-nav-button href="{{ route('airlines') }}" :active="request()->is('airlines')" >                            
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 shrink-0">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                              </svg>
                              <label class="sidebar-label">Airlines</label>
                          </x-nav-button>
                      </div>
                    </li>
                    <li>
                      <div>
                        <x-nav-button href="{{ route('flights') }}"  :active="request()->is('flights')" >                            
                          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 shrink-0">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                          </svg>
                          <label class="sidebar-label">Flights</label>
                        </x-nav-button>
                      </div>
                    </li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
          <div id="main-content" class="flex flex-col flex-1 h-full w-full gap-4 bg-gray-100">
            <div class="bg-white px-4 sm:px-6 py-4 lg:px-8 border-b border-gray-200 flex w-full items-center">
              <div class="flex flex-col w-full gap-8">
                <h1 class="text-3xl font-bold tracking-tight text-gray-900 font-extralight">{{ $title }}</h1>
                {{ $filters }}
              </div>
            </div>
            <div class="flex flex-col w-full gap-4">
              {{  $slot }}
            </div>
          </div>
          <x-confirmation-dialog />
          <x-error-notification />
          <x-success-notification />

    </body>
</html>

<script>
    let isCollapsed = false;
    let cityFilterIds = [];
    let numActiveFlightsFilter = null;

    const toggleSideBar = () => {
      const sidebar = $('#side-bar');
      const menuButton = $('#menu-button');
      const labels = sidebar.find('.sidebar-label');

      isCollapsed = !isCollapsed;

      if (!isCollapsed) {
          sidebar.removeClass('w-64');
          sidebar.addClass('w-14');
          labels.each(function (){
            $(this).addClass('hidden');
          })
          menuButton.removeClass('justify-end');
          menuButton.addClass('justify-center');
      } else {
          sidebar.removeClass('w-14');
          sidebar.addClass('w-64');
          labels.each(function() {
            $(this).removeClass('hidden');
          })
          menuButton.removeClass('justify-center');
          menuButton.addClass('justify-end');
      }
    }

    const openForm = (modalId) => {
        $(`#${modalId}`).show();
    }

    const closeForm = (modalId) => {
        $(`#${modalId}`).hide();
    }

    const getCities = (page = null, sort = '', filter = '') => {
      return new Promise((resolve, reject) => {
          $.ajax({
              url: `/api/cities?page=${page}&sort=${sort}&filter[airline_name]=${filter}`,
              type: 'GET',
              dataType: 'json',
              success: function(response) {
                  resolve(response); 
              },
              error: function(xhr, status, error) {
                  console.error('Error:', error);
                  reject(error);
              }
          });
      });
  };

    function loadAirlines(page = 1) {
      getAirlines(page)
          .then(response => {
              let rows = '';
              const totalPages = response.pagination.totalPages;
              const airlines = response.data;

              airlines.forEach(airline => {
                  rows += createAirlineRow(airline);
              });

              document.getElementById('airline-table-body').innerHTML = rows;
              updatePagination(page, totalPages);
          })
          .catch(error => console.error('Error:', error));
    }

    const getAirlines = async (page=null) => {
      let url = `/api/airlines?page=${page}`;
      cityFilterIds.forEach(id => { url += `&filter[city_id]=${id}` })
      if (numActiveFlightsFilter) url += `&filter[num_active_flights]=${numActiveFlightsFilter}`;

      return fetch(url)
          .then(response => {
              if (!response.ok) {
                  throw new Error('Network response was not ok');
              }
              return response.json();
          })
          .catch(error => {
              console.error('Error:', error);
              throw error; 
        });
      };

    function loadFlights(page=1) {
      axios.get(`/api/flights?page=${page}`, { responseType: "json" })
          .then(response => {
              let rows = '';
              const totalPages = response.data.pagination.totalPages;
              const flights = response.data.data;

              flights.forEach(flight => {
                  rows += createFlightRow(flight);
              });

              $('#flight-table-body').html(rows);
              updatePagination(page, totalPages); 
          })
          .catch(err => {
              console.error('Error:', err);
          });
      }

    const openConfirmationDialog = (title, message, elementId) => {
      $('#confirmation-dialog').show();
      $('#confirmation-dialog').attr('elementId', elementId);
      $('#delete-title').text(title);
      $('#delete-message').text(message);
    }

    const closeConfirmationDialog = () => {
      $('#confirmation-dialog').hide();
    }

    const showSuccessNotification = (successMessage) => {
        $('#success-message').text(successMessage);
        $('#success-notification')
            .removeClass('translate-x-full opacity-0')
            .addClass('translate-x-0 opacity-100');
        setTimeout(() => {
            closeSuccessNotification();
        }, 6000);
    }

    const closeSuccessNotification = () => {
        $('#success-notification')
          .removeClass('translate-x-0 opacity-100')
          .addClass('translate-x-full opacity-0');
    };

    const showErrorNotification = (error) => {
      setErrorMessage(error);
      $('#error-notification')
          .removeClass('translate-x-full opacity-0')
          .addClass('translate-x-0 opacity-100');
      setTimeout(() => {
          closeErrorNotification();
      }, 6000);
    };

    const setErrorMessage = (error) => {
      let errorMessage = error.message;
      const numErrors = Object.keys(error.fields).length;
      if (numErrors!==0) {
        let errorMessage = `There were ${numErrors} errors with your submission`;
        if (numErrors===1) errorMessage = `There was 1 error with your submission`;
        $('#num-errors').text(errorMessage);

        const errorsList = $('#errors-list');
        let errors = '';
        Object.entries(error.fields).forEach(([key, messages]) => {
          messages.forEach((msg) => {
            errors += `<li>${msg}</li>`;
          });
        });
        errorsList.html(errors);
      }
    }

    const closeErrorNotification = () => {
        $('#error-notification')
          .removeClass('translate-x-0 opacity-100')
          .addClass('translate-x-full opacity-0');
    };

    const clearFormFields = (formId) => {
      $(formId).find('input').val('');
    }

    function debounce(func, timeout = 300){
      let timer;
      return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => { func.apply(this, args); }, timeout);
      };
    }
</script>