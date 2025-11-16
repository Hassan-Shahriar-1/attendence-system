<template>
    <div class="table-row tr flex items-center">
        <div class="td w-[20%]">{{ row.student_id }}</div>

        <div class="td w-[30%] flex items-center gap-2">
            <img
                :src="row.image_url ?? defaultImage"
                alt="Student Image"
                class="w-10 h-10 rounded-full object-cover"
            />
            <span>{{ row.name }}</span>
        </div>

        <div class="td w-[25%]">{{ row.grade }}</div>
        <div class="td w-[25%]">{{ row.section }}</div>
    </div>
</template>

<script setup>
import lodash from "lodash";
const { debounce } = lodash;

const defaultImage = "/images/default-student.png"; // change if needed
</script>
