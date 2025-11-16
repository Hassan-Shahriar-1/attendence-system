<template>
	<div
		v-click-away="onClickAway"
		v-if="show"
		ref="panel"
		class="z-10 min-w-[172px] p-3 right-8 top-0 absolute bg-white rounded-lg shadow-[0px_10px_15px_0px_rgba(138,138,138,0.25)] inline-flex flex-col justify-start items-start gap-1 cursor-pointer"
		:class="positionClass"
		:style="computedStyle"
	>
		<slot></slot>
	</div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";

// Props and emits
const props = defineProps({
	show: Boolean,
	fontClass: String,
	positionClass: String,
});

const emit = defineEmits(["action", "close"]);
const panel = ref(null);
const positionAbove = ref(false);
const show = ref(props.show);

// Style to control dropdown positioning
const computedStyle = computed(() => ({
	top: positionAbove.value ? "auto" : "0%",
	bottom: positionAbove.value ? "100%" : "auto",
	marginBottom: positionAbove.value ? "8px" : "0",
	marginTop: positionAbove.value ? "0" : "0px",
}));

const onClickAway = () => {
	show.value = false;
	emit("close");
};

onMounted(() => {
	const panelRect = panel.value.getBoundingClientRect();
	const viewportHeight = window.innerHeight;

	// Determine if dropdown should display above or below
	positionAbove.value = panelRect.bottom + 150 > viewportHeight;
});
</script>