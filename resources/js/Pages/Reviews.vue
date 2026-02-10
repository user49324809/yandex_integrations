<script setup>
import { onMounted, ref } from 'vue'
import axios from 'axios'

const company = ref(null)
const reviews = ref([])

onMounted(async () => {
    const response = await axios.get('/reviews')
    company.value = response.data.company
    reviews.value = response.data.reviews
})
</script>

<template>
    <div class="p-6">
        <h1 class="text-2xl font-bold mb-4">Отзывы компании</h1>

        <div v-if="company" class="mb-6">
            <p>Рейтинг: {{ company.rating }}</p>
            <p>Количество отзывов: {{ company.reviews_count }}</p>
        </div>

        <div v-for="review in reviews" :key="review.date" class="border p-4 mb-3">
            <p><strong>{{ review.author }}</strong></p>
            <p>Оценка: {{ review.rating }}</p>
            <p>{{ review.text }}</p>
            <p class="text-sm text-gray-500">{{ review.date }}</p>
        </div>
    </div>
</template>