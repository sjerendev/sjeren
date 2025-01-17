<template>
    <div>
        <div
					v-if="page?.hero_background_type"
					class="relative hero-section"
					:style="{
							height: page.hero_height || '50svh',
							backgroundColor: page.hero_background_color,
							color: page.hero_text_color
					}"
			>
					<img
							v-if="page?.hero_image"
							:src="`/storage/${page.hero_image}`"
							class="absolute inset-0 object-cover w-full h-full"
							:style="{ opacity: page.hero_background_type === 'both' ? 0.5 : 1 }"
					>
					<div class="container relative z-10 px-4 py-12 mx-auto">
							<h1 class="text-4xl font-bold">{{ page.hero_headline || page.title }}</h1>
							<p v-if="page.hero_subheadline" class="mt-4 text-xl">{{ page.hero_subheadline }}</p>
							<p v-if="page.hero_paragraph" class="mt-4">{{ page.hero_paragraph }}</p>
							<a
									v-if="page.hero_cta_text && page.hero_cta_url"
									:href="page.hero_cta_url"
									class="inline-block px-6 py-3 mt-6 text-white rounded-lg bg-primary-500"
							>
									{{ page.hero_cta_text }}
							</a>
					</div>
			</div>

        <!-- Content Blocks -->
        <div v-if="page?.content">
            <BlockRenderer
                v-for="(block, index) in page.content"
                :key="index"
                :block="block"
            />
        </div>

        <div v-if="page?.slug === 'blogg' && posts.length > 0" class="container px-4 py-12 mx-auto">
            <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
                <article v-for="post in posts" :key="post.id" class="overflow-hidden bg-white rounded-lg shadow-lg">
                    <img
                        v-if="post.hero_image"
                        :src="`/storage/${post.hero_image}`"
                        :alt="post.title"
                        class="object-cover w-full h-48"
                    >
                    <div class="p-6">
                        <h2 class="mb-2 text-2xl font-bold">{{ post.title }}</h2>
                        <div class="flex items-center justify-between mb-4 text-sm">
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
                        <p v-if="post.hero_paragraph" class="mb-4 text-gray-600">{{ post.hero_paragraph }}</p>
                        <router-link
                            :to="{ name: 'post', params: { slug: post.slug }}"
                            class="inline-block px-4 py-2 font-semibold text-[#111820] transition-colors rounded-lg bg-[#18F2B2] hover:bg-primary-600"
                        >
                            Läs mer
                        </router-link>
                    </div>
                </article>
            </div>
        </div>
    </div>
</template>
<script setup>
import { ref, watch, onMounted } from 'vue'
import { useHead } from '@vueuse/head'
import { useRoute, useRouter } from 'vue-router'
import BlockRenderer from '../components/BlockRenderer.vue'

const route = useRoute()
const router = useRouter()
const page = ref(null)
const posts = ref([])

// Default fallback values
const DEFAULT_TITLE = 'Your Site Name'
const DEFAULT_DESCRIPTION = 'Your default site description here'

const formatDate = (date) => {
    if (!date) return '';
    return new Date(date).toLocaleDateString('sv-SE', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
    });
};

// Fetch blog posts
const fetchPosts = async () => {
    try {
        const params = new URLSearchParams()
        
        // Add category filter if present in URL
        if (route.query.category) {
            params.append('categories', route.query.category)
        }
        
        const response = await fetch('/api/posts?' + params.toString())
        const data = await response.json()
        posts.value = data.data
    } catch (error) {
        console.error('Failed to fetch blog posts:', error)
    }
}

// Watch for both route slug and query changes
watch([() => route.params.slug, () => route.query], async ([newSlug, newQuery]) => {
    if (newSlug === 'blogg') {
        fetchPosts()
    }
    
    if (newSlug) {
        const response = await fetch(`/api/pages/${newSlug}`)
        page.value = await response.json()
    }
}, { immediate: true })

// Dynamic meta tags
useHead(() => ({
    title: page.value?.meta_title || page.value?.title || DEFAULT_TITLE,
    meta: [
        {
            name: 'description',
            content: page.value?.meta_description || DEFAULT_DESCRIPTION
        }
    ]
}))
</script>
