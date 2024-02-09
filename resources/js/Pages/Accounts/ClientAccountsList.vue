<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, router } from '@inertiajs/vue3';
import { ref, watch, reactive } from "vue";
import Pagination from "@/Components/Pagination.vue";
import axios from 'axios';
import MovementsList from "@/Pages/Movements/MovementsList.vue";

const isLoading = ref(false);

const state = reactive({
    selectedAccount: {
        uuid: null,
        client_uuid: null,
        type: null,
        city: null,
    },
    movements: null,
    showSuccessMessage: true,
});

const props = defineProps({
    client: {
        type: Object,
        default: () => ({}),
    },
    accounts: {
        type: Object,
        default: () => ({}),
    }
});


const getAccountDetails = async (account) => {
    isLoading.value = true;
    try {
        const response = await axios.get(`/movements/${account.uuid}`);
        state.movements = response.data.movements;
        state.selectedAccount = account;
    } catch (error) {
        console.error(error);
    } finally {
        isLoading.value = false;
    }
};

const setSelectedAccount = (account) => {
    state.selectedAccount = account;
};

const formatBalance = (balance) => {
    const numberBalance = Number(balance);
    return numberBalance.toLocaleString('de-DE', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

const closeMessage = () => {
    state.showSuccessMessage = false;
}

</script>

<template>
    <Head title="account Account list" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Account list for {{ $page.props.client.name }}
            </h2>
        </template>

        <div class="bg-gray-100">
            <div class="mx-auto max-w-8xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-8xl py-16 lg:max-w-none">
                    <div class="lg:gap-x-1 lg:space-y-0 flex flex-row">
                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg basis-2/5">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="flex justify-between items-center mb-2">
                                    <!--<div class="mb-2">
                                <input type="text" v-model="search" placeholder="Search... minimum 3 characters"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-60 p-2.5" />
                            </div>-->
                                    <div>
                                        <h1>Select an Account</h1>
                                    </div>
                                    <div class="text-right">
                                        <Link :href="route('account.form', client.uuid)"
                                            class="inline-block px-6 py-2 text-xs font-medium text-white uppercase transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                        Add New Account
                                        </Link>
                                    </div>
                                </div>
                                <div v-if="$page.props.flash && $page.props.flash.success && state.showSuccessMessage == true"
                                    class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                                    role="alert">
                                    <span class="block sm:inline">{{ $page.props.flash.success }}</span>
                                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3" @click="closeMessage()">
                                        <svg class="fill-current h-6 w-6 text-green-500" role="button"
                                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <title>Close</title>
                                            <path
                                                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z">
                                            </path>
                                        </svg>
                                    </span>
                                </div>

                                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                        <thead
                                            class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                            <tr>
                                                <th scope="col" class="px-6 py-3">Account Number</th>
                                                <th scope="col" class="px-6 py-3">Type</th>
                                                <th scope="col" class="px-6 py-3">City</th>
                                                <th scope="col" class="px-6 py-3">Balance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="account in accounts.data" :key="account.id"
                                                class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-200"
                                                :class="{ 'bg-gray-300': account.uuid === state.selectedAccount.uuid }"
                                                @click="!isLoading && setSelectedAccount(account); !isLoading && getAccountDetails(account)">
                                                <th scope="row"
                                                    class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                                    {{ account.account_number }}
                                                </th>
                                                <td class="px-6 py-4">
                                                    {{ account.type }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    {{ account.city }}
                                                </td>
                                                <td class="px-6 py-4">
                                                    ${{ formatBalance(account.balance) }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Pagination :data="accounts" />
                            </div>
                        </div>

                        <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg basis-3/5">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="flex justify-between items-center mb-2">
                                    <div class="flex items-center mb-2">
                                        <h1>Account Movements</h1>
                                    </div>
                                    <div v-if="state.selectedAccount.uuid" class="">
                                        <div class="text-right">
                                            <Link :href="route('withdrawal.form', state.selectedAccount.uuid)"
                                                class="inline-block mx-2 px-6 py-2 text-xs font-medium text-white uppercase transition-colors duration-200 transform bg-green-600 rounded-md hover:bg-green-500 focus:outline-none focus:bg-green-500">
                                            Make withdrawal
                                            </Link>
                                            <Link :href="route('deposit.form', state.selectedAccount.uuid)"
                                                class="inline-block px-6 py-2 text-xs font-medium text-white uppercase transition-colors duration-200 transform bg-blue-600 rounded-md hover:bg-blue-500 focus:outline-none focus:bg-blue-500">
                                            Make deposit
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div v-if="state.selectedAccount.uuid" class="">
                                <div class="">
                                    <div v-if="isLoading">Cargando...</div>
                                    <div v-else>
                                        <MovementsList :movements="state.movements"></MovementsList>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>
