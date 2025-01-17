<template>
	<section :class="block.section_class">
    <div :class="block.container_type + ' mx-auto'">
        <div :class="['flex py-12 items-center content-block headline-text', block.container_type === 'container-fluid' ? 'px-12' : '']">
					<div class="w-3/12">
            <component :is="headlineType" class="text-4xl font-bold leading-[1]">
                {{ headline }}
            </component>
					</div>
            <div class="w-9/12 prose max-w-none leading-[1] text-lg" v-html="parsedContent"></div>
        </div>
    </div>
	</section>
</template>

<script setup>
import { defineProps } from 'vue'
import { marked } from 'marked';
import { computed } from 'vue';
import DOMPurify from 'dompurify';

const props = defineProps({
    block: {
        type: Object,
        required: true
    }
})

const headlineType = computed(() => props.block.headline_type || 'h2')
const headline = computed(() => props.block.headline || '')

const parsedContent = computed(() => {
    if (!props.block.text) return '';
    const htmlContent = marked.parse(props.block.text);
    return DOMPurify.sanitize(htmlContent);
});
</script>

<style scoped>
/* Add any specific styles you might need for this block */
</style>
