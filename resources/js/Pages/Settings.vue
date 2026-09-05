<script setup>
import { ref } from 'vue'
import axios from 'axios'

const props = defineProps({
    integration: {
        type: Object,
        default: null,
    },
})

const yandexUrl = ref(props.integration?.yandex_url ?? '')
const message = ref('')
const errors = ref({})
const saving = ref(false)

const save = async () => {
    try {
        saving.value = true
        errors.value = {}
        await axios.post('/integration', {
            yandex_url: yandexUrl.value
        })
        message.value = 'Сохранено успешно'
    } catch (e) {
        errors.value = e.response?.data?.errors ?? {}
        message.value = 'Не удалось сохранить интеграцию'
    } finally {
        saving.value = false
    }
}
</script>
<template>
    <div class="p-6 max-w-xl">
        <h1 class="text-2xl font-bold mb-4">Настройки интеграции</h1>
        <input
            v-model="yandexUrl"
            type="url"
            placeholder="https://yandex.ru/maps/org/company/123456789"
            class="border p-2 w-full mb-3"
        />
        <p v-if="errors.yandex_url" class="mb-3 text-sm text-red-600">
            {{ errors.yandex_url[0] }}
        </p>
        <button
            @click="save"
            :disabled="saving"
            class="bg-blue-600 text-white px-4 py-2"
        >
            {{ saving ? 'Сохраняем…' : 'Сохранить' }}
        </button>
        <p v-if="message" class="mt-3">
            {{ message }}
        </p>
    </div>
</template>
