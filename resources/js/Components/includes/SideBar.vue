<template>
	<div class="bg-gray-800 relative min-w-[280px] max-w-[280px]">
		<div class="flex-col justify-start items-center flex pt-5 relative">
						
			<div class="flex flex-col gap-[12px] pl-2 w-[90%] pt-12">
				<template v-for="(tab, index) in tabs" :key="index">
					<router-link
						:to="tab.route"
						@mouseover="hoveredIndex = index"
						@mouseleave="hoveredIndex = null"
						:class="{
							'bg-green-600 rounded-tl-3xl rounded-br-3xl': activeTab === index,
						}"
					>
						<div
							class="top-[0.77px] flex items-center relative rounded-tl-3xl rounded-br-3xl cursor-pointer"
							:class="{
								'hover:bg-green-700': true,
								'transition-all': true,
							}"
						>
							
							<div class="text-sm font-medium me-3 text-[#EDFAF7]">{{ (tab.label) }}</div>
						</div>
					</router-link>
				</template>
			</div>
		</div>
		<div class="flex-col items-center flex gap-4 absolute bottom-5 px-5 w-full">
			<div class="w-full h-px bg-white my-3"></div>
			<div class="flex justify-between items-center">
				<div class="flex items-center cursor-pointer order-first" @click="handleLogout">
					<LogoutIcon
						class="mx-auto"
						@mouseover="hoverLogout = true"
						@mouseleave="hoverLogout = false"
					/>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
import { shallowRef, onMounted, ref, watch } from "vue";
import { useRoute } from "vue-router";

import DashboardIcon from "@/Components/icons/DashboardIcon.vue";
import LogoutIcon from "@/Components/icons/LogoutIcon.vue";
import axios from "@/axios";
const activeTab = ref(0);
const hoveredIndex = ref(null);
const hoverLogout = ref(false);
const route = useRoute();
const tabs = shallowRef([
	{
		label: "Dashboard",
		route: "/",
	},
	{
		label: "Students",
		route: "/students",
	},
	{
		label: "Attendance",
		route: "/attendance",
	},
	
	
]);

watch(
	() => route.path,
	(path) => {
		tabs.value.forEach((tab, index) => {
			if (path.includes(tab.route)) {
				activeTab.value = index;
			}
		});
	}
);

onMounted(() => {
	tabs.value.forEach((tab, index) => {
		if (route.path.includes(tab.route)) {
			activeTab.value = index;
		}
	});
});

const handleLogout = async () => {
	await axios.post("logout");
	localStorage.clear();
	window.location.href = "/login";
};
</script>
