<template>
	<div @click="toggleCheckbox" class="cursor-pointer">
		<!-- Checked Icon -->
		<svg
			v-if="checked"
			xmlns="http://www.w3.org/2000/svg"
			width="16"
			height="17"
			viewBox="0 0 16 17"
			fill="none"
		>
			<path
				d="M1.66699 8.50033C1.66699 5.51477 1.66699 4.02199 2.59449 3.09449C3.52199 2.16699 5.01477 2.16699 8.00033 2.16699C10.9859 2.16699 12.4787 2.16699 13.4062 3.09449C14.3337 4.02199 14.3337 5.51477 14.3337 8.50033C14.3337 11.4859 14.3337 12.9787 13.4062 13.9062C12.4787 14.8337 10.9859 14.8337 8.00033 14.8337C5.01477 14.8337 3.52199 14.8337 2.59449 13.9062C1.66699 12.9787 1.66699 11.4859 1.66699 8.50033Z"
				stroke="#00A280"
				stroke-width="1.5"
			/>
			<path
				d="M5.33301 9.66667C5.33301 9.66667 6.39967 10.275 6.93301 11.1667C6.93301 11.1667 8.53301 7.66667 10.6663 6.5"
				stroke="#3D3D3D"
				stroke-width="1.5"
				stroke-linecap="round"
				stroke-linejoin="round"
			/>
		</svg>
		<!-- Unchecked Icon -->
		<svg
			v-else
			xmlns="http://www.w3.org/2000/svg"
			width="16"
			height="17"
			viewBox="0 0 16 17"
			fill="none"
		>
			<path
				d="M1.66699 8.50033C1.66699 5.51477 1.66699 4.02199 2.59449 3.09449C3.52199 2.16699 5.01477 2.16699 8.00033 2.16699C10.9859 2.16699 12.4787 2.16699 13.4062 3.09449C14.3337 4.02199 14.3337 5.51477 14.3337 8.50033C14.3337 11.4859 14.3337 12.9787 13.4062 13.9062C12.4787 14.8337 10.9859 14.8337 8.00033 14.8337C5.01477 14.8337 3.52199 14.8337 2.59449 13.9062C1.66699 12.9787 1.66699 11.4859 1.66699 8.50033Z"
				stroke="#B0B0B0"
				stroke-width="1.5"
			/>
		</svg>
	</div>
</template>

<script setup>
const props = defineProps({
	checked: Boolean,
});

const emit = defineEmits(['update:checked']);

const toggleCheckbox = () => {
	emit('update:checked', !props.checked);
};
</script>
