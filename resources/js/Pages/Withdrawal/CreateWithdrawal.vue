<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import Select from '@/Components/Select.vue';
import { capitalizeFirstLetter } from '../../utils'


const props = defineProps({
  account: {
    type: Object,
    default: () => ({}),
  },
});

const form = useForm({
  amount: '',
});

const submitForm = () => {
  form.post(route('withdrawal.store', props.account.uuid), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    }
  });
};

const handleKeyPress = (event) => {
  if (event.key === '.') {
    event.preventDefault();
  }
}
</script>

<template>
  <Head title="Create Account" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create withdrawal
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <section class="max-w-xl">
            <header>
              <p class="mt-1 text-sm text-gray-600">
                Account Number: {{ $page.props.account.account_number }} / {{
                  capitalizeFirstLetter($page.props.account.city) }}
              </p>
            </header>
            <div v-if="$page.props.success"
              class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
              <span class="block sm:inline">{{ $page.props.success }}</span>
            </div>
            <form @submit.prevent="submitForm" class="mt-6 space-y-6">

              <div>
                <InputLabel for="amount" value="Amount" />

                <TextInput id="amount" type="number" class="mt-1 block w-full" v-model="form.amount" required autofocus
                  autocomplete="amount" @keypress="event => handleKeyPress(event)"/>

                <InputError class="mt-2" :message="form.errors.amount" />
              </div>


              <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
