<template>
	<div class="bg-sidebar relative" :class="[sidebarCollapse ? 'min-w-[86px] max-w-[86px]' : 'min-w-[280px] max-w-[280px]']">
		<!-- <div class="bg-sidebar w-[86px] max-w-[86px]"> -->
		<div class="flex-col justify-start items-center flex pt-5 relative">
						
			<div class="flex flex-col gap-[12px]" :class="[sidebarCollapse ? '': 'w-[90%]']">
				<template v-for="(tab, index) in tabs" :key="index">
					<router-link
						:to="tab.route"
						@mouseover="hoveredIndex = index"
						@mouseleave="hoveredIndex = null"
						:class="{
							'bg-[#600B1E] rounded-tl-3xl rounded-br-3xl': activeTab === index,
						}"
					>
						<div
							class="top-[0.77px] flex items-center relative rounded-tl-3xl rounded-br-3xl cursor-pointer"
							:class="{
								'hover:bg-[#600B1E]': true,
								'transition-all': true,
							}"
						>
							<component :is="tab.iconComponent" color="#EDFAF7" />
							<Tooltip
								v-if="sidebarCollapse"
								:label="tab.label"
								:show="hoveredIndex === index"
								class="absolute left-[100%] ms-[2px] whitespace-nowrap z-20"
							/>
							<div v-if="!sidebarCollapse" class="text-sm font-medium me-4 text-[#EDFAF7]">{{ $t(tab.label) }}</div>
						</div>
					</router-link>
				</template>
			</div>
		</div>
		<div class="flex-col items-center flex gap-4 absolute bottom-5 px-5 w-full">
			<div class="w-full h-px bg-[#600B1E] my-3"></div>
			<div :class="sidebarCollapse ? '' : 'flex justify-between items-center'">
				<div class="flex items-center cursor-pointer order-first" @click="handleLogout">
					<LogoutIcon
						class="mx-auto"
						@mouseover="hoverLogout = true"
						@mouseleave="hoverLogout = false"
					/>
					<div v-if="!sidebarCollapse" class="text-sm font-medium ms-4 text-[#EDFAF7]">{{ $t('Logout') }}</div>
				
					<Tooltip
						v-if="sidebarCollapse"
						:label="$t('Logout')"
						:show="hoverLogout"
						class="absolute left-[80%] ms-[2px] whitespace-nowrap z-20"
					/>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
import { shallowRef, onMounted, ref, watch } from "vue";
import { useRoute } from "vue-router";

import DashboardIcon from "@/components/icons/sidebar/DashboardIcon.vue";
import LogoutIcon from "@/components/icons/sidebar/LogoutIcon.vue";

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
		label: "User Management",
		route: "/users",
	},
	{
		label: "Item Management",
		route: "/items",
	},
	{
		label: "Ability Management",
		route: "/abilities",
	},
	{
		label: "Minion Management",
		route: "/minions",
	},
	{
		label: "Product Management",
		route: "/products",
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
	await axios.post("/logout");
	localStorage.clear();
	window.location.href = "/login";
};
</script>
