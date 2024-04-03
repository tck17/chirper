<!-- Component for displaying an individual Chirp -->

<!-- Script section where dependencies are imported and properties are configured -->
<script setup>
// Importing necessary components and libraries
import Dropdown from './Dropdown.vue'; // Import the Dropdown component from the Dropdown.vue file
import DropdownLink from './DropdownLink.vue'; // Import the DropdownLink component from the DropdownLink.vue file
import InputError from './InputError.vue'; // Import the InputError component from the InputError.vue file
import PrimaryButton from './PrimaryButton.vue'; // Import the PrimaryButton component from the PrimaryButton.vue file
import dayjs from 'dayjs'; // Import the dayjs library for date handling
import relativeTime from 'dayjs/plugin/relativeTime'; // Import the relativeTime plugin from dayjs to display relative time
import { useForm } from '@inertiajs/vue3'; // Import the useForm hook from Inertia.js to handle the form
import { ref } from 'vue'; // Import the ref function from Vue to create a reactive reference

dayjs.extend(relativeTime); // Extend dayjs with the relativeTime plugin to use relative time functionality

// Define the properties received by the component, in this case 'chirp'
const props = defineProps(['chirp']);

// Initialize the form using the useForm hook, with the chirp message as the initial value
const form = useForm({
    message: props.chirp.message,
});

// Create a reactive reference to control whether the chirp is being edited or not
const editing = ref(false);
</script>
 
<!-- Template of the component -->
<template>
    <!-- Main container of the chirp -->
    <div class="p-6 flex space-x-2">
        <!-- User icon -->
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
        </svg>
        <!-- Container for the chirp content -->
        <div class="flex-1">
            <!-- User information section -->
            <div class="flex justify-between items-center">
                <div>
                    <!-- Name of the user who made the chirp -->
                    <span class="text-gray-800">{{ chirp.user.name }}</span>
                    <!-- Time elapsed since the chirp creation -->
                    <small class="ml-2 text-sm text-gray-600">{{ dayjs(chirp.created_at).fromNow() }}</small>
                    <!-- Indicates if the chirp was edited if the creation date is different from the update date -->
                    <small v-if="chirp.created_at !== chirp.updated_at" class="text-sm text-gray-600"> &middot; edited</small>
                </div>
                <!-- Dropdown menu for editing options, visible only if the current user is the owner of the chirp -->
                <Dropdown v-if="chirp.user.id === $page.props.auth.user.id">
                    <!-- Trigger button for the dropdown menu -->
                    <template #trigger>
                        <button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </button>
                    </template>
                    <!-- Content of the dropdown menu, containing an 'Edit' button and a DropdownLink for 'Delete'-->
                    <template #content>
                        <!-- Button to trigger editing -->
                        <button class="block w-full px-4 py-2 text-left text-sm leading-5 text-gray-700 hover:bg-gray-100 focus:bg-gray-100 transition duration-150 ease-in-out" @click="editing = true">
                            Edit
                        </button>
                        <!-- Dropdown link for deleting -->
                        <DropdownLink as="button" :href="route('chirps.destroy', chirp.id)" method="delete">
                            Delete
                        </DropdownLink>
                    </template>
                </Dropdown>
            </div>
            <!-- Form for editing the chirp, visible only when editing is true -->
            <form v-if="editing" @submit.prevent="form.put(route('chirps.update', chirp.id), { onSuccess: () => editing = false })">
                <!-- Textarea for editing the chirp message -->
                <textarea v-model="form.message" class="mt-4 w-full text-gray-900 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <!-- Display input error message if any -->
                <InputError :message="form.errors.message" class="mt-2" />
                <!-- Buttons for saving or canceling the edit -->
                <div class="space-x-2">
                    <!-- Button to save changes -->
                    <PrimaryButton class="mt-4">Save</PrimaryButton>
                    <!-- Button to cancel edit -->
                    <button class="mt-4" @click="editing = false; form.reset(); form.clearErrors()">Cancel</button>
                </div>
            </form>
            <!-- Display the chirp message when not editing -->
            <p v-else class="mt-4 text-lg text-gray-900">{{ chirp.message }}</p>
        </div>
    </div>
</template>
