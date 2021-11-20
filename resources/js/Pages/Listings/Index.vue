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
            <div class="w-3/5 p-6 bg-white">
                <div class="flex items-center justify-between">
                    <span> {{activeListing.country.name}}'s Listings</span>
                    <svg @click="isEditModal = false" xmlns="http://www.w3.org/2000/svg" class="link w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="my-4">
                    <h6 v-if="canUpdate !== true" class="my-4 text-center text-red-700">{{canUpdate}}</h6>

                    <div class="text-sm leading-5 text-gray-500">
                        <p>Current Listings <small>(Click X to remove a listing)</small></p>
                        <div class="mt-4">
                            <div class="max-w-xl p-4">
                                <div class="p-4 bg-white rounded shadow-md">
                                    <button @click="removeListing(index)" style="margin:5px" v-for="(item, index) in activeListing.casinos" :key="index" class="h-10 px-5 font-bold bg-gray-100 text-gray-600  ">
                                        <span class="mr-2"> {{item.casino.name}}</span>
                                        <span class="inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-black-100 bg-black-600 rounded-full">
                                            <span class="link">
                                                <span style="font-size:18px">x</span>
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="text-sm leading-5 text-gray-500">
                        <div class="mt-4">
                            <p>Available Listings <small>(Click + to add a listing)</small></p>
                            <div class="max-w-xl p-4">
                                <div class="p-8 bg-white rounded shadow-md">
                                    <button @click="addListing(index)" style="margin:5px" v-for="(item, index) in availableListings" :key="index" class="h-10 px-5 font-bold bg-gray-100 text-gray-600  ">
                                        <span class="mr-2"> {{item.name}}</span>
                                        <span class="inline-flex items-center justify-center py-1 text-xs font-bold leading-none text-black-100 bg-black-600 rounded-full">
                                            <span class="link">
                                                <span style="font-size:18px">+</span>
                                            </span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div @click="updateListing" class="mt-4">
                        <BreezeButton :disabled="canUpdate === true ? false : 'disabled'" class="my-4">
                            Update {{activeListing.country.name}}'s' Listings
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
            availableListings: [],
            activeListingIndex: null,
            tdTextStyle: "px-6 py-4 whitespace-no-wrap border-b border-gray-200",
            buttonStyle: "inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
        }
    },

    computed: {
        canUpdate() {
            return true;
        },

        casinos() {
            return this.$page.props.casinos
        },

        tableHead: () => ["SN", "Country", "listings", "Update"],
        listings() {
            return this.$store.state.listings;
        }
    },

    created() {
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
            this.activeListingIndex = index;
            this.activeListing = JSON.parse(JSON.stringify(this.listings[index]));

            let casinos = JSON.parse(JSON.stringify(this.casinos));
            let currentListing = JSON.parse(JSON.stringify(this.activeListing));
            let currentListingIds = currentListing.casinos.map(value => value.casino.id);

            this.availableListings = casinos.filter(value => !currentListingIds.includes(value.id));
        },

        removeListing(index) {
            let ele = this.activeListing.casinos.splice(index, 1);
            this.availableListings.push(ele[0].casino)
        },

        addListing(index) {
            let ele = this.availableListings.splice(index, 1);
            this.activeListing.casinos.push({
                casino: ele[0]
            })
        },

        openEditModal(index) {
            this.setActiveListing(index)
            return this.isEditModal = true;
        },

        updateListing() {
            let requestObject = {
                country_id: this.activeListing.country.id,
                casinoIds: this.activeListing.casinos.map(value => value.casino.id)
            };

            postCall(UPDATE_CASINO_LISTINGS, requestObject)
                .then((response) => {
                    this.displayAlert(true, "Listings updated !!")
                      this.listings[this.activeListingIndex] = this.activeListing;
                    return this.$store.commit('updateSingleListingsInStore', {
                        index: this.activeListingIndex,
                        value: this.activeListing
                    })
                })
                .catch((error) => {
                    this.displayAlert(true, error.response.data, "error")
                }).finally(() => {
                    this.isEditModal = false
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
