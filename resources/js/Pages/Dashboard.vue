<template>
    <div>
        <h2 class="text-lg font-semibold text-[#454545] mb-4">Today Report</h2>
        <div class="grid grid-cols-3 gap-4">
            <div class="p-5 bg-white shadow-md rounded-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <UsersDashboardIcon />
                        <div class="text-[#757575] text-sm font-normal">Present</div>
                    </div>
                    <div class="text-sm text-[#757575]">
                        {{ data ? data.present.count + ' / ' + data.total_students : '--' }}
                    </div>
                </div>
                <div class="text-[#454545] text-2xl font-semibold mb-3">
                    {{ data ? data.present.percentage + '%' : '--' }}
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-green-500 h-2 rounded-full" :style="{ width: (data ? data.present.percentage : 0) + '%' }"></div>
                </div>
            </div>

            <div class="p-5 bg-white shadow-md rounded-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <UsersDashboardIcon />
                        <div class="text-[#757575] text-sm font-normal">Absent</div>
                    </div>
                    <div class="text-sm text-[#757575]">
                        {{ data ? data.absent.count + ' / ' + data.total_students : '--' }}
                    </div>
                </div>
                <div class="text-[#454545] text-2xl font-semibold mb-3">
                    {{ data ? data.absent.percentage + '%' : '--' }}
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-red-500 h-2 rounded-full" :style="{ width: (data ? data.absent.percentage : 0) + '%' }"></div>
                </div>
            </div>

            <div class="p-5 bg-white shadow-md rounded-lg">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-2">
                        <UsersDashboardIcon />
                        <div class="text-[#757575] text-sm font-normal">Late</div>
                    </div>
                    <div class="text-sm text-[#757575]">
                        {{ data ? data.late.count + ' / ' + data.total_students : '--' }}
                    </div>
                </div>
                <div class="text-[#454545] text-2xl font-semibold mb-3">
                    {{ data ? data.late.percentage + '%' : '--' }}
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    <div class="bg-yellow-500 h-2 rounded-full" :style="{ width: (data ? data.late.percentage : 0) + '%' }"></div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import AvgRecipeCostDashboardIcon from "@/Components/icons/AvgRecipeCostDashboardIcon.vue";
import UsersDashboardIcon from "@/Components/icons/UsersDashboardIcon.vue";
import GreenCogIcon from "@/Components/icons/GreenCogIcon.vue";
import { ref, onMounted } from "vue";
import axios from "@/axios";
import { useRouter } from "vue-router";
const router = useRouter();
const data = ref(null);
const getTodayReport = async () => {
    try {
        const response = await axios.get('/today-report');
        data.value = response.data.data;
    } catch (error) {
        console.error('Error fetching dashboard data:', error);
    }
};

onMounted(() => {
    getTodayReport();
});

</script>
