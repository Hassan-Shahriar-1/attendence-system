<template>
	<th>
		<div class="flex items-center text-left cursor-pointer text-sm font-semibold leading-[16.80px]" @click="sort">
			<template v-if="typeof label === 'object'">
				{{(label.text, label.replace) }}
			</template>
			<template v-else>
				{{ (label) }}
			</template>
			<SortIcon v-if="enableSort" class="ms-[8px]" />
		</div>
	</th>
</template>

<script setup>
import { ref, onMounted, watch } from "vue";
import { useRoute, useRouter } from "vue-router";
import SortIcon from "../icons/SortIcon.vue";

const props = defineProps({
	label: {
		type: [String, Object],
		required: true,
	},
	columnName: {
		type: String,
		required: true,
	},
	enableSort: {
		type: Boolean,
		default: true,
	},
});

const direction = ref(null);
const route = useRoute();
const router = useRouter();

onMounted(() => {
	const order_by = route.query.order_by;
	const directionQuery = route.query.direction;
	if (props.columnName === order_by) {
		direction.value = directionQuery;
	}
});

const sort = () => {
	if (!props.enableSort) return;

	direction.value = direction.value === "ASC" ? "DESC" : "ASC";
};

watch(direction, (newValue) => {
	const queries = { ...route.query };
	delete queries.page;

	const routeObj = {
		name: route.name,
		params: { ...route.params },
		query: {
			...queries,
			order_by: props.columnName,
			direction: newValue,
		},
	};

	router.push(routeObj);
});
</script>
