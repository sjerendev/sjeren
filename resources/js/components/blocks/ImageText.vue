<template>
    <section :class="block.section_class">
        <div class="container py-12 mx-auto">
            <div class="flex items-center" :class="{ 'flex-row-reverse': block.reverse_layout }">
                <div class="w-1/2" :class="{
                    'pr-6': !block.reverse_layout,
                    'pl-6': block.reverse_layout,
                }">
                    <img :src="`/storage/${block.image}`" class="w-full h-auto" alt="" />
                </div>
                <div class="flex items-center w-1/2" :class="{
                    'pl-6': !block.reverse_layout,
                    'pr-6': block.reverse_layout,
                }">
                    <div class="py-4">
                        <div v-html="parsedContent" class="mb-4"></div>
                        <div v-if="block.button1_text || block.button2_text" class="flex gap-4 mt-10">
                            <a v-if="block.button1_text" :href="block.button1_url"
                                class="inline-flex items-center px-4 py-2 font-semibold text-white transition-colors rounded-xl button-one">
                                {{ block.button1_text }}
                            </a>
                            <a v-if="block.button2_text" :href="block.button2_url"
                                class="inline-flex items-center px-4 py-2 font-semibold text-white transition-colors rounded-xl button-two">
                                {{ block.button2_text }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
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

<style scoped>
.button-one {
    background-color: #18f2b2;
    border: 1px solid #18f2b2;
    color: #111820;
    transition: all 0.3s ease-in-out;

    &:hover {
        background-color: #fff;
        border: 1px solid #fff;
        color: #111820;
        transition: all 0.3s ease-in-out;
    }
}

.button-two {
    background-color: transparent;
    color: #18f2b2;
    border: 1px solid #18f2b2;
    transition: all 0.3s ease-in-out;

    &:hover {
        background-color: #fff;
        border: 1px solid #fff;
        color: #111820;
        transition: all 0.3s ease-in-out;
    }
}
</style>
