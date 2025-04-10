<script>
import {EventBus} from "../../../event-bus";
import {commonFunctions} from "../../../components/mixins/common-functions";

export default {
    name: "DealsIndexComponent",
    props: {
        deals: {
            type: Object,
            required: false
        },
    },
    mixins: [
        commonFunctions
    ],
    data() {
        return {
            deals: this.deals
        };
    },
    created() {
        EventBus.on('dealWasStored', (data) => {
            this.isVisible = false;
            this.getDealsList();
            this.successMessage = 'Deal was added successfully!';
        });
        EventBus.on('dealWasUpdated', (data) => {
            this.getDealsList();
            this.successMessage = 'Deal was updated successfully!';
        });
    },
    methods: {
        openAddDealModal() {
            EventBus.emit('openAddDealModal');
        },
        openEditDealModal(id) {
            const data = {
                id: id,
            };
            EventBus.emit('openEditDealModal', data);
        },
        getDealsList() {
            axios.get('/api/deal', []).then(response => {
                this.deals = response.data;
                console.log('/api/deal')
                console.log(this.deals)
            })
        }
    }
}
</script>

<template>
    <div>
        <h3>Deals</h3>
        <div class="alert alert-success" role="alert" v-if="successMessage">
            {{ successMessage }}
        </div>
        <button @click="openAddDealModal" class="btn btn-primary">Add deal</button>
        <div class="row mt-3">
            <table>
                <thead>
                <tr>
                    <th>Deal Name</th>
                    <th>Stage</th>
                    <th>Account Name</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="deal in deals">
                    <td>{{deal.Deal_Name}}</td>
                    <td>{{deal.Stage}}</td>
                    <td>{{deal.Account_Name!=null ? deal.Account_Name.name : ''}}</td>
                    <td><button class="btn btn-primary" @click="openEditDealModal(deal.id)"><font-awesome-icon icon="pencil-alt" title="Edit deal" /></button></td>
                </tr>
                </tbody>

            </table>
        </div>
    </div>
</template>

<style scoped>

</style>
