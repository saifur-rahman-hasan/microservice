<template>
  <v-layout justify-center align-center>
    <v-flex xs12 sm8 md6>

      <DailyOrderStatistics class="mb-3" />

      <CurrentCashBalanceReport class="mb-3"/>

      <TotalPurchaseAmountReport class="mb-3" />

      <TotalSaleAmountReport class="mb-3" />

    </v-flex>
  </v-layout>
</template>

<script>
import DailyOrderStatistics from "~/components/DailyOrderStatistics";
import TotalPurchaseAmountReport from "~/components/TotalPurchaseAmountReport";
import TotalSaleAmountReport from "~/components/TotalSaleAmountReport";
import CurrentCashBalanceReport from "~/components/CurrentCashBalanceReport";
export default {
  components: {
    CurrentCashBalanceReport,
    DailyOrderStatistics,
    TotalSaleAmountReport,
    TotalPurchaseAmountReport
  }
}
</script>
