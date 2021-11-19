<template>
<Head title="Listings Management" />

<BreezeAuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Listings
        </h2>
    </template>

    <!-- list of listings in a table -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="flex flex-col mt-8">
                    <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                        <div class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                            <table class="min-w-full">
                                <thead>
                                    <tr>
                                        <th v-for="(item, index) in tableHead" :key="index" class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                            {{item}}</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white">
                                    <tr v-for="(item, index) in listings" :key="index">
                                        <td :class="tdTextStyle">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium leading-5 text-gray-900">
                                                    {{index + 1}}
                                                </div>
                                            </div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium leading-5 text-gray-900">
                                                    {{item.country.name}}
                                                </div>
                                            </div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <div class="text-sm leading-5 text-gray-500">
                                                <span v-for="(item, index) in item.casinos" :key="index" class="text-xs px-2 py-0.5 font-bold bg-gray-100 text-gray-600 rounded mx-2">
                                                    {{item.casino.name}}
                                                </span>
                                            </div>
                                        </td>

                                        <td @click="openEditModal(index)" class="link px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit a casino modal -->
    <div v-if="isEditModal" class="container flex justify-center mx-auto">
        <button class="px-6 py-2 text-white bg-blue-600 rounded shadow-xl" type="button">open
            model</button>
        <div class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
            <div class="w-2/5 p-6 bg-white">
                <div class="flex items-center justify-between">
                    <div class="my-3 flex-shrink-0 w-10 h-10">
                        <img class="w-10 h-10 rounded-full" :src="activeListing.logo_url" :alt="activeListing.name">
                    </div>
                    <span> Edit {{activeListing.name}}</span>
                    <svg @click="isEditModal = false" xmlns="http://www.w3.org/2000/svg" class="link w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="my-4">
                    <h6 v-if="canUpdate !== true" class="my-4 text-center text-red-700">{{canUpdate}}</h6>

                    <div class="mt-4">
                        <BreezeLabel for="name" value="Name" />
                        <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="activeListing.name" autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="affiliate_link" value="Affiliate link" />
                        <BreezeInput id="affiliate_link" type="text" class="mt-1 block w-full" v-model="activeListing.affiliate_link" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel class="text-sm text-red-600" for="logo" value="logo (size must be 180 * 90)" />
                        <input class="mt-1 block w-full" id="updateFile" ref="updateFile" type="file" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="bonus_information" value="Bonus Information" />
                        <BreezeTextBox id="bonus_information" type="text" class="mt-1 block w-full" v-model="activeListing.bonus_information" />
                    </div>

                    <div @click="updateListing" class="mt-4">
                        <BreezeButton @click="updateListing" :disabled="canUpdate === true ? false : 'disabled'" class="my-4">
                            {{newListing.name ? `Update ${newListing.name}` : 'Update Listing'}}
                        </BreezeButton>
                    </div>
                </div>
            </div>
        </div>
    </div>

</BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import BreezeButton from '@/Components/Button.vue'
import BreezeTextBox from '@/components/TextBox.vue'
import BreezeInput from '@/Components/Input.vue'
import BreezeLabel from '@/Components/Label.vue'
import {
    subString
} from "@/plugins/utitlities"
import {
    getCall,
    postCall
} from "@/plugins/apiCall";
import {
    Head
} from "@inertiajs/inertia-vue3";
import {
    GET_ALL_LISTINGS,
    UPDATE_CASINO_LISTINGS,
} from '@/plugins/endPoints';

export default {
    components: {
        BreezeAuthenticatedLayout,
        BreezeInput,
        BreezeLabel,
        BreezeButton,
        BreezeTextBox,
        Head,
    },

    data: () => {
        return {
            isEditModal: false,
            activeListing: {},
            password: "",
            isCreateModal: false,
            newListing: {
                name: "Fred olad",
                bonus_information: "https://laravel.com/docs/8.x/validation",
                affiliate_link: "https://laravel.com/docs/8.x/validation"
            },
            activeListingIndex: null,
            tdTextStyle: "px-6 py-4 whitespace-no-wrap border-b border-gray-200",
            buttonStyle: "inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
        }
    },

    computed: {
        canUpdate() {
            if (!this.activeListing.name || this.activeListing.name.length < 5) return "Name is required";
            if (!this.activeListing.affiliate_link || this.activeListing.affiliate_link < 5) return "Affiliate link is required";
            if (!this.activeListing.bonus_information || this.activeListing.bonus_information < 5) return "Bonus information is required";

            return true;
        },

        tableHead: () => ["SN", "Name", "listings", "Update"],
        listings() {
            return this.$store.state.listings;
        }
    },

    created() {
        // if the store is empty then refetch the listings
        if (this.listings < 1) return this.fetchListings();
    },

    methods: {
        fetchListings() {
            getCall(GET_ALL_LISTINGS)
                .then((response) => {
                    return this.$store.commit('updateStore', {
                        data: "listings",
                        value: response.data.data
                    })
                })
                .catch((error) => {
                    let errorMessage = error.response.data.errors ? error.response.data.errors : error.response.data.message;
                    return this.displayAlert(true, errorMessage, "error")
                });
        },

        setActiveListing(index) {
            this.activeListingIndex = this.index;
            this.activeListing = this.listings[index];
        },

        openEditModal(index) {
            this.setActiveListing(index)
            return this.isEditModal = true;
        },

        updateListing() {
            postCall(UPDATE_CASINO_LISTINGS, {
                    name: this.activeUser.name,
                    email: this.activeUser.email,
                    phone_number: this.activeUser.phone_number,
                })
                .then((response) => {
                    this.isEditModal = false
                    this.displayAlert(true, "User updated !!")
                    return this.$store.commit('updateSingleUserInStore', {
                        index: this.activeUserIndex,
                        value: response.data.data
                    })
                })
                .catch((error) => {
                    this.isEditModal = false
                    return this.displayAlert(true, error.response.data, "error")
                });
        },

        displayAlert(statusType, message, type = "success") {
            this.isEditModal = this.isCreateModal = false;
            return this.$store.commit('updateAlert', {
                status: statusType,
                message: message,
                type: type,
            })
        },

        subString(string, length) {
            return subString(string, length);
        }
    }
};
</script>
