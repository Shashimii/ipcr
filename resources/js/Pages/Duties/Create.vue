<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import { Head, useForm, router } from '@inertiajs/vue3';

const form = useForm({
    name: '',
})

const saveDuty = () => {
    form.post(route('duties.store'), {
        onFinish: () => {
            form.reset();
        },
        preserveScroll: true,
        preserveState: true,
    });
};

const cancel = () => {
    router.visit('/duties');
    form.reset();
}



</script>

<template>
    <Head title="Assign Duty" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Add New Duty
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                            <form @submit.prevent="saveDuty">
                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                                        <div>
                                            <h3
                                                class="text-lg leading-6 font-medium text-gray-900"
                                            >
                                                Duty Information
                                            </h3>
                                            <p class="mt-1 text-sm text-gray-500">
                                                Use this form to add new duty.
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-6 gap-6">

                                            <div class="col-span-6 sm:col-span-3">
                                                <InputLabel for="duty_name" value="Duty Name" />
                                                <TextInput 
                                                    id="duty_name"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    v-model="form.name"
                                                    placeholder="Enter Duty Name"
                                                />
                                                <InputError class="mt-2" :message="form.errors.name" />
                                            </div>

                                        </div>
                                    </div>
                                    <div
                                        class="px-4 py-3 bg-gray-50 text-right space-x-3 sm:px-6"
                                    >
                                        <SecondaryButton @click="cancel">
                                            Cancel
                                        </SecondaryButton>
                                        <PrimaryButton :disabled="form.processing">
                                            Add new Duty
                                        </PrimaryButton>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
