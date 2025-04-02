
<div id="create-city-modal" class="relative z-10 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-500/75 transition-opacity" aria-hidden="true"></div>
  
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
      <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
        <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
            <div class="flex flex-col gap-6">
            <h2 class="text-3xl font-semibold">Create City</h2>
            <form id="create-city-form" name="create-city" class="bg-white" action="/api/cities" method="POST">
                @csrf
                <div class="space-y-12">
                <div class="pb-6">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="col-span-full">
                        <label for="name" class="block text-sm/6 font-medium text-gray-900">Name</label>
                        <div class="mt-2">
                        <input id="create-city-name" type="text" name="name" id="name" autocomplete="name" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="timezone" class="block text-sm/6 font-medium text-gray-900">Timezone</label>
                        <div class="mt-2">
                        <input id="create-city-timezone" type="text" name="timezone" id="timezone" class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                        </div>
                    </div>
                    </div>
                </div>
                </div>
            
                <div class="mt-6 flex items-center justify-end gap-x-6">
                <button type="button" class="text-sm/6 font-semibold text-gray-900" onclick="closeForm('#create-city-modal')">Cancel</button>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </form>
        </div>
         </div>
        </div>
      </div>
    </div>
  </div>
  
<script>
    $(document).ready(function() {
        $.validator.addMethod("validTimezone", function(value, element) {
            return this.optional(element) || /^[A-Za-z]+\/[A-Za-z_]+$/.test(value);
        }, "Please enter a valid timezone (e.g., 'America/New_York' or 'UTC')");

        $("form[name='create-city']").validate({
        errorClass: "text-red-500 text-sm mt-1",
        rules: {
            name: "required",
            timezone: {
                required: true,
                validTimezone: true

            }
        },
        messages: {
            name: "Please enter the city's name",
            timezone: {
                required: "Please enter the city's timezone",
                validTimezone: "Please enter a valid timezone (e.g., 'America/New_York')"
            }
        },
        submitHandler: function(form, event) {
            event.preventDefault()
            const formData = new FormData(form);
            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: formData,
                contentType: false, 
                processData: false,
                success: function(response) {
                    handleSubmit();
                    closeForm('#create-city-modal');
                },
                error: function(xhr) {
                    const error = xhr.responseJSON.error;
                    showErrorNotification(error);
                }
            });
        }
    
        });
    })

</script>




  