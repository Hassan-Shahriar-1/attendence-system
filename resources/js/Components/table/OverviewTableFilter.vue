<template>
	<div :class="show ? 'relative':''">
		<div
			class="h-[36px] px-2 py-3 bg-white justify-start items-center gap-2.5 inline-flex cursor-pointer rounded-md outline outline-1 outline-offset-[-1px] outline-[#e0e2e5]"
			@click="show = !show"
		>
			<IconsFilterIcon />
			Filter
		</div>
		<div
			v-if="show"
			class="w-[385px] px-6 py-7 bg-white shadow flex-col justify-start items-start gap-6 inline-flex absolute top-[120%] left-0 z-10"
		>
			<IconsCrossIcon3 class="cursor-pointer absolute right-8" @click="show = false" />
			<slot></slot>
			<div class="self-stretch justify-end items-center gap-3.5 inline-flex">
				<div class="min-w-[85px] h-[38px] p-4 bg-[#ededed] justify-center items-center gap-2.5 flex cursor-pointer" @click="resetFilters">
					<div class="text-center text-[#454545] text-sm font-extrabold leading-[16.80px]">{{ $t('Reset') }}</div>
				</div>
				<div class="min-w-[87px] h-[38px] p-4 bg-[#00a280] justify-center items-center gap-2.5 flex cursor-pointer hover:bg-primary-hover" @click="applyFilter">
					<div class="text-center text-white text-sm font-extrabold leading-[16.80px]">{{ $t('Apply') }}</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script setup>
import { ref } from "vue";
// import FilterIcon from "@icons/FilterIcon.vue";
// import CrossIcon from "@icons/CrossIcon3.vue";

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
