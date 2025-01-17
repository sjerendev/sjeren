<template>
    <section :class="block.section_class">
        <div class="container py-12 mx-auto">
            <h2 v-if="block.section_title" class="mb-8 text-3xl font-bold text-center">{{ block.section_title }}</h2>
            <div :class="`grid gap-8 ${getColumnClass}`">
                <article v-for="post in posts" :key="post.id" class="blog-card">
                    <router-link :to="{ name: 'post', params: { slug: post.slug }}" class="block">
                        <img v-if="block.show_hero_image && (post.list_image || post.hero_image)" 
                             :src="`/storage/${post.list_image || post.hero_image}`"
                             :alt="post.title" 
                             class="w-full h-48 object-cover rounded-t-lg">
                        <div class="p-6">
                            <h3 class="text-xl font-bold mb-3 hover:text-primary-600 transition">{{ post.title }}</h3>
                            <div v-if="post.hero_paragraph" class="text-gray-600 mb-4">{{ post.hero_paragraph }}</div>
                            <div v-if="block.show_date" class="flex items-center justify-between text-sm">
                                <div class="flex items-center text-gray-500">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ formatDate(post.publish_date || post.created_at) }}
                                </div>
                                <div v-if="post.categories?.length" class="flex gap-2">
                                    <router-link 
                                        v-for="category in post.categories" 
                                        :key="category.id"
                                        :to="{ 
                                            name: 'page',
                                            params: { slug: 'blogg' },
                                            query: { category: category.id }
                                        }"
                                        class="text-sm font-medium text-primary-600 hover:text-primary-700">
                                        {{ category.name }}
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </router-link>
                </article>
            </div>
        </div>
    </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const props = defineProps({
    block: {
        type: Object,
        required: true
    }
});

const posts = ref([]);

const getColumnClass = computed(() => {
    switch (props.block.columns) {
        case '2':
            return 'grid-cols-1 sm:grid-cols-2';
        case '3':
            return 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3';
        case '4':
            return 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-4';
        case '5':
            return 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-5';
        default:
            return 'grid-cols-1 sm:grid-cols-2 lg:grid-cols-3';
    }
});

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('sv-SE', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

onMounted(async () => {
    try {
        const params = {
            limit: props.block.posts_count || 3
        };
        
        if (props.block.categories?.length) {
            params.categories = props.block.categories;
        }

        const response = await fetch('/api/posts?' + new URLSearchParams(params));
        const data = await response.json();
        posts.value = data.data;
    } catch (error) {
        console.error('Error fetching blog posts:', error);
    }
});
</script>

<style scoped>
.blog-card {
    background-color: white;
    border-radius: 0.5rem;
    box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
    overflow: hidden;
    transition: transform 0.2s ease-in-out;
}

.blog-card:hover {
    transform: translateY(-2px);
}
</style>
