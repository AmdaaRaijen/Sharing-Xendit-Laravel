<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import VDataTable from "@/components/VDataTable/index.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { router } from "@inertiajs/vue3";
import { notify } from "notiwind";
import { ref } from "vue";

const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
});

const isLoading = ref(false);

const head = ["Name", "image", "status", "Price", "Action"];

const toRupiah = (price) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(price);
};

const statusColor = (status) => {
    if (status === "Need Payment") {
        return "px-4 whitespace-nowrap h-16 p-2 font-semibold text-red-500";
    } else if (status === "Pending") {
        return "px-4 whitespace-nowrap h-16 p-2 font-semibold text-yellow-500";
    } else if (status === "Success") {
        return "px-4 whitespace-nowrap h-16 p-2 font-semibold text-green-500";
    }
};

const handlePayment = async (id) => {
    isLoading.value = true;
    axios
        .post(route("products.create-payment", { id: id }))
        .then((res) => {
            window.location.reload();
        })
        .finally(() => (isLoading.value = false));
};
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Product
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-5">Product</div>
                    <VDataTable :heads="head">
                        <tr v-for="product in props.products">
                            <td class="px-4 whitespace-nowrap h-16">
                                {{ product.name }}
                            </td>
                            <td class="px-4 whitespace-nowrap h-16 p-2">
                                <img
                                    :src="product.image"
                                    alt=""
                                    class="w-20 h-20 border border-gray-200 rounded-sm"
                                />
                            </td>
                            <td
                                :class="
                                    statusColor(
                                        product.payments.status ??
                                            'Need Payment'
                                    )
                                "
                            >
                                {{ product.payments.status ?? "Need Payment" }}
                            </td>
                            <td class="px-4 whitespace-nowrap h-16 p-2">
                                {{ toRupiah(product.price) }}
                            </td>
                            <td class="px-4 whitespace-nowrap h-16 p-2">
                                <PrimaryButton
                                    :disabled="isLoading"
                                    @click="handlePayment(product.id)"
                                    >Pay</PrimaryButton
                                >
                            </td>
                        </tr>
                    </VDataTable>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
