<script setup>
import { ref } from 'vue';

// Define the props
const props = defineProps({
    modelValue: {
        type: String,
        required: true,
    },
    options: {
        type: Array,
        required: true,
    },
});

const select = ref(null);

// Use 'emit' to emit the 'update:modelValue' event
const emit = defineEmits(['update:modelValue']);

const updateValue = (value) => {
    emit('update:modelValue', value);
};

defineExpose({ focus: () => select.value.focus() });
</script>

<template>
    <select class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        :value="props.modelValue" @input="updateValue($event.target.value)" ref="select">
        <option disabled value="">Please select one</option>
        <option v-for="option in props.options" :key="option.value" :value="option.value">
            {{ option.label }}
        </option>
    </select>
</template>