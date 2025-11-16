<template>
	<nav class="fixed bg-header z-9 border-b border-neutral-gray-200" >
		<div class="mx-auto">
			<div
				class="relative flex h-[36px] items-center justify-between my-4"
			>
				<div class="ml-auto flex items-center me-[110px]">
					<div class="w-px h-[39px] bg-gray-200 ms-3 gap-4"></div>
					
					<div class="relative ms-[36px]">
						<img class="w-9 h-9 rounded-[50px]" :src="userPhoto" />
					</div>
				</div>
			</div>
		</div>
	</nav>
</template>

<script setup>
import { ref } from "vue";
import { useRouter } from 'vue-router'; // Import useRouter

const router = useRouter(); // Use the hook to access the router

const props = defineProps({
	sidebarCollapse: Boolean,
});

const userPhoto = ref(
	localStorage.getItem("avatar") ?? "https://placehold.co/36x36"
);

</script>
