<script setup>
import { ref } from 'vue'
import axios from 'axios'

const yandexUrl = ref('')
const message = ref('')

const save = async () => {
    try {
        await axios.post('/integration', {
            yandex_url: yandexUrl.value
        })
        message.value = 'Сохранено успешно'
    } catch (e) {
        message.value = 'Ошибка при сохранении'
    }
}
</script>
<template>
    <div class="p-6 max-w-xl">
        <h1 class="text-2xl font-bold mb-4">Настройки интеграции</h1>
        <input
            v-model="yandexUrl"
            type="text"
            placeholder="Вставьте ссылку на Яндекс"
            class="border p-2 w-full mb-3"
        />
        <button
            @click="save"
            class="bg-blue-600 text-white px-4 py-2"
        >
            Сохранить
        </button>
        <p v-if="message" class="mt-3">
            {{ message }}
        </p>
    </div>
</template>