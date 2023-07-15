<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import VDataTable from "@/components/VDataTable/index.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { router } from "@inertiajs/vue3";
import Swal from "sweetalert2";
import { ref } from "vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

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
    if (status === "need_payment") {
        return "px-4 whitespace-nowrap h-16 p-2 font-semibold text-red-500";
    } else if (status === "pending") {
        return "px-4 whitespace-nowrap h-16 p-2 font-semibold text-yellow-500";
    } else if (status === "paid") {
        return "px-4 whitespace-nowrap h-16 p-2 font-semibold text-green-500";
    }
};

const handlePayment = async (id) => {
    isLoading.value = true;
    axios
        .post(route("products.create-payment", { id: id }))
        .then((res) => {
            Swal.fire({
                title: "SUCCESS",
                text: "success to create payment",
                icon: "success",
            }).then(() => {
                window.location.reload();
            });
        })
        .catch((err) => {
            Swal.fire({
                title: "FAILED",
                text: err.response.data.message,
                icon: "warning",
            }).then(() => {
                window.location.reload();
            });
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
                            <td :class="statusColor(product.status)">
                                {{
                                    product.status === "need_payment"
                                        ? "Need Payment"
                                        : product.status
                                }}
                            </td>
                            <td class="px-4 whitespace-nowrap h-16 p-2">
                                {{ toRupiah(product.price) }}
                            </td>
                            <td class="px-4 whitespace-nowrap h-16 p-2">
                                <SecondaryButton
                                    v-if="
                                        product.status === 'pending' ||
                                        product.status === 'paid'
                                    "
                                    :disabled="isLoading"
                                    >Detail</SecondaryButton
                                >
                                <PrimaryButton
                                    v-else
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
