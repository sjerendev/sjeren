<template>
    <div class="container px-4 py-12 mx-auto">
        <h1 class="mb-8 text-4xl font-bold">Blog</h1>

        <div class="grid grid-cols-3 gap-8">
            <article v-for="post in posts" :key="post.id" class="post-card">
                <img
                    v-if="post.hero_image"
                    :src="`/storage/${post.hero_image}`"
                    :alt="post.title"
                    class="object-cover w-full h-48 mb-4"
                >
                <h2 class="mb-2 text-2xl font-bold">{{ post.title }}</h2>
                <p class="mb-4">{{ post.hero_paragraph }}</p>
                <router-link
                    :to="{ name: 'post', params: { slug: post.slug }}"
                    class="font-semibold text-primary-500"
                >
                    Read More
                </router-link>
            </article>
        </div>

        <!-- Pagination -->
        <div class="flex justify-center gap-2 mt-8">
            <button
                v-for="page in totalPages"
                :key="page"
                @click="currentPage = page"
                :class="[
                    'px-4 py-2 rounded',
                    currentPage === page ? 'bg-primary-500 text-white' : 'bg-gray-200'
                ]"
            >
                {{ page }}
            </button>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue'

const posts = ref([])
const currentPage = ref(1)
const totalPages = ref(1)

const fetchPosts = async (page) => {
    const response = await fetch(`/api/posts?page=${page}`)
    const data = await response.json()
    posts.value = data.data
    totalPages.value = data.last_page
}

onMounted(() => fetchPosts(1))

watch(currentPage, (newPage) => {
    fetchPosts(newPage)
})
</script>
