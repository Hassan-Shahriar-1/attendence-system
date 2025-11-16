<template>
	<div class="relative">
		<div
			class="h-[52px] px-4 py-3 bg-white shadow justify-start items-center gap-2.5 inline-flex cursor-pointer"
			@click="show = !show"
		>
			<div class="w-6 h-6 relative">
				<SettingsIcon />
			</div>
		</div>
		<div
			v-if="show"
			class="w-[385px] max-h-[450px] overflow-auto px-6 py-7 bg-white shadow flex-col justify-start items-start gap-6 inline-flex absolute top-[120%] left-0 z-10"
		>
			<CrossIcon class="cursor-pointer absolute right-8" @click="show = false" />
			<slot></slot>
			<div class="self-stretch justify-end items-center gap-3.5 inline-flex">
				<div class="w-[85px] h-[38px] p-4 bg-[#ededed] justify-center items-center gap-2.5 flex cursor-pointer" @click="resetFilters">
					<div class="text-center text-[#454545] text-sm font-extrabold leading-[16.80px]">{{ $t('Reset') }}</div>
				</div>
				<div class="w-[87px] h-[38px] p-4 bg-primary justify-center items-center gap-2.5 flex cursor-pointer hover:bg-primary-hover" @click="applyFilter">
					<div class="text-center text-white text-sm font-extrabold leading-[16.80px]">{{ $t('Apply') }}</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
import { ref } from "vue";
import SettingsIcon from "@/components/icons/SettingsIcon.vue";
import CrossIcon from "@/components/icons/CrossIcon3.vue";

const emit = defineEmits(["apply", "reset"]);

const show = ref(false);

const applyFilter = () => {
	emit("apply");
	show.value = false;
};

const resetFilters = () => {
	emit("reset");
	show.value = false;
};

const onClickAway = () => {
	show.value = false;
};
</script>
