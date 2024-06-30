<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
    avatar_url: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
    avatar: user.avatar,
    avatar_file: null,
});

const avatarChange = (event) => {
    form.avatar_file = event.target.files[0];
};

const submitForm = () => {
    const formData = new FormData();

    formData.append('name', form.name);
    formData.append('email', form.email);
    formData.append('avatar', form.avatar);
    if (form.avatar_file) {
        formData.append('avatar_file', form.avatar_file);
    }
    formData.append('_method', 'patch')

    form.post(route('profile.update'), {
        data: formData,
        forceFormData: true,
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Profile Information</h2>

            <p class="mt-1 text-sm text-gray-600">
                Update your account's profile information and email address.
            </p>
        </header>

        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <div class="flex space-x-4">
                <div class="w-1/2">
                    <div>
                        <InputLabel for="name" value="Name" />

                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />

                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="my-6">
                        <InputLabel for="email" value="Email" />

                        <TextInput
                            id="email"
                            type="email"
                            class="mt-1 block w-full"
                            v-model="form.email"
                            required
                            autocomplete="username"
                        />

                        <InputError class="mt-2" :message="form.errors.email" />
                    </div>

                    <div v-if="mustVerifyEmail && user.email_verified_at === null">
                        <p class="text-sm mt-2 text-gray-800">
                            Your email address is unverified.
                            <Link
                                :href="route('verification.send')"
                                method="post"
                                as="button"
                                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            >
                                Click here to re-send the verification email.
                            </Link>
                        </p>

                        <div
                            v-show="status === 'verification-link-sent'"
                            class="mt-2 font-medium text-sm text-green-600"
                        >
                            A new verification link has been sent to your email address.
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                        </Transition>
                    </div>
                </div>

                <div class="w-1/2">
                    <div class="text-center mb-1 block font-medium text-sm text-gray-700">
                        Avatar
                    </div>

                    <div class="w-40 h-40 border mx-auto mb-5 rounded-full overflow-hidden">
                        <a href="#" @click.prevent="$refs.change.click">
                            <img :src="avatar_url" alt="" title="Click to add/change" class="w-40 h-40">
                        </a>
                    </div>

                    <div hidden>
                        <input type="file" ref="change" @change="avatarChange" class="">
                    </div>
                </div>
            </div>
        </form>
    </section>
</template>
