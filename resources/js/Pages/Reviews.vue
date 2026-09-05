<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
import { router } from '@inertiajs/vue3'

const company = ref(null)
const reviews = ref([])
const loading = ref(true)
const error = ref('')
onMounted(async () => {
    try {
        const response = await axios.get('/reviews-data')
        company.value = response.data.company
        reviews.value = response.data.reviews
    } catch (e) {
        error.value = e.response?.data?.error ?? 'Не удалось загрузить отзывы.'
    } finally {
        loading.value = false
    }
})
const formatDate = (dateString) => {
    const [year, month, day] = dateString.split('-')
    return `${day}.${month}.${year}`
}
</script>
<template>
    <div class="max-w-6xl mx-auto p-6">
        <button @click="router.post('/logout')">
            Выйти
        </button>
        <h1 class="text-2xl font-bold mb-6">Отзывы компании</h1>
        <p v-if="loading" class="text-gray-500">Загрузка отзывов…</p>
        <div v-else-if="error" class="rounded-lg bg-red-50 p-4 text-red-700">
            {{ error }}
            <a href="/settings" class="ml-2 underline">Открыть настройки</a>
        </div>
        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-4">
            <div
            v-for="review in reviews"
            :key="review.date + review.author"
            class="bg-white rounded-xl shadow-md p-5"
            >
            <div class="flex justify-between items-center mb-2">
                <div>
                <p class="font-semibold text-lg">{{ review.author }}</p>
                <p class="text-sm text-gray-500">
                    {{ formatDate(review.date) }}
                </p>
                </div>
                <div class="flex">
                <span
                    v-for="i in 5"
                    :key="i"
                    class="text-2xl"
                >
                    <span
                        :class="i <= review.rating
                        ? 'text-yellow-400'
                        : 'text-gray-300'"
                    >
                        ★
                    </span>
                </span>
                </div>
            </div>
            <p class="text-gray-700 leading-relaxed">
                {{ review.text }}
            </p>
            </div>
        </div>
        <div v-if="company" class="bg-white rounded-xl shadow-md p-6 h-fit">
            <div class="text-center">
            <p class="text-5xl font-bold mb-2">
                {{ company.rating }}
            </p>
            <div class="flex justify-center mb-2">
                <span
                v-for="i in 5"
                :key="i"
                class="text-yellow-400 text-xl"
                >
                <span v-if="i <= Math.round(company.rating)">★</span>
                <span v-else class="text-gray-300">★</span>
                </span>
            </div>
            <p class="text-gray-500">
                Всего отзывов: {{ company.reviews_count }}
            </p>
            </div>
        </div>
        </div>
    </div>
</template>
