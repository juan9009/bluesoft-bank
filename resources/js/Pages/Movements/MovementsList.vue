<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import Pagination from "@/Components/Pagination.vue";
import axios from 'axios';
import { ref, watch, reactive } from "vue";

const props = defineProps({
    account: {
        type: Object,
        default: () => ({}),
    },
    movements: {
        type: Object,
        default: () => ({}),
    }
});

const formatBalance = (balance) => {
    const numberBalance = Number(balance);
    return numberBalance.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

const emit = defineEmits(['updateMovements']);

// pass filters in search
let monthmovements = ref('');
const isLoading = ref(false);
let timeout;

watch(monthmovements, (value) => {
    clearTimeout(timeout);
    timeout = setTimeout(() => {
        if (value.length == 0 || value.length >= 3) { // mínimo de 3 caracteres
            getAccountDetails();
        }
    }, 1000); // 1000ms delay
});

const getAccountDetails = async () => {
    isLoading.value = true;
    try {
        const response = await axios.get(`/movements/${props.account.uuid}`, {
            params: {
                month: monthmovements.value
            }
        });
        emit('updateMovements', response.data.movements);
    } catch (error) {
        console.error(error);
    } finally {
        isLoading.value = false;
    }
};
</script>

<template>
    <div class="bg-gray-100">
        <div class="lg:gap-x-1 lg:space-y-0 flex flex-row">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg basis-full">
                <div class="items-center mt-4 text-center">
                    <p class="leading-tight">Last Movements</p>
                </div>
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <div class="flex justify-between items-center mb-2">
                            <div class="mb-2">
                                <span class="leading-tight mr-4">Extract by month</span>
                                <input type="month" v-model="monthmovements" class="...">
                            </div>
                        </div>
                        <table v-if="movements && movements.data && movements.data.length > 0"
                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <!--<th scope="col" class="px-6 py-3">ID</th>-->
                                    <th scope="col" class="px-6 py-3">Date</th>
                                    <th scope="col" class="px-6 py-3">Type</th>
                                    <th scope="col" class="px-6 py-3">Amount</th>
                                    <th scope="col" class="px-6 py-3">City</th>
                                    <!--<th scope="col" class="px-6 py-3">Detail</th>-->
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="movement in movements.data" :key="movement.id"
                                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200">
                                    <!--<th scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                    {{ movement.uuid }}
                                                </th>-->
                                    <td class="px-6 py-4">
                                        {{ movement.created_at }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ movement.type }}
                                    </td>
                                    <td class="px-6 py-4">
                                        ${{ formatBalance(movement.amount) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ movement.city }}
                                    </td>
                                    <!--<td class="px-6 py-4">
                                                    <Link :href="route('movement.form', movement.client_uuid)"
                                                        class="inline-block px-6 py-2 text-xs font-medium text-white uppercase transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                                    <i class="fas fa-eye"></i>
                                                    </Link>
                                                </td>-->
                                </tr>
                            </tbody>
                        </table>
                        <div v-else>
                            <div class="items-center mt-4 text-center">

                                <h2 class="font-semibold text-xl text-gray-400 leading-tight">There are no movements.</h2>
                            </div>
                        </div>
                    </div>
                    <Pagination :data="movements" v-if="movements && movements.data && movements.data.length > 0" />
                </div>
            </div>
        </div>
    </div>
</template>
