<template>
	<div class="grid grid-cols-4 gap-4">
		<div class="flex items-center p-5 bg-white shadow-md">
			<div class="w-10/12 flex items-center gap-4">
				<div class="bg-neutral-100 flex flex-col justify-center items-center gap-2 rounded-2xl w-14 h-14">
					<AvgRecipeCostDashboardIcon />
				</div>
				<div class="flex flex-col justify-start items-start gap-2">
					<div class="text-[#757575] text-sm font-normal leading-[21px]">Total Sale</div>
					<div class="text-[#454545] text-xl font-semibold leading-normal">{{ data ? data.total_sale : '--' }}</div>
				</div>
			</div>
		</div>

        <div class="flex items-center p-5 bg-white shadow-md">
			<div class="w-10/12 flex items-center gap-4">
				<div class="bg-neutral-100 flex flex-col justify-center items-center gap-2 rounded-2xl w-14 h-14">
					<GreenCogIcon />
				</div>
				<div class="flex flex-col justify-start items-start gap-2">
					<div class="text-[#757575] text-sm font-normal leading-[21px]">Weekly Sale</div>
					<div class="text-[#454545] text-xl font-semibold leading-normal">{{ data ? data.weekly_sale : '--' }}</div>
				</div>
			</div>
		</div>
		
	
		
	</div>
</template>
<script setup>
import AvgRecipeCostDashboardIcon from "@/Components/icons/AvgRecipeCostDashboardIcon.vue";
import UsersDashboardIcon from "@/Components/icons/UsersDashboardIcon.vue";
import GreenCogIcon from "@/Components/icons/GreenCogIcon.vue";
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
const router = useRouter();

</script>
