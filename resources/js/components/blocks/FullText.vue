<template>
    <section :class="block.section_class">
        <div class="container py-3 mx-auto">
            <div v-html="parsedContent"></div>
        </div>
    </section>
</template>

<script setup>
import { marked } from "marked";
import { computed } from "vue";
import DOMPurify from "dompurify";

const props = defineProps({
    block: {
        type: Object,
        required: true,
    },
});

const parsedContent = computed(() => {
    if (!props.block.text) return "";
    const htmlContent = marked.parse(props.block.text);
    return DOMPurify.sanitize(htmlContent);
});
</script>
