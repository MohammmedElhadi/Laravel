<template>
    <v-simple-table>
        <template v-slot:default>
            <thead>
            <tr>
                <th class="text-left">Name</th>
                <th class="text-left">Price</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="product in products" :key="product.name">
                <td>{{ product.name }}</td>
                <td>{{ product.price }}</td>
            </tr>
            </tbody>
        </template>
    </v-simple-table>
</template>

<script>
    export default {
        data() {
            return {
                'header': 'Products',
                'products': [
                    {'name': 'Product 1', 'price': 10},
                    {'name': 'Product 2', 'price': 20},
                    {'name': 'Product 3', 'price': 30},
                ]
            }
        }
    }
</script>
