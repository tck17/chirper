<!-- Form to create new Chirps-->

<!-- Script section where dependencies are imported and properties are defined -->
<script setup>
// Import necessary components and utilities
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'; // Import the AuthenticatedLayout component
import Chirp from '@/Components/Chirp.vue'; // Import the Chirp component
import InputError from '@/Components/InputError.vue'; // Import the InputError component
import PrimaryButton from '@/Components/PrimaryButton.vue'; // Import the PrimaryButton component
import { useForm, Head } from '@inertiajs/vue3'; // Import the useForm and Head utilities from Inertia.js

// Define the properties received by the component, in this case 'chirps'
defineProps(['chirps']);

// Initialize the form using the useForm hook
const form = useForm({
    message: '', // Initialize the 'message' field of the form
});
</script>
 
<!-- Template section -->
<template>
    <!-- Set the page title using Inertia's Head utility -->
    <Head title="Chirps" />
 
    <!-- Include the AuthenticatedLayout component -->
    <AuthenticatedLayout>
        <!-- Main content container -->
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <!-- Form for creating new chirps -->
            <form @submit.prevent="form.post(route('chirps.store'), { onSuccess: () => form.reset() })">
                <!-- Textarea for entering chirp message -->
                <textarea
                    v-model="form.message"
                    placeholder="What's on your mind?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ></textarea>
                <!-- Display input error message if any -->
                <InputError :message="form.errors.message" class="mt-2" />
                <!-- Button to submit the form -->
                <PrimaryButton class="mt-4">Chirp</PrimaryButton>
            </form>

            <!-- Container for displaying existing chirps -->
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <!-- Render Chirp component for each chirp in 'chirps' array -->
                <Chirp
                    v-for="chirp in chirps"
                    :key="chirp.id" 
                    :chirp="chirp"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>