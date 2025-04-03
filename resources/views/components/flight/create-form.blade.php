<x-form modalId="create-flight-modal" :title="'Create Flight'" :formId="'create-flight-form'" :formName="'create-flight'" :action="'/api/flights'">
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