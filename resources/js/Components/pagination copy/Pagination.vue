<template>
	<div class="mt-[20px]">
		<div class="relative">
			<div class="flex items-center flex-wrap justify-between">
				<!-- Page Dropdown starts -->
				<div class="flex items-center flex-nowrap">
					<div class="ml-2 flex items-center gap-2">
						<PageDropdown
							@selectedInput="
								(value) => {
									input = value;
								}
							"
						/>
						<div class="text-[#5d5d5d] text-sm font-normal leading-[21px]">
							Entries per page
						</div>
					</div>
				</div>
				<!-- Page Dropdown ends -->

				<!-- Page Links starts -->
				<div class="flex flex-nowrap gap-2">
					<vue-awesome-paginate
						v-model="currentPage"
						@click="handlePageNumber"
						:totalItems="paginationData.total"
						:total-items="paginationData.total"
						:items-per-page="paginationData.per_page"
						:max-pages-shown="paginationData.total_pages"
					>
						<template #prev-button>
							<div class="flex items-center">
								<ArrowLeftIcon />
								<div class="text-center text-[#3e3d3c] text-base font-semibold leading-tight">
									Previous
								</div>
							</div>
						</template>

						<template #next-button>
							<div class="flex items-center">
								<div class="text-center text-[#3e3d3c] text-base font-semibold leading-tight">
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
	</div>
</template>

<script setup>
import { ref, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import PageDropdown from "./PageDropdown.vue";
import ArrowLeftIcon from "./ArrowLeftIcon.vue";
import ArrowRightIcon from "./ArrowRightIcon.vue";

const router = useRouter();
const route = useRoute();

const props = defineProps({
	paginationData: {
		type: Object,
		required: true,
	},
});
const currentPage = ref(route.query.page ? Number(route.query.page) : 1);
const per_page = ref(router.currentRoute.value.query.per_page ? Number(router.currentRoute.value.query.per_page) : 10);

const handlePageNumber = (page) => {
	router.push({
		query: {
			...route.query,
			per_page: per_page.value,
			page: page,
		},
	});
};

watch(per_page, (newValue, oldValue) => {
	if (newValue !== oldValue) {
		currentPage.value = 1; // Reset to the first page.
	}
});

watch(router.currentRoute, () => {
	currentPage.value = route.query.page ? Number(route.query.page) : 1;
});
</script>

<style lang="scss" scoped>
.pagination-container {
	display: flex;
	column-gap: 10px;
}
:deep(.paginate-buttons) {
	@apply text-[#585754] w-auto h-10 px-4 py-3 active:bg-secondary hover:bg-[#F7F6E6] hover:border-b hover:border-primary hover:text-primary flex-col justify-center items-center inline-flex cursor-pointer text-center text-base font-normal leading-snug;
}
:deep(.active-page) {
	@apply bg-[#F7F6E6] text-word-semibold text-primary font-bold border-b border-primary;
}
:deep(.active-page:hover) {
	@apply bg-[#F7F6E6] font-bold;
}
</style>
