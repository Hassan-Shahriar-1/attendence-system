<template>
    <Sidebar></Sidebar>
    <div class="report-card">
        <h2>Report</h2>
        <p>Your report content goes here.</p>
    </div>
</template>

<script setup>
import Sidebar from '../Components/Sidebar.vue';
</script>

<style scoped>
.sidebar {
    width: 220px;
    background: #f7f7f8;
    padding: 1rem;
    min-height: 100vh;
    box-sizing: border-box;
}
.sidebar ul { list-style: none; padding: 0; margin: 0; }
.sidebar li + li { margin-top: 0.5rem; }
.sidebar a { color: #111827; text-decoration: none; font-weight: 500; }
</style>