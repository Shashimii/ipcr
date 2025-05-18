<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';

let props = defineProps({
    officers: {
        type: Object,
        required: true
    },

    duties: {
        type: Object,
        required: true
    },

    assignedDuties: {
        type: Object,
        required: true
    }
});


let officers = props.officers.data,
    duties = props.duties.data,
    assignedDuties = props.assignedDuties.data


let dutyMap = computed(() => {
    const map = {};
    assignedDuties.forEach((assignedDuty) => {
        const key = `${assignedDuty.officer.id}-${assignedDuty.duty.id}`;
        if (!map[key]) {
            map[key] = [];
        }
        map[key].push(assignedDuty);
    });
    return map;
});

const getAssignedDuty = (officerId, dutyId) => {
    let key = `${officerId}-${dutyId}`;
    return dutyMap.value[key] || [];
}

onMounted(() => {
    console.log("Duty Map on Mounted:", dutyMap.value);
});



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
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <table class="min-w-full divide-y divide-gray-300 bg-white border border-gray-300 rounded-lg shadow">
                            <thead class="bg-gray-100">
                                <tr class="divide-x divide-gray-300">
                                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-700">
                                        <div class="flex items-center justify-center">
                                            <p>Duties / Targets</p>
                                        </div>
                                    </th>
                                    <th :colspan="officers.length" class="px-4 py-3 text-center text-sm font-semibold text-gray-700">
                                        <p>Action Officers</p>
                                    </th>
                                </tr>
                                <tr class="bg-gray-50 divide-x divide-gray-300">
                                    <th class="px-4 py-2 text-left text-sm font-semibold text-gray-600"></th>
                                    <th v-for="officer in officers" :key="officer.id" class="px-4 py-2 text-center text-sm font-semibold text-gray-600">
                                        <div class="min-w-[120px] flex items-center justify-center">{{ officer.name }}</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300">
                                <tr v-for="duty in duties" :key="duty.id" class="hover:bg-gray-50 divide-x divide-gray-300">
                                    <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 bg-gray-100">
                                        <div class="min-h-[80px] flex items-center">{{ duty.name }}</div>
                                    </th>
                                    <td 
                                        v-for="officer in officers" 
                                        :key="officer.id" 
                                        class="px-4 py-2 text-center"
                                        :class="{ 'bg-green-200': getAssignedDuty(officer.id, duty.id).length > 0 }"
                                    >
                                        <div v-if="getAssignedDuty(officer.id, duty.id).length > 0">
                                            <div v-for="(assigned, index) in getAssignedDuty(officer.id, duty.id)" :key="index">
                                                <p>
                                                    {{ assigned.odts_code }} <br>
                                                    {{ assigned.assigned_at }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
