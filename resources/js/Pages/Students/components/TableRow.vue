<template>
      <div class="table-row tr">
        <div class="td w-[20%]">{{ student.student_id }}</div>
        <div class="td w-[30%]">
            <div class="flex items-center gap-2">
                <img
                    :src="student.image_url ?? defaultImage"
                    alt="Student Image"
                    class="w-10 h-10 rounded-full object-cover"
                />
                <span>{{ student.name }}</span>
            </div>
        </div>
        <div class="td w-[25%]">{{ student.grade }}</div>

        <div class="td w-[25%]">{{ student.section }}</div>
        
    </div>
</template>

<script setup>
defineProps({
    student: {
        type: Object,
        required: true,
    },
});

const defaultImage = "https://www.google.com/url?sa=i&url=https%3A%2F%2Fwww.freepik.com%2Ffree-photos-vectors%2Fplaceholder-person-student&psig=AOvVaw0ORgTuMpZkgqgp1Ai7JS_D&ust=1763378760422000&source=images&cd=vfe&opi=89978449&ved=0CBUQjRxqFwoTCPjf_vbH9pADFQAAAAAdAAAAABAE";
</script>
