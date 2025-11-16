<template>
    <aside class="sidebar">
        <nav>
            <ul>
                <li><router-link to="/dashboard">Dashboard</router-link></li>
                <li><router-link to="/students">Students</router-link></li>
                <li><router-link to="/attendes">Attendes</router-link></li>
            </ul>
        </nav>
    </aside>
    <header class="topbar">
        <h1>Attendance System</h1>
    </header>
</template>

<script>
import { defineComponent } from 'vue';
import { useRouter } from 'vue-router';

export default defineComponent({
    name: 'Sidebar',
    setup() {
        const router = useRouter();
        return { router };
    }
});
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
.topbar {
    background: #fff;
    padding: 1rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}
</style>



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