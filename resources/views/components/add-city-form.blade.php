<div id="add-city-modal" class="fixed inset-0 flex items-center justify-center hidden">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
        <form id="city-form" class="bg-white" action="/api/cities" method="POST">
            @csrf
            <div class="space-y-12">
              <div class="pb-6">
                <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                  <div class="col-span-full">
                    <label for="name" class="block text-sm/6 font-medium text-gray-900">Name</label>
                    <div class="mt-2">
                      <input type="text" name="name" id="name" autocomplete="name" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                    @error('name')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                  </div>
                  <div class="col-span-full">
                    <label for="timezone" class="block text-sm/6 font-medium text-gray-900">Timezone</label>
                    <div class="mt-2">
                      <input type="text" name="timezone" id="timezone" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                    </div>
                    @error('timezone')
                        <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                    @enderror
                  </div>
                </div>
            </div>
            </div>
          
            <div class="mt-6 flex items-center justify-end gap-x-6">
              <button type="button" class="text-sm/6 font-semibold text-gray-900" onclick="closeCityForm()">Cancel</button>
              <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#city-form').on('submit', function(e) {
            e.preventDefault();

            const form = $(this);
            const formData = new FormData(this);

            $.ajax({
                url: form.attr('action'),
                type: form.attr('method'),
                data: formData,
                contentType: false, 
                processData: false,
                success: function(response) {
                    handleSubmit();
                },
                error: function(xhr) {
                    const errors = xhr.responseJSON.error.fields;
                    handleValidationErrors(errors); 
                }
            });
        });
    });

    function handleValidationErrors(errors) {
        $('.error').remove();

        if (errors.name) {
            $('#name').after('<p class="error text-xs text-red-500 font-semibold mt-1">' + errors.name.join(', ') + '</p>');
        }

        if (errors.timezone) {
            $('#timezone').after('<p class="error text-xs text-red-500 font-semibold mt-1">' + errors.timezone.join(', ') + '</p>');
        }
    }

    function handleSubmit() {
        $('.error').remove();
        loadCities();
        closeCityForm();
    }

    const closeCityForm = () => {
        const sideBar = document.getElementById('side-bar');
        const mainContent = document.getElementById('main-content');
        const cityForm = document.getElementById('add-city-modal');

        sideBar.classList.remove('opacity-25');
        mainContent.classList.remove('opacity-25');
        cityForm.classList.add('hidden');
    }
</script>




  