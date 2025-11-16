<template>
	<div class="flex font-body !min-h-screen">
		<SideBar />
		<div class="min-h-screen bg-body w-full !max-h-screen overflow-y-auto">
			<TopBar />
			<main class="px-[36px] mt-[104px]">
				<router-view></router-view>
			</main>
		</div>
	</div>
</template>

<script setup>
import SideBar from "@/Components/includes/SideBar.vue";
import TopBar from "@/Components/includes/TopBar.vue";
import { ref } from "vue";

</script>
