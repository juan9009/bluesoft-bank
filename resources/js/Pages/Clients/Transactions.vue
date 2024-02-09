<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch } from "vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    clients: {
        type: Object,
        default: () => ({}),
    },
    filters: {
        type: Object,
        default: () => ({}),
    }
});

//const user = usePage().props.auth.user;


// pass filters in search
let month = ref(props.filters.month);
let timeout;
watch(month, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        if (value.length == 0 || value.length >= 3) { // mínimo de 3 caracteres
            router.get(
                "/transactions-clients",
                { month: value },
                {
                    preserveState: true,
                    replace: true,
                }
            );
        }
    }, 1000); // 1000ms delay
});

</script>

<template>
    <Head title="Transactions Rank" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Transactions Rank</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <div class="mb-2">
                                <input type="month" v-model="month" class="...">
                            </div>
                        </div>
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">ID</th>
                                        <th scope="col" class="px-6 py-3">Name</th>
                                        <th scope="col" class="px-6 py-3">Type</th>
                                        <th scope="col" class="px-6 py-3">City</th>
                                        <th scope="col" class="px-6 py-3">Accounts</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="client in clients.data" :key="client.id"
                                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ client.uuid }}
                                        </th>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                            {{ client.name }}
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ client.type }}
                                        </td>
                                        <td class="px-6 py-4">
                                            {{ client.city }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <Link :href="route('accounts.list', client.uuid)"
                                                class="inline-block px-6 py-2 text-xs font-medium text-white uppercase transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                            <i class="fas fa-eye"></i>
                                            </Link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :data="clients" v-if="clients && clients.data && clients.data.length > 0" />
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
