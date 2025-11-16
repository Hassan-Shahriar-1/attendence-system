<template>
	<div
		class="w-[500px] h-[52px] px-4 py-3 bg-white shadow justify-start items-center gap-2.5 inline-flex"
	>
		<div class="w-6 h-6 relative">
			<div class="w-3.5 h-3.5 left-[5px] top-[5px] absolute">
				<SearchIcon />
			</div>
		</div>
		<div
			class="w-full text-center text-[#888888] text-sm font-normal leading-tight"
		>
			<input
				type="text"
				class="w-full h-full bg-transparent border-none outline-none ring-0 focus:ring-0"
				v-model="search"
				:placeholder="$t(placeholder)"
			/>
		</div>
	</div>
</template>

<script setup>
import SearchIcon from "@/components/icons/SearchIcon.vue";
import { ref, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import { debounce } from "lodash";

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
		router.push({ query: { ...route.query, search: search.value || undefined } });
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
