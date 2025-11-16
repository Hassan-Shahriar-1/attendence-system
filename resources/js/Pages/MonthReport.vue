<template>
  <div class="p-5 bg-white shadow-md rounded-lg">
    <!-- Header: Select Grade and Month -->
    <div class="flex items-center justify-between mb-4 gap-4">
      <div class="flex items-center gap-2">
        <label class="text-sm text-gray-600">Grade:</label>
        <select v-model="selectedGrade" class="border rounded px-2 py-1 text-sm" @change="fetchMonthlyReport">
          <option v-for="g in grades" :key="g.id" :value="g.id">{{ g.name }}</option>
        </select>
      </div>

      <div class="flex items-center gap-2">
        <label class="text-sm text-gray-600">Month:</label>
        <input type="month" v-model="selectedMonth" class="border rounded px-2 py-1 text-sm" @change="fetchMonthlyReport" />
      </div>
    </div>

    <!-- Chart -->
    <canvas ref="monthlyChart" height="140"></canvas>

    <!-- Totals -->
    <div class="mt-6 grid grid-cols-3 gap-4 text-center">
      <div>
        <div class="text-sm text-gray-500">Present (YTD)</div>
        <div class="text-2xl font-semibold">{{ totals.present ?? '--' }}</div>
      </div>
      <div>
        <div class="text-sm text-gray-500">Absent (YTD)</div>
        <div class="text-2xl font-semibold">{{ totals.absent ?? '--' }}</div>
      </div>
      <div>
        <div class="text-sm text-gray-500">Late (YTD)</div>
        <div class="text-2xl font-semibold">{{ totals.late ?? '--' }}</div>
      </div>
    </div>

    <!-- Optional: Table of students -->
    <div class="mt-6">
      <table class="w-full border border-gray-200">
        <thead class="bg-gray-100">
          <tr>
            <th class="border p-2">Student</th>
            <th class="border p-2">Present</th>
            <th class="border p-2">Absent</th>
            <th class="border p-2">Late</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="student in monthlyData" :key="student.student_id">
            <td class="border p-2">{{ student.name }}</td>
            <td class="border p-2">{{ student.present }}</td>
            <td class="border p-2">{{ student.absent }}</td>
            <td class="border p-2">{{ student.late }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from '@/axios';
import Chart from 'chart.js/auto';

const selectedGrade = ref(null);
const selectedMonth = ref(new Date().toISOString().slice(0, 7)); // YYYY-MM
const grades = ref([]); // Fetch from API or define static grades
const monthlyData = ref([]);
const totals = ref({});
const monthlyChart = ref(null);
let chartInstance = null;

// Fetch grade list (optional if dynamic)
const fetchGrades = async () => {
  try {
    const response = await axios.get('/grades');
    grades.value = response.data.data.data;
    if (grades.value.length > 0) selectedGrade.value = grades.value[0].id;
  } catch (error) {
    console.error('Error fetching grades:', error);
  }
};

// Fetch monthly attendance
const fetchMonthlyReport = async () => {
  if (!selectedGrade.value || !selectedMonth.value) return;

  try {
    const response = await axios.get('/get-monthly-report', {
      params: { grade_id: selectedGrade.value, month: selectedMonth.value }
    });
    monthlyData.value = response.data.data.monthlyData;
    totals.value = response.data.data.totals;
    renderChart();
  } catch (error) {
    console.error('Error fetching monthly report:', error);
  }
};

// Render Chart.js
const renderChart = () => {
  const labels = monthlyData.value.map(s => s.name);
  const presentData = monthlyData.value.map(s => s.present);
  const absentData = monthlyData.value.map(s => s.absent);
  const lateData = monthlyData.value.map(s => s.late);

  if (chartInstance) chartInstance.destroy();

  chartInstance = new Chart(monthlyChart.value, {
    type: 'bar',
    data: {
      labels,
      datasets: [
        { label: 'Present', data: presentData, backgroundColor: '#22c55e' },
        { label: 'Absent', data: absentData, backgroundColor: '#ef4444' },
        { label: 'Late', data: lateData, backgroundColor: '#facc15' },
      ]
    },
    options: {
      responsive: true,
      plugins: { legend: { position: 'top' }, tooltip: { mode: 'index', intersect: false } },
      scales: { y: { beginAtZero: true, stepSize: 1 } }
    }
  });
};

onMounted(async () => {
  await fetchGrades();
  fetchMonthlyReport();
});
</script>
