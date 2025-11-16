<template>
	<div class="flex items-center gap-x-2.5" v-click-away="onClickAway">
		<div
			class="h-7 px-2 py-1 relative flex items-center cursor-pointer bg-white justify-start gap-1 inline-flex"
			@click="openPerPageDropdown = !openPerPageDropdown"
		>
			{{ per_page }}
			<ul class="absolute per__page--dropdown" v-if="openPerPageDropdown">
				<li
					@click.stop="setPerPage(10)"
					:class="{ active: per_page == 10 }"
				>
					10
				</li>
				<li
					@click.stop="setPerPage(25)"
					:class="{ active: per_page == 25 }"
				>
					25
				</li>
				<li
					@click.stop="setPerPage(50)"
					:class="{ active: per_page == 50 }"
				>
					50
				</li>
				<li
					@click.stop="setPerPage(100)"
					:class="{ active: per_page == 100 }"
				>
					100
				</li>
			</ul>

			<DropdownArrowIcon />
		</div>
	</div>
</template>

<!-- Script starts -->
<script setup>
import { ref, watch } from "vue";
import { useRouter, useRoute } from "vue-router";
import DropdownArrowIcon from "./DropdownArrowIcon.vue";

const router = useRouter();
const route = useRoute();

const openPerPageDropdown = ref(false);
const per_page = ref(router.currentRoute.value.query.per_page ? Number(router.currentRoute.value.query.per_page) : 10);
const page = ref(router.currentRoute.value.query.page ? Number(router.currentRoute.value.query.page) : 1);
const emit = defineEmits(["selectedInput"]);

const setPerPage = (perPage) => {
	openPerPageDropdown.value = false;
	per_page.value = perPage;
	page.value = 1;
	emit("selectedInput", perPage);

	router.push({
		query: {
			...route.query,
			per_page: perPage,
			page: page.value,
		},
	});
};

const onClickAway = (event) => {
	handleCancel();
};

const handleCancel = () => {
	openPerPageDropdown.value = false;
};

watch(router.currentRoute, () => {
	per_page.value = route.query.per_page ? Number(route.query.per_page) : 10;
});
</script>
<!-- Script ends -->

<!-- Style starts -->
<style lang="scss" scoped>
.per__page--dropdown {
	@apply w-[60px] h-[117px] bg-[#f9f9f9];
	list-style: none;
	bottom: 28px;
	left: 0;
	border: 0;
	border-radius: 2px;
	text-align: center;
	li {
		font-size: 12px;
		font-style: normal;
		font-weight: 400;
		line-height: normal;
		padding: 6px 12px;
		// border-radius: 2px;
	}
	li:hover {
		@apply bg-primary text-white;
	}
	.active {
		@apply bg-primary text-white;
	}
}
</style>
<!-- Style ends -->
