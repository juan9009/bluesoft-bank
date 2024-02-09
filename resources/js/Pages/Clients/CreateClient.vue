<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { useForm } from '@inertiajs/vue3';
import Select from '@/Components/Select.vue';

defineProps({
  mustVerifyEmail: {
    type: Boolean,
  },
  status: {
    type: String,
  },
});

const form = useForm({
  name: '',
  city: '',
  type: '',
});

// Define your options for the Select component
const typeOptions = [
  { value: 'individual', label: 'Individual' },
  { value: 'business', label: 'Business' },
  // Add more options as needed
];

const submitForm = () => {
  form.post(route('clients.store'), {
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    }
  });
};
</script>

<template>
  <Head title="Create client" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create client</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
          <section class="max-w-xl">
            <header>
              <h2 class="text-lg font-medium text-gray-900">Create client</h2>

              <p class="mt-1 text-sm text-gray-600">
                Create a new client.
              </p>
            </header>
            <div v-if="$page.props.success"
              class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
              <span class="block sm:inline">{{ $page.props.success }}</span>
            </div>
            <form @submit.prevent="submitForm" class="mt-6 space-y-6">

              <div>
                <InputLabel for="name" value="Name" />

                <TextInput id="name" type="text" class="mt-1 block w-full" v-model="form.name" required autofocus
                  autocomplete="name" />

                <InputError class="mt-2" :message="form.errors.name" />
              </div>

              <div>
                <InputLabel for="city" value="City" />

                <TextInput id="city" type="text" class="mt-1 block w-full" v-model="form.city" required
                  autocomplete="city" />

                <InputError class="mt-2" :message="form.errors.city" />
              </div>

              <div>
                <InputLabel for="type" value="Type" />

                <Select :modelValue="form.type" :options="typeOptions" @update:modelValue="form.type = $event" required />
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
