<template>
    <tr v-for="student in students" :key="student.id" class="justify-between items-center flex min-h-[53px]">
        <td class="td w-[20%] flex-shrink-0 px-2">{{ student.student_id }}</td>

        <!-- Name + Photo -->
        <td class="td w-[30%] flex-shrink-0 flex items-center gap-2 px-2">
        <img
            :src="student.photo || defaultImage"
            alt="student photo"
            class="w-8 h-8 rounded-full object-cover flex-shrink-0"
        />
        <span class="truncate">{{ student.name }}</span>
        </td>

        <!-- Grade -->
        <td class="td w-[25%] flex-shrink-0 px-2">{{ student.grade }}</td>

        <!-- Section -->
        <td class="td w-[25%] flex-shrink-0 px-2">{{ student.section }}</td>
    </tr>
  
</template>

<script setup>
defineProps({
  students: {
    type: Object,
    required: true,
  },
});

const defaultImage =
  "https://placehold.co/40x40?text=NA";
</script>

<style >

.table-row:hover {
  background-color: #f9f9f9;
}
</style>
