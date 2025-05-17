<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import MagnifyingGlass from '@/Components/Icons/MagnifyingGlass.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import DangerButton from '@/Components/DangerButton.vue';
import Pagination from '@/Components/Pagination.vue';
import Modal from '@/Components/Modal.vue';
import { Head, Link, router, useForm, usePage } from '@inertiajs/vue3';
import { ref, computed, watch } from 'vue';


defineProps({
    officers: {
        type: Object,
        required: true
    }
});

const showModalDelete = ref(false);

const form = useForm({
    id: null,
    name: ''
});

const edit = (id) => {
    router.get(route('officers.edit', id));
}

const openDeleteModal = (officers) => {
    form.id = officers.id;
    form.name = officers.name;

    showModalDelete.value = true;
}

const saveDelete = () => {
    form.delete(route('officers.destroy', form.id), {
        preserveScroll: true,
        onSuccess: () => {
            showModalDelete.value = false;
        }
    })
}

//searchbar

let pageNumber = ref(1),
    search = ref(usePage().props.search ?? "")

const updatedPageNumber = (link) => {
    pageNumber.value = link.url.split('=')[1];
}

let url = computed(() => {
    let url = new URL(route('officers.index'));
    url.searchParams.set('page', pageNumber.value);

    if (search.value) {
        url.searchParams.append('search', search.value);
    }


    return url
});

watch(
    () => url.value,
    (updatedUrl) => {
        router.visit(updatedUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true
        })
    }
)

watch(
    () => search.value,
    (value) => {
        if (value) {
            pageNumber.value = 1;
        }
    }
)


</script>

<template>
    <Head title="Officers" />
    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Officers
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">
                                Officers List
                            </h1>
                            <p class="mt-2 text-sm text-gray-700">
                                A list of all Registered Officers.
                            </p>
                        </div>

                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <Link
                                :href="route('officers.create')"
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
                                v-model="search"
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
                                                    Officer Name
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
                                            <tr v-for="officer in officers.data" :key="officer.id">
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ officer.name }}
                                                </td>

                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium space-x-2 sm:pr-6"
                                                >
                                                <PrimaryButton @click="edit(officer.id)">
                                                    Edit
                                                </PrimaryButton>
                                                <DangerButton @click="openDeleteModal(officer)">
                                                    Delete
                                                </DangerButton>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Pagination 
                                    :data="officers" 
                                    :updatedPageNumber="updatedPageNumber"
                                /> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

    
    <Modal :show="showModalDelete" @close="showModalDelete = false" maxWidth="lg" :closeable="true">
        <template #default>
            <div class="p-6 w-[30rem]">
                <div class="flex items-center justify-start space-x-4">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                        </svg>
                    </div>
                    
                    <h2 class="text-lg font-semibold">Delete Officer ?</h2>
                </div>

                <p class="mt-4 text-md text-gray-600 text-left">
                    Are you sure you want to delete officer
                    <strong>{{ form.name }}</strong>
                </p>
                <div class="mt-6 flex justify-end gap-4">
                    <SecondaryButton @click="showModalDelete = false" class="btn btn-secondary">
                        Don't Delete
                    </SecondaryButton>
                    <form @submit.prevent="saveDelete">
                        <DangerButton :disabled="form.processing">Delete Officer</DangerButton>
                    </form>
                </div>
            </div>
        </template>
    </Modal>
</template>