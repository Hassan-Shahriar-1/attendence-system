<template>
	<div
		class="w-[280px] h-[36px] ps-4 py-3 justify-start items-center gap-0 inline-flex rounded-md outline outline-1 outline-offset-[-1px] outline-[#e0e2e5]"
	>
		<div class="w-6 h-6">
			<div class="w-3.5 h-3.5 mt-[5px]">
				<IconsSearchIcon />
			</div>
		</div>
		<div
			class="w-full text-center text-[#151619] text-sm font-normal leading-tight"
		>
			<input
				type="text"
				class="w-full h-full text-[#151619] bg-transparent border-none outline-none ring-0 focus:ring-0"
				v-model="search"
				:placeholder="$t(placeholder)"
			/>
		</div>
	</div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import lodash from 'lodash';
const { debounce } = lodash;

const route = useRoute();
const router = useRouter();

defineProps({
	placeholder: {
		type: String,
		default: "Search",
	},
});

const search = ref(route.query.search || "");

watch(
	search,
	debounce(() => {
		router.push({ query: { search: search.value || undefined } });
	}, 500)
);

watch(
	() => route.query.search,
	(newSearch) => {
		if (newSearch !== search.value) {
			search.value = newSearch || "";
		}
	}
);
</script>
