<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="w-full mb-8 grid grid-cols-3 gap-4">
                    <div class="bg-green-500 text-white p-4 border-gray-300 rounded shadow flex justify-between">
                        <p>Total Completed Duties: </p>
                    </div>
                    <div class="bg-red-500 text-white p-4 border-gray-300 rounded shadow flex justify-between">
                        <p>Total Pending Duties: </p>
                    </div>
                    <div class="bg-blue-500 text-white p-4 border-gray-300 rounded shadow flex justify-between">
                        <p>Total Officers: </p>
                    </div>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
