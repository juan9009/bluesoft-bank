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
    },
    month: String,
});

//const user = usePage().props.auth.user;

</script>

<template>
    <Head title="Transactions Rank" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Clients who made withdrawals outside the city for
                a minimum of $1,000.000</h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div v-if="clients && clients.data && clients.data.length > 0"
                        class="p-6 bg-white border-b border-gray-200">
                        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">ID</th>
                                        <th scope="col" class="px-6 py-3">Name</th>
                                        <th scope="col" class="px-6 py-3">Type</th>
                                        <th scope="col" class="px-6 py-3">City</th>
                                        <th scope="col" class="px-6 py-3">Transactions</th>
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
                                            {{ client.transactions_count }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <Pagination :data="clients" v-if="clients && clients.data && clients.data.length > 0" />
                    </div>
                    <div v-else>
                        <div class="items-center mt-4 text-center">
                            <h2 class="font-semibold text-xl text-gray-400 leading-tight">There are no clients.
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
