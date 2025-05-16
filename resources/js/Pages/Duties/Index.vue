<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MagnifyingGlass from '@/Components/Icons/MagnifyingGlass.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import { Head, Link, usePage } from '@inertiajs/vue3';

defineProps({
    duties: {
        type: Object,
        required: true
    }
});

</script>

<template>
    <Head title="Duties" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Duties
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">
                                Duties List
                            </h1>
                            <p class="mt-2 text-sm text-gray-700">
                                A list of all Registered Duties.
                            </p>
                        </div>

                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <Link
                                :href="route('assigned-duties.create')"
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                            >
                                Add New
                            </Link>
                        </div>
                    </div>

                    <div class="flex flex-col justify-left sm:flex-row mt-6">
                        <div class="relative text-sm text-gray-800 col-span-3">
                            <div
                                class="absolute pl-2 left-0 top-0 bottom-0 flex items-center pointer-events-none text-gray-500"
                            >
                                <MagnifyingGlass />
                            </div>

                            <input
                                type="text"
                                autocomplete="off"
                                placeholder="Search..."
                                id="search"
                                class="block rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            />
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col">
                        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div
                                class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                            >
                                <div
                                    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative"
                                >
                                    <table
                                        class="min-w-full divide-y divide-gray-300"
                                    >
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    Duty Name
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="relative py-3.5 pl-3 pr-4 sm:pr-6"
                                                />
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 bg-white"
                                        >
                                            <tr v-for="duty in duties.data" :key="duty.id">
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ duty.name }}
                                                </td>

                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium space-x-2 sm:pr-6"
                                                >
                                                <PrimaryButton @click="edit(duty.id)">
                                                    Edit
                                                </PrimaryButton>
                                                <DangerButton @click="openDeleteModal(duty)">
                                                    Delete
                                                </DangerButton>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!-- <Pagination 
                                    :data="assignedDuties" 
                                    :updatedPageNumber="updatedPageNumber"
                                />  -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>