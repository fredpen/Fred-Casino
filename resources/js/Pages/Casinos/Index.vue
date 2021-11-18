<template>
<Head title="Casinos Management" />

<BreezeAuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Casinos
        </h2>
    </template>

    <!-- list of casinos in a table -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- new casino button -->
                <button @click="isCreateModal = true" class="px-6 py-2 text-indigo-700 border-2 border-indigo-500 rounded-full hover:bg-indigo-500 hover:text-indigo-100">Create a new Casino</button>

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
                                    <tr v-for="(item, index) in casinos" :key="index">
                                        <td :class="tdTextStyle">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium leading-5 text-gray-900">
                                                    {{index + 1}}
                                                </div>
                                            </div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 w-10 h-10">
                                                    <img class="w-10 h-10 rounded-full" :src="item.logo_url" :alt="item.name">
                                                </div>

                                                <div class="ml-4">
                                                    <div class="text-sm font-medium leading-5 text-gray-900">
                                                        {{item.name}}
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <div class="text-sm leading-5 text-gray-500"> {{item.affiliate_link}}</div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <div class="text-sm leading-5 text-gray-500"> {{item.bonus_information}}</div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <div class="text-sm leading-5 text-gray-500"> {{item.created_at ? subString(item.created_at, 10) : 'few seconds ago'}}</div>
                                        </td>

                                        <td @click="openEditModal(index)" class="link px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </td>
                                        <td @click="deleteCasino(index)" class="link px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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

    <!-- create casino modal -->
    <div v-if="isCreateModal" class="container flex justify-center mx-auto">
        <button class="px-6 py-2 text-white bg-blue-600 rounded shadow-xl" type="button">open
            model</button>
        <div class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
            <div class="max-w-5xl  w-2/5 p-6 bg-white">
                <div class="flex items-center justify-between">
                    <h3 class="my-3 text-center">Create a new Casino</h3>
                    <svg @click="isCreateModal = false" xmlns="http://www.w3.org/2000/svg" class="link w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="my-4">
                    <h6 v-if="canCreate !== true" class="my-4 text-center text-red-700">{{canCreate}}</h6>

                    <div class="mt-4">
                        <BreezeLabel for="name" value="Name" />
                        <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="newCasino.name" required autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="affiliate_link" value="Affiliate link" />
                        <BreezeInput id="affiliate_link" type="text" class="mt-1 block w-full" v-model="newCasino.affiliate_link" required />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel class="text-sm text-red-600" for="logo" value="logo (size must be 180 * 90)" />
                        <input class="mt-1 block w-full" id="file" ref="file" type="file" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="bonus_information" value="Bonus Information" />
                        <BreezeTextBox id="bonus_information" type="text" class="mt-1 block w-full" v-model="newCasino.bonus_information" />
                    </div>

                    <div class="mt-4">
                        <BreezeButton @click="createCasino" :disabled="canCreate === true ? false : 'disabled'" class="my-4">
                            {{newCasino.name ? `Create ${newCasino.name}` : 'Create Casino'}}
                        </BreezeButton>
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
                        <img class="w-10 h-10 rounded-full" :src="activeCasino.logo_url" :alt="activeCasino.name">
                    </div>
                    <span> Edit {{activeCasino.name}}</span>
                    <svg @click="isEditModal = false" xmlns="http://www.w3.org/2000/svg" class="link w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="my-4">
                    <h6 v-if="canUpdate !== true" class="my-4 text-center text-red-700">{{canUpdate}}</h6>

                    <div class="mt-4">
                        <BreezeLabel for="name" value="Name" />
                        <BreezeInput id="name" type="text" class="mt-1 block w-full" v-model="activeCasino.name" autocomplete="name" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="affiliate_link" value="Affiliate link" />
                        <BreezeInput id="affiliate_link" type="text" class="mt-1 block w-full" v-model="activeCasino.affiliate_link" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel class="text-sm text-red-600" for="logo" value="logo (size must be 180 * 90)" />
                        <input class="mt-1 block w-full" id="updateFile" ref="updateFile" type="file" />
                    </div>

                    <div class="mt-4">
                        <BreezeLabel for="bonus_information" value="Bonus Information" />
                        <BreezeTextBox id="bonus_information" type="text" class="mt-1 block w-full" v-model="activeCasino.bonus_information" />
                    </div>

                    <div @click="updateCasino" class="mt-4">
                        <BreezeButton @click="updateCasino" :disabled="canUpdate === true ? false : 'disabled'" class="my-4">
                            {{newCasino.name ? `Update ${newCasino.name}` : 'Update Casino'}}
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
    deleteCall,
    getCall,
    postCall,
    putCall
} from "@/plugins/apiCall";
import {
    Head
} from "@inertiajs/inertia-vue3";
import {
    CREATE_A_CASINO,
    Dynamic_endpoints,
    GET_ALL_CASINOS,
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
            activeCasino: {},
            password: "",
            isCreateModal: false,
            newCasino: {
                name: "Fred olad",
                bonus_information: "https://laravel.com/docs/8.x/validation",
                affiliate_link: "https://laravel.com/docs/8.x/validation"
            },
            activeCasinoIndex: null,
            tdTextStyle: "px-6 py-4 whitespace-no-wrap border-b border-gray-200",
            buttonStyle: "inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150"
        }
    },

    computed: {
        canCreate() {
            if (!this.newCasino.name || this.newCasino.name.length < 5) return "Name is required";
            if (!this.newCasino.affiliate_link || this.newCasino.affiliate_link < 5) return "Affiliate link is required";
            if (!this.newCasino.bonus_information || this.newCasino.bonus_information < 5) return "Bonus information is required";

            return true;
        },

        canUpdate() {
            if (!this.activeCasino.name || this.activeCasino.name.length < 5) return "Name is required";
            if (!this.activeCasino.affiliate_link || this.activeCasino.affiliate_link < 5) return "Affiliate link is required";
            if (!this.activeCasino.bonus_information || this.activeCasino.bonus_information < 5) return "Bonus information is required";

            return true;
        },

        tableHead: () => ["SN", "Name", "Affiliate link", "Bonus Information", "Joined On", "Edit", "Delete"],
        casinos() {
            return this.$store.state.casinos;
        }
    },

    created() {
        // if the store is empty then refetch the casinos
        if (this.casinos < 1) return this.fetchCasinos();
    },

    methods: {
        fetchCasinos() {
            getCall(GET_ALL_CASINOS)
                .then((response) => {
                    return this.$store.commit('updateStore', {
                        data: "casinos",
                        value: response.data.data
                    })
                })
                .catch((error) => {
                    let errorMessage = error.response.data.errors ? error.response.data.errors : error.response.data.message;
                    return this.displayAlert(true, errorMessage, "error")
                });
        },

        deleteCasino(index) {
            this.setActiveCasino(index);
            deleteCall(Dynamic_endpoints.DELETE_CASINO_BY_ID(this.activeCasino.id))
                .then(() => {
                    this.isEditModal = false
                    this.displayAlert(true, "Casino Deleted !!")
                    return this.$store.commit('deleteSingleCasino', this.activeCasinoIndex)
                })
                .catch((error) => {
                    this.isEditModal = false
                    let errorMessage = error.response.data.errors ? error.response.data.errors : error.response.data.message;
                    return this.displayAlert(true, errorMessage, "error")
                });
        },

        setActiveCasino(index) {
            this.activeCasinoIndex = this.index;
            this.activeCasino = this.casinos[index];
        },

        openEditModal(index) {
            this.setActiveCasino(index)
            return this.isEditModal = true;
        },

        updateCasino() {
            let requestData = new FormData();
            if (this.$refs.updateFile.files[0]) {
                requestData.append('logo', this.$refs.updateFile.files[0]);
            }

            requestData.append('name', this.activeCasino.name);
            requestData.append('affiliate_link', this.activeCasino.affiliate_link);
            requestData.append('bonus_information', this.activeCasino.bonus_information);

            postCall(Dynamic_endpoints.UPDATE_CASINO_BY_ID(this.activeCasino.id), requestData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((response) => {
                    this.isEditModal = false
                    this.displayAlert(true, "Casino updated !!")
                    return this.$store.commit('updateSingleCasinoInStore', {
                        index: this.activeCasinoIndex,
                        value: response.data.data
                    })
                })
                .catch((error) => {
                    this.isEditModal = false
                    let errorMessage = error.response.data.errors ? error.response.data.errors : error.response.data.message;
                    return this.displayAlert(true, errorMessage, "error")
                });
        },

        createCasino() {
            let requestData = new FormData();
            requestData.append('name', this.newCasino.name);
            requestData.append('logo', this.$refs.file.files[0]);
            requestData.append('affiliate_link', this.newCasino.affiliate_link);
            requestData.append('bonus_information', this.newCasino.bonus_information);

            postCall(CREATE_A_CASINO, requestData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then((response) => {
                    this.displayAlert(true, "Casino Created !!")
                    return this.$store.commit('createSingleCasinoInStore', response.data.data)
                })
                .catch((error) => {
                    let errorMessage = error.response.data.errors ? error.response.data.errors : error.response.data.message;
                    return this.displayAlert(true, errorMessage, "error")
                }).finally(() => {
                    this.isCreateModal = false
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
