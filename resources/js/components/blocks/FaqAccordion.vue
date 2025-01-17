<template>
    <section :class="block.section_class">
        <div class="container py-12 mx-auto">
            <div class="text-center mb-8" v-if="block.heading || block.subheading">
                <h2 class="text-3xl font-bold mb-4" v-if="block.heading">{{ block.heading }}</h2>
                <p class="text-gray-600" v-if="block.subheading">{{ block.subheading }}</p>
            </div>
            <div class="max-w-3xl mx-auto">
                <div v-for="(item, index) in block.items" :key="index" class="mb-4">
                    <button 
                        @click="item.isOpen = !item.isOpen"
                        class="flex justify-between items-center w-full px-4 py-3 text-left bg-white rounded-lg shadow hover:bg-gray-50 focus:outline-none">
                        <span class="font-medium">{{ item.question }}</span>
                        <svg 
                            class="w-5 h-5 transition-transform"
                            :class="{ 'rotate-180': item.isOpen }"
                            fill="none" 
                            stroke="currentColor" 
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div 
                        v-show="item.isOpen"
                        class="px-4 py-3 mt-2 bg-white rounded-lg">
                        <div v-html="getMarkdownContent(item.answer)" class="text-gray-600"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref } from 'vue'
import { marked } from 'marked';
import DOMPurify from 'dompurify';

const props = defineProps({
    block: {
        type: Object,
        required: true
    }
})

const getMarkdownContent = (text) => {
    if (!text) return '';
    const htmlContent = marked.parse(text);
    return DOMPurify.sanitize(htmlContent);
};

// Initialize isOpen property for each FAQ item
if (props.block.items) {
    props.block.items.forEach(item => {
        item.isOpen = ref(false)
    })
}
</script>
