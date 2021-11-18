<template>
<Head title="Users Management" />

<BreezeAuthenticatedLayout>
    <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin Users
        </h2>
    </template>

    <!-- list of users in a table -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <!-- new user button -->
                <button @click="isCreateModal = true" class="px-6 py-2 text-indigo-700 border-2 border-indigo-500 rounded-full hover:bg-indigo-500 hover:text-indigo-100">Create a new User</button>

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
                                    <tr v-for="(item, index) in users" :key="index">
                                        <td :class="tdTextStyle">
                                            <div class="ml-4">
                                                <div class="text-sm font-medium leading-5 text-gray-900">
                                                    {{index + 1}}
                                                </div>
                                            </div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <div class="text-sm font-medium leading-5 text-gray-900"> {{item.name}}</div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <div class="text-sm leading-5 text-gray-500"> {{item.email}}</div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <div class="text-sm leading-5 text-gray-500"> {{item.phone_number}}</div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <div class="text-sm leading-5 text-gray-500"> {{item.created_at ? subString(item.created_at, 10) : 'few seconds ago'}}</div>
                                        </td>

                                        <td :class="tdTextStyle">
                                            <span class="inline-flex px-2 text-xs font-semibold leading-5 text-green-800 bg-green-100 rounded-full"> Active</span>
                                        </td>

                                        <td @click="openEditModal(index)" class="link px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </td>
                                        <td @click="deleteUser(index)" class="link px-6 py-4 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200">
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

    <!-- create user modal -->
    <div v-if="isCreateModal" class="container flex justify-center mx-auto">
        <button class="px-6 py-2 text-white bg-blue-600 rounded shadow-xl" type="button">open
            model</button>
        <div class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
            <div class="max-w-5xl  w-2/5 p-6 bg-white">
                <div class="flex items-center justify-between">
                    <h3 class="my-3 text-center">Create a new User</h3>
                    <svg @click="isCreateModal = false" xmlns="http://www.w3.org/2000/svg" class="link w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="my-4">
                    <h6 v-if="canCreateUser !== true" class="my-4 text-center text-red-700">{{canCreateUser}}</h6>
                    <div class="my-5"> <label for="name" class="block font-bold text-gray-600">Name</label>
                        <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-l shadow focus:outline-none focus:ring-2 focus:ring-purple-300" v-model="newUser.name"></div>

                    <div class="my-5"> <label for="phone_number" class="block font-bold text-gray-600">Phone</label>
                        <input type="phone" name="phone_number" class="w-full p-2 border border-gray-300 rounded-l shadow focus:outline-none focus:ring-2 focus:ring-purple-300" v-model="newUser.phone_number"></div>

                    <div class="my-5"> <label for="email" class="block font-bold text-gray-600">Email</label>
                        <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded-l shadow focus:outline-none focus:ring-2 focus:ring-purple-300" v-model="newUser.email"></div>

                    <div class="my-5"> <label for="password" class="block font-bold text-gray-600">password</label>
                        <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded-l shadow focus:outline-none focus:ring-2 focus:ring-purple-300" v-model="newUser.password"></div>

                    <div class="max-w-2xl p-6 bg-white my-5">
                        <button @click="createUser" :disabled="canCreateUser === true ? true : 'disabled'" class="link block p-3 font-bold text-white bg-blue-500 rounded-l">
                            {{newUser.name ? `Create ${newUser.name}` : 'Create User'}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- edit a user modal -->
    <div v-if="isEditModal" class="container flex justify-center mx-auto">
        <button class="px-6 py-2 text-white bg-blue-600 rounded shadow-xl" type="button">open
            model</button>
        <div class="absolute inset-0 flex items-center justify-center bg-gray-700 bg-opacity-50">
            <div class="max-w-5xl  w-4/5 p-6 bg-white">
                <div class="flex items-center justify-between">
                    <h3 class="my-3 text-center">Update {{activeUser.name}}</h3>
                    <svg @click="isEditModal = false" xmlns="http://www.w3.org/2000/svg" class="link w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="my-4">
                    <h6 v-if="canUpdateUser !== true" class="my-4 text-center text-red-700">{{canUpdateUser}}</h6>
                    <div class="grid gap-4 grid-cols-2 mb-5">
                        <div> <label for="name" class="block font-bold text-gray-600">Name</label>
                            <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-l shadow focus:outline-none focus:ring-2 focus:ring-purple-300" v-model="activeUser.name"></div>
                    </div>

                    <div class="grid gap-4 grid-cols-2 mb-5">
                        <div> <label for="email" class="block font-bold text-gray-600">Email</label>
                            <input type="email" name="email" class="w-full p-2 border border-gray-300 rounded-l shadow focus:outline-none focus:ring-2 focus:ring-purple-300" v-model="activeUser.email"></div>
                        <div> <label for="phone_number" class="block font-bold text-gray-600">Phone</label>
                            <input type="phone" name="phone_number" class="w-full p-2 border border-gray-300 rounded-l shadow focus:outline-none focus:ring-2 focus:ring-purple-300" v-model="activeUser.phone_number"></div>
                    </div>

                    <div class="max-w-2xl p-6 bg-white">
                        <button @click="updateUser" :disabled="canUpdateUser === true ? true : 'disabled'" class="link block p-3 font-bold text-white bg-blue-500 rounded-l">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import {
    subString
} from "../../plugins/utitlities"
import {
    deleteCall,
    getCall,
    postCall,
    putCall
} from "../../plugins/apiCall";
import {
    Head
} from "@inertiajs/inertia-vue3";
import {
    CREATE_A_USER,
    Dynamic_endpoints,
    GET_ALL_USERS
} from '@/plugins/endPoints';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
    },

    data: () => {
        return {
            isEditModal: false,
            activeUser: {},
            password: "",
            isCreateModal: false,
            newUser: {},
            activeUserIndex: null,
            tdTextStyle: "px-6 py-4 whitespace-no-wrap border-b border-gray-200",
        }
    },

    computed: {
        canCreateUser() {
            if (!this.newUser.name || this.newUser.name.length < 5) return "Name is required";
            if (!this.newUser.phone_number || this.newUser.phone_number.length < 11) return "Phone is required";
            if (!this.newUser.email || this.newUser.name.email < 5) return "Email is required";
            if (!this.newUser.password || this.newUser.name.password < 5) return "Password is required";

            return true;
        },

        canUpdateUser() {
            if (!this.activeUser.name || this.activeUser.name.length < 5) return "Name is required";
            if (!this.activeUser.phone_number || this.activeUser.phone_number.length < 11) return "Phone is required";
            if (!this.activeUser.email || this.activeUser.name.email < 5) return "Email is required";

            return true;
        },

        tableHead: () => ["SN", "Name", "Email", "Phone", "Joined On", "Status", "Edit", "Delete"],
        users() {
            return this.$store.state.users;
        }
    },

    created() {
        if (this.users < 1) return this.fetchUsers();
    },

    methods: {
        fetchUsers() {
            getCall(GET_ALL_USERS)
                .then((response) => {
                    return this.$store.commit('updateStore', {
                        data: "users",
                        value: response.data.data
                    })
                })
                .catch((error) => {
                    return this.displayAlert(true, error.response.data, "error")
                });
        },

        deleteUser(index) {
            this.setActiveUser(index);
            deleteCall(Dynamic_endpoints.DELETE_USER_BY_ID(this.activeUser.id))
                .then(() => {
                    this.isEditModal = false
                    this.displayAlert(true, "User Deleted !!")
                    return this.$store.commit('deleteSingleUser', this.activeUserIndex)
                })
                .catch((error) => {
                    this.isEditModal = false
                    return this.displayAlert(true, error.response.data.message, "error")
                });
        },

        setActiveUser(index) {
            this.activeUserIndex = this.index;
            this.activeUser = this.users[index];
        },

        openEditModal(index) {
            this.setActiveUser(index)
            return this.isEditModal = true;
        },

        updateUser() {
            if (!this.activeUser) return false;
            putCall(Dynamic_endpoints.UPDATE_USER_BY_ID(this.activeUser.id), {
                    name: this.activeUser.name,
                    email: this.activeUser.email,
                    phone_number: this.activeUser.phone_number,
                })
                .then(() => {
                    this.isEditModal = false
                    this.displayAlert(true, "User updated !!")
                    return this.$store.commit('updateSingleUserInStore', {
                        index: this.activeUserIndex,
                        value: this.activeUser
                    })
                })
                .catch((error) => {
                    this.isEditModal = false
                    return this.displayAlert(true, error.response.data, "error")
                });
        },

        createUser() {
            if (!this.newUser) return false;
            // return console.log(this.newUser);;
            postCall(CREATE_A_USER, this.newUser)
                .then((response) => {
                    this.displayAlert(true, "User Created !!")
                    return this.$store.commit('createSingleUserInStore', response.data.data.user)
                })
                .catch((error) => {
                    return this.displayAlert(true, error.response.data, "error")
                }).finally(() => {
                    this.isCreateModal = false
                });
        },

        displayAlert(status, message, type = "success") {
            return this.$store.commit('updateAlert', {
                status: status,
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
