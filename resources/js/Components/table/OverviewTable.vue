<template>
	<div class="mt-[40px]" :class="headerTopClass">
		<div class="flex gap-4 mb-[20px]">
			<div v-if="filterEnabled">
				<slot name="filter" />
			</div>
			<div v-if="searchEnabled">
				<OverviewTableSearch :placeholder="searchPlaceholder" />
			</div>
			<div class="w-[30%] ml-auto">
				<slot name="overview-top-right"></slot>
			</div>
		</div>

		<!-- Scrollable Table Wrapper -->
		<div :class="{'overflow-x-auto': enableHorizontalScroll}">
			<table class="data-table" :class="tableScrollMinWidth">
				<thead>
					<tr>
						<div class="flex items-center w-full h-[60px] ps-4 py-5 border-b border-[#e8e8e7] rounded-tl-3xl" :class="headerClass">
							<CheckBox class="me-4" @click="handleSelectAll" :checked="isChecked" v-if="showSelectAll" />
							<slot name="header"></slot>
						</div>
					</tr>
				</thead>
				<tbody :class="bodyClass" class="bg-white">
					<div class="min-h-[calc(100vh-410px)] max-h-[calc(100vh-410px)] overflow-y-auto">
						<slot name="body"></slot>
					</div>
				</tbody>
			</table>
		</div>

		<!-- Pagination -->
		<template v-if="paginationData.total > 0">
			<Pagination :paginationData="paginationData" />
		</template>
	</div>
</template>

<script setup>
import OverviewTableSearch from "../table/OverviewTableSearch.vue";
import CheckBox from "../form/CheckBox.vue";
import Pagination from "../pagination/Pagination.vue";

defineProps({
	headerTopClass: {
		type: String,
		default: "",
	},
	tableScrollMinWidth: {
		type: String,
		default: "",
	},
	headerClass: {
		type: String,
		default: "",
	},
	bodyClass: {
		type: String,
		default: "",
	},
	filterEnabled: {
		type: Boolean,
		default: true,
	},
	searchEnabled: {
		type: Boolean,
		default: false,
	},
	searchPlaceholder: {
		type: String,
		default: "Search",
	},
	paginationData: {
		type: Object,
		required: true,
	},
	loading: {
		type: Boolean,
		required: true,
	},
	isChecked: {
		type: Boolean,
		default: false,
	},
	showSelectAll: {
		type: Boolean,
		default: true,
	},
	enableHorizontalScroll: {
		type: Boolean,
		default: false,
	},
});

const emit = defineEmits(["selectAll"]);

const handleSelectAll = () => {
	emit("selectAll");
};
</script>

<style scoped>
.data-table {
	width: 100%;
	border-collapse: collapse;
}

.data-table th,
.data-table td {
	padding: 10px;
	text-align: left;
}

.data-table th {
	cursor: pointer;
}

.overflow-x-auto {
	overflow-x: auto;
}

</style>
