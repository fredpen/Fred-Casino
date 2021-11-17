<template>
<div class="flex justify-center mt-2">
    <div :class="`${alertBgColor} ${alertTextColor} flex items-center w-1/2 px-6 py-4 rounded`">
        <span><svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 " fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
            </svg></span>
        <p class="ml-2 mr-5 text-medium">{{alert.message}}</p>
        <span class="link" @click="closeModal()"><svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg></span>
    </div>
</div>
</template>

<script>
export default {
    name: "Alert",

    props: {
        alert: Object,
    },

    computed: {
        alertBgColor() {
            if (!this.alert) return "bg-green-100"
            return this.alert.type == "error" ? "bg-red-100" : "bg-green-100";
        },

        alertTextColor() {
            if (!this.alert) return "text-green-700"
            return this.alert.type == "error" ? "text-red-700" : "text-green-700";
        }
    },

    methods: {
        closeModal() {
            return this.$emit("closeModal");
        }
    }
}
</script>
