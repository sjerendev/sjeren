<template>
    <section :class="block.section_class">
        <div class="container py-12 mx-auto">
            <h2 v-if="block.section_title" class="mb-8 text-3xl font-bold text-center">{{ block.section_title }}</h2>
            <div :class="`grid gap-8 ${getColumnClass}`">
                <div v-for="(card, index) in block.cards" :key="index" class="card">
                    <div class="flex justify-left mb-4">
                        <div class="iconBox">
                            <component
                                v-if="getIconComponent(card.icon)"
                                :is="getIconComponent(card.icon)"
                                :weight="card.icon_style || 'regular'"
                                class="w-10 h-10"
                                :style="{ color: card.icon_color || '#000000' }"
                            />
                        </div>
                    </div>
                    <h4 class="text-xl font-bold mb-3">{{ card.title }}</h4>
                    <div v-html="getMarkdownContent(card.text)" class="prose mx-auto"></div>
                    <div v-if="card.link_url" class="mt-4">
                        <a :href="card.link_url" class="iconCardLink">Läs mer</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { computed } from 'vue';
import { marked } from 'marked';
import DOMPurify from 'dompurify';
import * as phosphorIcons from '@phosphor-icons/vue';

const props = defineProps({
    block: {
        type: Object,
        required: true
    }
});

const getIconComponent = (iconName) => {
    if (!iconName) return null;
    // Convert kebab-case to PascalCase and add 'Ph' prefix
    const componentName = 'Ph' + iconName
        .split('-')
        .map(part => part.charAt(0).toUpperCase() + part.slice(1))
        .join('');
    console.log('Looking for icon:', componentName);
    console.log('Found icon:', phosphorIcons[componentName]);
    return phosphorIcons[componentName];
};

const getColumnClass = computed(() => {
    switch (props.block.columns) {
        case '2':
            return 'grid-cols-1 sm:grid-cols-2';
        case '3':
            return 'grid-cols-1 sm:grid-cols-3';
        case '4':
            return 'grid-cols-1 sm:grid-cols-4';
        case '5':
            return 'grid-cols-1 sm:grid-cols-5';
        default:
            return 'grid-cols-1 sm:grid-cols-3'; // Default to 3 columns
    }
});

const getMarkdownContent = (text) => {
    if (!text) return '';
    const htmlContent = marked.parse(text);
    return DOMPurify.sanitize(htmlContent);
};
</script>

<style scoped>
.card {
    padding: 2rem;
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
}

/* Ensure proper spacing in markdown content */
:deep(.prose) {
    max-width: none;
}

:deep(.prose h3) {
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}

:deep(.prose p) {
    margin-top: 0.5em;
    margin-bottom: 0.5em;
}
</style>
