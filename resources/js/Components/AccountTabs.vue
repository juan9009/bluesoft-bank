<script setup>
import { reactive } from 'vue';

const state = reactive({
    activeTab: 'tab1',
});

const setActiveTab = (tab) => {
    state.activeTab = tab;
};
</script>
<template>
    <div class="w-full px-3 bg-white rounded shadow">
        <div class="flex mb-4">
            <button class="px-4 py-2 mr-1 text-sm font-medium text-gray-500 uppercase rounded hover:bg-gray-200"
                :class="{ 'text-blue-500 border-b-2 border-blue-500': state.activeTab === 'tab1' }"
                @click="setActiveTab('tab1')">
                Tab 1
            </button>
            <button class="px-4 py-2 text-sm font-medium text-gray-500 uppercase rounded hover:bg-gray-200"
                :class="{ 'text-blue-500 border-b-2 border-blue-500': state.activeTab === 'tab2' }"
                @click="setActiveTab('tab2')">
                Tab 2
            </button>
        </div>

        <div v-if="state.activeTab === 'tab1'" class="p-5 border rounded">
            <h2 class="mb-4 text-lg font-semibold text-gray-700">Tab 1</h2>
            <p class="text-gray-500">This is the content for Tab 1.</p>
        </div>

        <div v-if="state.activeTab === 'tab2'" class="p-5 border rounded">
            <h2 class="mb-4 text-lg font-semibold text-gray-700">Tab 2</h2>
            <p class="text-gray-500">This is the content for Tab 2.</p>
        </div>
    </div>
</template>