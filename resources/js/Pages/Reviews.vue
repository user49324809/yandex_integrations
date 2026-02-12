<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'
const company = ref(null)
const reviews = ref([])
onMounted(async () => {
    await axios.get('/sanctum/csrf-cookie')
    const response = await axios.get('/reviews')
    company.value = response.data.company
    reviews.value = response.data.reviews
})
const formatDate = (dateString) => {
    const date = new Date(dateString)
    return date.toLocaleDateString('ru-RU')
}
</script>
<template>
    <div class="max-w-6xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">Отзывы компании</h1>
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
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
                    class="text-yellow-400 text-lg"
                >
                    <span v-if="i <= review.rating">★</span>
                    <span v-else class="text-gray-300">★</span>
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