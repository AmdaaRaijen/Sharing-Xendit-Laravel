<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";

const props = defineProps({
    products: {
        type: Array,
        required: true,
    },
});
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
                    <template v-for="product in props.products">
                        <div class="p-5">
                            <div class="flex justify-between">
                                <div class="flex">
                                    <div class="p-2">
                                        <img
                                            :src="product.image"
                                            alt="product image"
                                            class="w-20 h-20"
                                        />
                                    </div>
                                    <div class="p-2">
                                        <div class="text-lg font-semibold">
                                            {{ product.name }}
                                        </div>
                                        <div class="text-sm">
                                            {{ product.description }}
                                        </div>
                                    </div>
                                </div>
                                <div class="p-2">
                                    <div class="text-lg font-semibold">
                                        {{ product.price }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
