<template>
    <nav class="relative px-8 py-4">
        <!-- Desktop Navigation -->
        <div class="items-center justify-between hidden md:flex">
            <router-link to="/" class="flex items-center">
                <img v-if="settings?.logo" :src="settings.logo" alt="Logo" class="h-8">
                <span v-else class="text-xl font-bold">{{ settings?.site_name }}</span>
            </router-link>

            <div class="flex space-x-8 items-center">
                <div v-for="item in navigation" :key="item.id" class="relative group">
                    <router-link
                        v-if="!item.children"
                        :to="{ name: 'page', params: { slug: item.slug }}"
                        class="text-[var(--text-color)] hover:opacity-70 transition-opacity"
                    >
                        {{ item.title }}
                    </router-link>
                    <div v-else class="relative inline-block group">
                        <button 
                            class="flex items-center text-[var(--text-color)] hover:opacity-70 transition-opacity space-x-1"
                        >
                            <span>{{ item.title }}</span>
                            <svg class="w-4 h-4 transition-transform duration-200 group-hover:rotate-180" 
                                fill="none" 
                                stroke="currentColor" 
                                viewBox="0 0 24 24"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>
                        <div class="absolute -bottom-2 left-0 right-0 h-2 bg-transparent"></div>
                        <div 
                            class="absolute left-0 z-10 invisible w-48 py-2 mt-2 bg-[var(--background)] rounded-md shadow-lg group-hover:visible opacity-0 group-hover:opacity-100 transition-all duration-200"
                        >
                            <router-link
                                v-for="child in item.children"
                                :key="child.id"
                                :to="{ name: 'page', params: { slug: child.slug }}"
                                class="block px-4 py-2 text-[var(--text-color)] hover:opacity-70 transition-opacity"
                            >
                                {{ child.title }}
                            </router-link>
                        </div>
                    </div>
                </div>
                
                <!-- Dark Mode Toggle -->
                <button 
                    @click="darkModeStore.toggleDarkMode()"
                    class="p-2 rounded-full transition-colors"
                    :class="darkModeStore.isDark ? 'bg-white' : 'bg-[var(--text-color)]'"
                    :aria-label="darkModeStore.isDark ? 'Switch to light mode' : 'Switch to dark mode'"
                >
                    <svg
                        v-if="!darkModeStore.isDark"
                        class="w-5 h-5 text-white"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"
                        />
                    </svg>
                    <svg 
                        v-else
                        class="w-5 h-5 text-[#111820]"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path 
                            stroke-linecap="round" 
                            stroke-linejoin="round" 
                            stroke-width="2" 
                            d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"
                        />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden">
            <div class="flex items-center justify-between">
                <router-link to="/" class="flex items-center">
                    <img v-if="settings?.logo" :src="settings.logo" alt="Logo" class="h-8">
                    <span v-else class="text-xl font-bold">{{ settings?.site_name }}</span>
                </router-link>
                <button @click="isOpen = !isOpen" class="text-gray-900">
                    <svg v-if="!isOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Overlay -->
            <div v-show="isOpen" class="fixed inset-0 z-50" style="height: 100svh;">
                <!-- Fixed Header -->
                <div class="bg-white">
                    <div class="flex items-center justify-between px-4 py-4">
                        <router-link to="/" class="flex items-center">
                            <img v-if="settings?.logo" :src="settings.logo" alt="Logo" class="h-8">
                            <span v-else class="text-xl font-bold">{{ settings?.site_name }}</span>
                        </router-link>
                        <button @click="isOpen = false" class="text-gray-900">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Animated Content -->
                <div ref="menuContainer" class="origin-top bg-white" style="height: calc(100svh - 64px);">
                    <div class="mt-16 space-y-2">
                        <template v-for="item in navigation" :key="item.id">
                            <div v-if="!item.children?.length">
                                <router-link
                                    :to="{ name: 'page', params: { slug: item.slug }}"
                                    @click="isOpen = false"
                                    class="block py-4 text-xl text-gray-900 hover:text-gray-600"
                                >
                                    {{ item.title }}
                                </router-link>
                            </div>
                            <div v-else class="border-b border-gray-200">
                                <button 
                                    class="flex items-center justify-between w-full py-4 text-xl text-gray-900"
                                    @click="item.isOpen = !item.isOpen"
                                >
                                    {{ item.title }}
                                    <svg 
                                        class="w-4 h-4 ml-1 transition-transform duration-200"
                                        :class="{ 'rotate-180': item.isOpen }"
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                                <div 
                                    v-show="item.isOpen"
                                    class="pl-4 pb-4"
                                >
                                    <router-link
                                        v-for="child in item.children"
                                        :key="child.id"
                                        :to="{ name: 'page', params: { slug: child.slug }}"
                                        @click="isOpen = false"
                                        class="block py-2 text-lg text-gray-700 hover:text-gray-900"
                                    >
                                        {{ child.title }}
                                    </router-link>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { ref, watch } from 'vue'
import gsap from 'gsap'
import { useDarkModeStore } from '../../../stores/darkMode'

const props = defineProps({
    navigation: {
        type: Array,
        required: true
    },
    settings: {
        type: Object,
        required: true
    }
})

const darkModeStore = useDarkModeStore()
const isOpen = ref(false)
const menuContainer = ref(null)

function toggleMenu(open) {
    if (open) {
        gsap.fromTo(menuContainer.value,
            {
                scaleY: 0,
                transformOrigin: 'top'
            },
            {
                scaleY: 1,
                duration: 0.5,
                ease: 'power2.out'
            }
        )
    } else {
        gsap.to(menuContainer.value, {
            scaleY: 0,
            duration: 0.5,
            ease: 'power2.in',
            transformOrigin: 'top'
        })
    }
}

watch(isOpen, (newValue) => {
    toggleMenu(newValue)
})
</script>
