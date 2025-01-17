<template>
    <footer class="footer-bg py-12 text-white">
        <div class="container px-4 mx-auto">
            <div class="grid grid-cols-4 gap-8">
                <div>
                    <h3 class="mb-4 text-xl font-bold">Kalibr.</h3>
                    <p class="text-gray-400">Short description about the site or company.</p>
                </div>

                <div>
                    <h3 class="mb-4 text-xl font-bold">Snabblänkar</h3>
                    <ul class="space-y-2">
                        <li v-for="item in menuItems" :key="item.id">
                            <router-link
                                :to="item.slug === 'home' ? '/' : `/${item.slug}`"
                                class="text-gray-400 hover:text-white"
                            >
                                {{ item.title }}
                            </router-link>
                        </li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-xl font-bold">Kontakt</h3>
                    <ul class="space-y-2 text-gray-400">
                        <li>E-post: info@kalibr.se</li>
                        <li>Telefon: +46 (0736) 15 12 20</li>
                        <li>Adress: Simrishamnsgatan 20a, SE-214 23 Malmö, Sweden</li>
                    </ul>
                </div>

                <div>
                    <h3 class="mb-4 text-xl font-bold">Follow Us</h3>
                    <div class="flex space-x-4">
                        <!-- Add social media icons/links here -->
                    </div>
                </div>
            </div>

            <div class="pt-8 mt-8 text-center text-gray-400 border-t border-gray-800">
                <p>© {{ new Date().getFullYear() }} Kalibr. Alla rättigheter reserverade.</p>
            </div>
        </div>
    </footer>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { API_BASE_URL } from '../../config'

const menuItems = ref([])

onMounted(async () => {
    const response = await fetch(`${API_BASE_URL}/navigation`)
    menuItems.value = await response.json()
})
</script>
