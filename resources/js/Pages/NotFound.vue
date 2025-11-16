<template>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 to-white flex items-center justify-center p-6">
        <div class="max-w-5xl w-full bg-white/70 backdrop-blur-md rounded-2xl shadow-xl border border-white/60 overflow-hidden flex flex-col md:flex-row items-center">
            <!-- Illustration -->
            <div class="w-full md:w-1/2 p-8 flex items-center justify-center">
                <div class="relative w-64 h-64 md:w-72 md:h-72">
                    <!-- Floating planet / orb -->
                    <svg viewBox="0 0 200 200" class="w-full h-full animate-float">
                        <defs>
                            <linearGradient id="g1" x1="0" x2="1">
                                <stop offset="0" stop-color="#7c3aed"/>
                                <stop offset="1" stop-color="#06b6d4"/>
                            </linearGradient>
                            <filter id="f1" x="-50%" y="-50%" width="200%" height="200%">
                                <feGaussianBlur stdDeviation="8" result="b"/>
                                <feBlend in="SourceGraphic" in2="b"/>
                            </filter>
                        </defs>

                        <!-- planet -->
                        <circle cx="100" cy="100" r="54" fill="url(#g1)" filter="url(#f1)"/>
                        <!-- ring -->
                        <ellipse cx="110" cy="100" rx="78" ry="28" fill="none" stroke="#c7f9ff" stroke-opacity="0.45" stroke-width="6" transform="rotate(-22 100 100)"/>
                        <!-- small satellites -->
                        <circle cx="28" cy="48" r="6" fill="#fde68a"/>
                        <circle cx="168" cy="34" r="4" fill="#fca5a5"/>
                        <circle cx="160" cy="150" r="5" fill="#a7f3d0"/>
                    </svg>
                    <!-- 404 badge -->
                    <div class="absolute left-1/2 -translate-x-1/2 bottom-4 bg-white/90 px-4 py-2 rounded-full text-sm font-semibold text-gray-700 shadow-md">
                        Error 404
                    </div>
                </div>
            </div>

            <!-- Text content -->
            <div class="w-full md:w-1/2 p-8 md:py-12 md:px-10">
                <h1 class="text-6xl md:text-7xl font-extrabold tracking-tight text-gray-900">404</h1>
                <p class="mt-2 text-lg md:text-xl text-gray-600 max-w-xl">
                    Oops — the page you're looking for can't be found. It might have been moved or deleted.
                </p>

                <div class="mt-6 flex flex-col sm:flex-row gap-3">
                    <router-link to="/" class="inline-flex items-center justify-center px-5 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium shadow-md transition">
                        Go home
                    </router-link>

                    <button @click="goBack" class="inline-flex items-center justify-center px-5 py-3 rounded-lg border border-gray-200 bg-white hover:bg-gray-50 text-gray-700 font-medium transition">
                        Go back
                    </button>
                </div>

                <p class="mt-6 text-sm text-gray-400">
                    If you think this is a mistake, contact support or try refreshing the page.
                </p>
            </div>
        </div>
    </div>
</template>

<script setup>
function goBack() {
    if (window.history.length > 1) {
        window.history.back()
    } else {
        // fallback to home
        window.location.href = '/'
    }
}
</script>

<style scoped>
@keyframes float-y {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-12px); }
    100% { transform: translateY(0px); }
}
.animate-float {
    animation: float-y 4s ease-in-out infinite;
    transform-origin: center;
}
</style>