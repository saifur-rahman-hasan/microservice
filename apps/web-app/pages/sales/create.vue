<template>
  <v-form @submit.prevent="handleSaleCreate">

    <v-snackbar v-model="serviceError">
      {{ serviceErrorMessage }}

      <template v-slot:action="{ attrs }">
        <v-btn color="red" text v-bind="attrs" @click="serviceError=false">Close</v-btn>
      </template>
    </v-snackbar>

    <v-card>
      <v-card-title class="headline">Add new sale</v-card-title>

      <v-card-text>

        <!-- Products List -->
        <v-autocomplete
          dense
          v-model="sale.product"
          :items="products"
          :loading="isLoading"
          :search-input.sync="search"
          color="white"
          hide-no-data
          hide-selected
          item-text="name"
          item-value="id"
          label="Products"
          return-object
        ></v-autocomplete>

        <!-- Product Quantity -->
        <v-text-field
          color="white"
          label="Quantity"
          v-model="sale.productQuantity"
        ></v-text-field>

        <!-- Product Price -->
        <v-text-field
          color="white"
          label="Price"
          v-model="sale.productPrice"
        ></v-text-field>

      </v-card-text>

      <v-card-actions>
        <v-btn type="submit" block>Submit</v-btn>
      </v-card-actions>
    </v-card>

    <pre>{{ sale }}</pre>

  </v-form>
</template>

<script>
  export default {
    name: "create",
    data: () => ({
      serviceError: false,
      serviceErrorMessage: '',
      isLoading: false,
      search: null,
      products: [
        { id: 1, name: 'Brinjal' },
        { id: 2, name: 'Potato' },
        { id: 3, name: 'Tomato' }
      ],
      sale: {
        product: {},
        productQuantity: null,
        productPrice: null,
        productAmount: null
      }
    }),
    methods: {
      async handleSaleCreate() {
        // Validate

        // Prepare Request Data
        const requestData = await this.prepareSaleCreateRequestData( this.sale );

        const config = {
          headers: {
            "Accept": 'application/json',
            "Content-Type": "application/json",
            "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTU5MzQwODczOCwiZXhwIjoxNTkzNDEyMzM4LCJuYmYiOjE1OTM0MDg3MzgsImp0aSI6IjVFWmhHOUZPMHMyMG1HSlIiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.bs0qW6vIPa8vBJGrGwEANdgQKu23OPOYFS7pHOqqRII"
          }
        };

        this.$axios.$post(
          'http://127.0.0.1:8000/api/service-provider/lEX73g772N1Tozww/XF81cVI7ledEhXf2',
          requestData,
          config
        )
          .then(response => {
            console.log( response.data );
          })
          .catch(error => {
            this.serviceError = true
            this.serviceErrorMessage = error.response.data.message
            console.error( error.response.data )
          });

      },

      prepareSaleCreateRequestData( SaleData ) {
        return {
          user_id: 20,
          product: this.sale.product.name,
          quantity: this.sale.productQuantity ?? 0,
          price: this.sale.productPrice ?? 0,
          amount: this.sale.productQuantity * this.sale.productPrice
        }
      }
    }
  }
</script>

<style scoped>

</style>
