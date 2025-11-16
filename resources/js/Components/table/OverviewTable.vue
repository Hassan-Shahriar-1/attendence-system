<template>
	<div class="bg-white rounded-2xl outline outline-1 outline-offset-[-1px] outline-[#e0e2e5] p-[24px] my-[20px]" :class="headerTopClass">
		<div class="flex items-center justify-center gap-4 mb-[20px] border-b-[1px] border-[#e5e0e0] pb-4">
			<div>
				<slot name="overview-top-title" />
			</div>
			<div class="w-[30%] ml-auto">
				<slot name="overview-top-right"></slot>
			</div>
		</div>
		<div class="flex gap-4 mb-[20px] justify-between">
			<div v-if="searchEnabled">
				<OverviewTableSearch :placeholder="searchPlaceholder" />
			</div>
			<div v-if="filterEnabled">
				<slot name="filter" />
			</div>
		</div>

		<!-- Scrollable Table Wrapper -->
		<div :class="{'overflow-x-auto': enableHorizontalScroll}">
			<table class="data-table" :class="tableScrollMinWidth">
				<thead>
					<tr>
						<div class="flex items-center w-full h-[60px] px-6 py-4 bg-[#f1f2f3] rounded-tl-xl rounded-tr-xl" :class="headerClass">
							<FormCheckBox
								class="me-4"
								@click="handleSelectAll"
								:checked="isChecked"
								v-if="showSelectAll"
								:class="{
									disabled: disableCheckBox,
								}"
							/>
							<slot name="header"></slot>
						</div>
					</tr>
				</thead>
				<tbody :class="bodyClass" class="bg-white">
					<!-- <div class="h-[calc(100vh-450px)] overflow-y-auto" :class="tableBodyClass">
					</div> -->
					<slot name="body"></slot>
				</tbody>
			</table>
		</div>
		
		<template v-if="paginationData && paginationData.total > 0">
			<Pagination :paginationData="paginationData" />
		</template>
	</div>
</template>

<script setup>
import OverviewTableSearch from "./OverviewTableSearch.vue";

// import Pagination from "@components/pagination/Pagination.vue";


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
	tableBodyClass: {
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
	disableCheckBox: {
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
