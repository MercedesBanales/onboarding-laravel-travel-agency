<x-form modalId="create-city-modal" :title="'Create City'" :formId="'create-city-form'" :formName="'create-city'" :action="'/api/cities'">
    @slot('inputs')
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
    @endslot
</x-form>
  
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
            console.log($(form).attr('method'))
            $.ajax({
                url: $(form).attr('action'),
                type: $(form).attr('method'),
                data: formData,
                contentType: false, 
                processData: false,
                success: function(response) {
                    handleSubmit();
                    showSuccessNotification("City successfully created.");
                    closeForm('create-city-modal');
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




  