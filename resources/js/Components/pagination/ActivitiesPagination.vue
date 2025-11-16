<template>
	<div class="pagination-container">
		<div class="flex items-center flex-wrap justify-between">
			<!-- Page Links starts -->
			<div class="flex flex-nowrap gap-2">
				<vue-awesome-paginate
					v-model="currentPage"
					@click="handlePageNumber"
					:totalItems="paginationData.total"
					:total-items="paginationData.total"
					:items-per-page="paginationData.per_page"
					:max-pages-shown="3"
				>
					<template #prev-button>
						<div class="flex items-center">
							<ArrowLeftIcon />
							<div
								class="text-center text-[#3e3d3c] text-base font-semibold leading-tight"
							>
								Previous
							</div>
						</div>
					</template>

					<template #next-button>
						<div class="flex items-center">
							<div
								class="text-center text-[#3e3d3c] text-base font-semibold leading-tight"
							>
								Next
							</div>
							<ArrowRightIcon />
						</div>
					</template>
				</vue-awesome-paginate>
			</div>
			<!-- Page Links ends -->
		</div>
	</div>
</template>

<script setup>
import { ref, watch } from "vue";
import ArrowLeftIcon from "./ArrowLeftIcon.vue";
import ArrowRightIcon from "./ArrowRightIcon.vue";

const props = defineProps({
	paginationData: {
		type: Object,
		required: true,
	},
});
const emit = defineEmits(['update-page']);

const currentPage = ref(1);
const per_page = ref(10);

// Handle page number change
const handlePageNumber = (page) => {
	currentPage.value = page;
	emit('update-page', { page: currentPage.value, perPage: per_page.value });
};

// Watch for changes in `per_page` and reset the page number
watch(per_page, () => {
	currentPage.value = 1; // Reset to the first page.
	emit('update-page', { page: currentPage.value, perPage: per_page.value });
});
</script>

<style lang="scss" scoped>
.pagination-container {
	display: flex;
	column-gap: 10px;
}

:deep(.paginate-buttons) {
	@apply text-[#585754] w-auto h-10 px-4 py-3 active:bg-secondary hover:bg-[#fff] hover:text-primary flex-col justify-center items-center inline-flex cursor-pointer text-center text-base font-normal leading-snug;
}

:deep(.active-page) {
	@apply bg-[#fff] text-word-semibold text-primary font-bold;
}

:deep(.active-page:hover) {
	@apply bg-[#F7F6E6] font-bold;
}
</style>
