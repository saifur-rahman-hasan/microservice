<template>
  <v-form @submit.prevent="handlePurchaseCreate">

    <v-snackbar v-model="serviceError">
      {{ serviceErrorMessage }}

      <template v-slot:action="{ attrs }">
        <v-btn color="red" text v-bind="attrs" @click="serviceError=false">Close</v-btn>
      </template>
    </v-snackbar>

    <v-card>
      <v-card-title class="headline">Add new purchase</v-card-title>

      <v-card-text>

          <!-- Products List -->
          <v-autocomplete
            dense
            v-model="purchase.product"
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
            v-model="purchase.productQuantity"
          ></v-text-field>

          <!-- Product Price -->
          <v-text-field
            color="white"
            label="Price"
            v-model="purchase.productPrice"
          ></v-text-field>

      </v-card-text>

      <v-card-actions>
        <v-btn type="submit" block>Submit</v-btn>
      </v-card-actions>
    </v-card>

    <pre>{{ purchase }}</pre>

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
      purchase: {
        product: {},
        productQuantity: null,
        productPrice: null,
        productAmount: null
      }
    }),
    methods: {
      async handlePurchaseCreate() {
        // Validate

        // Prepare Request Data
        const requestData = await this.preparePurchaseCreateRequestData( this.purchase );

        const config = {
          headers: {
            "Accept": 'application/json',
            "Content-Type": "application/json",
            "Authorization": "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTU5MzQwODczOCwiZXhwIjoxNTkzNDEyMzM4LCJuYmYiOjE1OTM0MDg3MzgsImp0aSI6IjVFWmhHOUZPMHMyMG1HSlIiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.bs0qW6vIPa8vBJGrGwEANdgQKu23OPOYFS7pHOqqRII"
          }
        };

        this.$axios.$post(
          'http://127.0.0.1:8000/api/service-provider/MAjgyHT9gtGVNsP8/El9JlwJkBI3PV3HJ',
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

      preparePurchaseCreateRequestData( purchaseData ) {
        return {
          product: this.purchase.product.name,
          quantity: this.purchase.productQuantity ?? 0,
          price: this.purchase.productPrice ?? 0,
          amount: this.purchase.productQuantity * this.purchase.productPrice
        }
      }
    }
  }
</script>

<style scoped>

</style>
