<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Datepicker from '@/Components/Datepicker.vue';
import Checkbox from '@/Components/Checkbox.vue';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

import { Head, useForm, router } from '@inertiajs/vue3';

defineProps({
    officers: {
        type: Object,
        required: true
    },

    duties: {
        type: Object,
        required: true
    },
})

const form = useForm({
    officer_id: '',
    duty_id: '',
    odts_code: '',
    assigned_at: '',
    is_done: false
})

const saveAssignedDuty = () => {
    form.post(route('assigned-duties.store'), {
        onFinish: () => {
            form.reset();
        },
        preserveScroll: true,
        preserveState: true,
    });
};

const cancel = () => {
    router.visit('/assigned-duties');
    form.reset();
}



</script>

<template>
    <Head title="Assign Task" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Assign Task
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                            <form @submit.prevent="saveAssignedDuty">
                                <div class="shadow sm:rounded-md sm:overflow-hidden">
                                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                                        <div>
                                            <h3
                                                class="text-lg leading-6 font-medium text-gray-900"
                                            >
                                                Task Information
                                            </h3>
                                            <p class="mt-1 text-sm text-gray-500">
                                                Use this form to assign new task.
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-6 gap-6">

                                            <div class="col-span-6 sm:col-span-3">
                                                <label
                                                for="class_id"
                                                class="block text-sm font-medium text-gray-700"
                                                >
                                                    Officer
                                                </label>
                                                <select
                                                    v-model="form.officer_id"
                                                    id="class_id"
                                                    class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                    :class="{'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.officer_id}"
                                                >
                                                    <option value="">
                                                        Select a Officer
                                                    </option>
                                                    <option 
                                                        v-for="item in officers.data" 
                                                        :key="item.id"
                                                        :value="item.id"
                                                    >
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                                <InputError :message="form.errors.officer_id"/> 
                                            </div>

                                            
                                            <div class="col-span-6 sm:col-span-3">
                                                <label
                                                for="duty_id"
                                                class="block text-sm font-medium text-gray-700"
                                                >
                                                    Duty
                                                </label>
                                                <select
                                                    v-model="form.duty_id"
                                                    id="duty_id"
                                                    class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                                    :class="{'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.duty_id}"
                                                >
                                                    <option value=""> 
                                                        Select a Duty
                                                    </option>
                                                    <option 
                                                        v-for="item in duties.data" 
                                                        :key="item.id"
                                                        :value="item.id"
                                                    >
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                                <InputError :message="form.errors.duty_id"/> 
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <InputLabel for="odts_code" value="Odts Code" />
                                                <TextInput 
                                                    id="odts_code"
                                                    type="text"
                                                    class="mt-1 block w-full"
                                                    v-model="form.odts_code"
                                                    placeholder="Enter Odts Code"
                                                />
                                                <InputError class="mt-2" :message="form.errors.odts_code" />
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label
                                                    class="block text-sm font-medium text-gray-700"
                                                    >Assign Date</label
                                                >
                                                <Datepicker v-model="form.assigned_at" />
                                                <InputError class="mt-2" :message="form.errors.assigned_at" />
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="is_done" class="flex items-center">
                                                    <Checkbox id="is_done" name="is_done" v-model:checked="form.is_done" />
                                                    <span class="ms-2 text-sm text-gray-600"
                                                        >Task is Already Done.</span
                                                    >
                                                </label>
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
                                            Assign Task
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
