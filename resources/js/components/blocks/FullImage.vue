<template>
	<section :class="block.section_class">
    <div class="container py-12 mx-auto">
        <img
            :src="`/storage/${block.image}`"
            class="w-full h-auto"
            alt=""
        >
    </div>
	</section>
</template>

<script setup>
defineProps({
    block: {
        type: Object,
        required: true
    }
})
</script>
