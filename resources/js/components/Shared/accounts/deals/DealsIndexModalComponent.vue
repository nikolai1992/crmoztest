<script>
import {commonFunctions} from "../../../../components/mixins/common-functions.js"
import '../../../../../css/shared-styles.css'; // Імпортування стилів
import {EventBus} from "../../../../event-bus";
export default {
    name: "AccountDealsIndexComponent",
    mixins: [
        commonFunctions
    ],
    data() {
        return {
            deals: [],
            accountName: null,
        };
    },
    created() {
        EventBus.on('showAccountDealsList', (data) => {
            console.log(data)
            this.accountName = data.accountName;
            this.deals = this.$options.data().deals;
            axios.get('/api/deals/get-by-account-id/' + data.accountId, []).then(response => {
                this.deals = response.data;
            })
            this.isVisible = true;
        });
    },
    methods: {

    }
}
</script>

<template>
    <div v-if="isVisible" class="modal-backdrop">
        <div class="modal-window">
            <h3>Deals list of account "{{accountName}}"</h3>
            <table cellpadding="10" border="1">
                <thead>
                    <tr>
                        <th>Deal Name</th>
                        <th>Stage</th>
                    </tr>
                </thead>
                <tbody>
                    <template v-if="deals.length > 0">
                        <tr v-for="deal in deals">
                            <td>{{deal.Deal_Name}}</td>
                            <td>{{deal.Stage}}</td>
                        </tr>
                    </template>

                    <!-- Вивід пустого рядка, якщо accounts порожній -->
                    <template v-else>
                        <tr>
                            <td colspan="4">No accounts available</td>
                        </tr>
                    </template>
                </tbody>

            </table><br><br>
            <button type="button" class="btn btn-danger" @click="closeModal">Cancel</button>
        </div>
    </div>
</template>

<style scoped>

</style>
