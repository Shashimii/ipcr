<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { computed, onMounted } from 'vue';
import ExcelJS from 'exceljs';

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

const completedDuties = computed(() => {
    return assignedDuties.filter(duty => duty.is_done).length;
});

const pendingDuties = computed(() => {
    return assignedDuties.filter(duty => !duty.is_done).length;
});

const officerCount = computed(() => {
    return officers.length;
})

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

// onMounted(() => {
//     console.log("Duty Map on Mounted:", dutyMap.value);
// });

// Excel Exporting

const excelExport = async () => {
    let workbook = new ExcelJS.Workbook();
    let worksheet = workbook.addWorksheet("Assigned Duties");

    // Add headers
    worksheet.addRow(["Duties / Targets", ...officers.map(o => o.name)]);

    // Add data rows
    duties.forEach((duty) => {
        let rowData = [duty.name];

        officers.forEach((officer) => {
            let assignedDuties = getAssignedDuty(officer.id, duty.id);
            if (assignedDuties.length > 0) {
                rowData.push(assignedDuties.map(ad => `${ad.odts_code}\n${ad.assigned_at}`).join("\n"));
            } else {
                rowData.push("");
            }
        });

        const row = worksheet.addRow(rowData);

        // Auto height calculation based on line breaks
        const maxLines = Math.max(...rowData.map(cell => (cell.match(/\n/g) || []).length + 1));
        row.height = Math.max(80, maxLines * 20); // 20px per line
    });

    // Apply styles
    worksheet.columns.forEach(column => {
        column.width = 30; // Set column width
    });

    // Format odts code color
    const formatTextColorGreen = (text) => {
    const regex = /(\([^)]+\))/g; // match texts like "(text)"
    const textParts = text.split(regex); // split text into parts needed for richText

        return textParts.map(part => {
            if (regex.test(part)) {
                return { font: { color: { argb: '008000' } }, text: part };
            } else {
                return { text: part };
            }
        });
    }

    // Loop to Apply styles to each row and cells
    worksheet.eachRow((row, rowNumber) => {
        row.eachCell((cell, colNumber) => {

            let cellValue = cell.value;

            if (cellValue != '' && colNumber != 1) {
                cell.fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'FFF9AA' } // Cell with value color
                }
            }

            if (colNumber === 1) {
                cell.fill = {
                    type: 'pattern',
                    pattern: 'solid',
                    fgColor: { argb: 'F1F1F1' } // Side column color
                }
            }

            if (typeof cellValue === 'string' && cellValue.includes('(')) {
                cell.value = { richText: formatTextColorGreen(cellValue) };
            }

            cell.alignment = { vertical: 'middle', horizontal: 'center', wrapText: true };
            cell.border = {
                top: { style: "medium", color: { argb: "000000" } },
                left: { style: "medium", color: { argb: "000000" } },
                bottom: { style: "medium", color: { argb: "000000" } },
                right: { style: "medium", color: { argb: "000000" } },
            };

            if (rowNumber === 1) {
                cell.font = { bold: true, size: 14 }; // Header font style
                cell.fill = { type: 'pattern', pattern: 'solid', fgColor: { argb: 'F1F1F1' } }; // Header color
            }
        });

        if (rowNumber === 1) {
            row.height = 40; // Header Height
        }
    });

    // Download Excel File
    const buffer = await workbook.xlsx.writeBuffer();
    const blob = new Blob([buffer], { type: "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" });
    const link = document.createElement("a");
    link.href = URL.createObjectURL(blob);
    link.download = `IPCR_${new Date().toISOString().split('T')[0]}.xlsx`;
    link.click();
};


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
                        <p>Total Completed Tasks: </p>
                        <p>{{ completedDuties }}</p>
                    </div>
                    <div class="bg-red-500 text-white p-4 border-gray-300 rounded shadow flex justify-between">
                        <p>Total Pending Tasks: </p>
                        <p>{{ pendingDuties }}</p>
                    </div>
                    <div class="bg-blue-500 text-white p-4 border-gray-300 rounded shadow flex justify-between">
                        <p>Total Officers: </p>
                        <p>{{ officerCount }}</p>
                    </div>
                </div>
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="mb-8 sm:flex sm:items-center justify-between">
                            <div>
                                <h3
                                    class="text-lg leading-6 font-medium text-gray-900"
                                >
                                    IPCR Tracker Table
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    Assigned Tasks to the officers are shown here.
                                </p>
                            </div>
                            
                            <button class="px-4 py-2 bg-green-800 text-white rounded" @click="excelExport">Export to Excel</button>
                        </div>

                        <div class="overflow-x-auto">
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
                                    <tr v-for="duty in duties" :key="duty.id" class="hover:bg-green-200 divide-x divide-gray-300">
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
        </div>
    </AuthenticatedLayout>
</template>
