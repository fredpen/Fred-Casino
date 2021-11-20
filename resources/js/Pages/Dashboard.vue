<template>
<Head title="Dashboard" />

<BreezeAuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <h3 class="h3">Welcome! What would you like to do today?</h3>
                    <nav class="bg-white border-b border-gray-100">
                        <!-- Primary Navigation Menu -->
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div class="flex justify-between h-16">
                                <div class="flex">

                                    <!-- Navigation Links -->
                                    <div class="
                                    sm:-my-px sm:ml-10 sm:flex
                                ">
                                        <BreezeNavLink :href="route('users')" :active="route().current('users')">
                                            MANAGE USERS
                                        </BreezeNavLink> <br>
                                        <BreezeNavLink :href="route('casinos')" :active="route().current('casinos')">
                                            MANAGE CASINOS
                                        </BreezeNavLink> <br>
                                        <BreezeNavLink :href="route('listings')" :active="route().current('listings')">
                                            MANAGE LISTINGS
                                        </BreezeNavLink>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </nav>
                </div>
            </div>
        </div>
    </div>
</BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeNavLink from "@/Components/NavLink.vue";
import {
    Head
} from "@inertiajs/inertia-vue3";

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeNavLink,
        Head,
    },

    props: {
        token: String,
    },

    created() {
        if (this.$store.state.token) return;

        localStorage.setItem("token", this.token);
        return this.$store.commit("updateStore", {
            data: "token",
            value: this.token,
        });
    },
};
</script>
