<script>
import {EventBus} from "../../../event-bus";
import {commonFunctions} from "../../../components/mixins/common-functions.js"
export default {
    name: "AccountsIndexComponent",
    props: {
        accounts: {
            type: Object,
            required: false
        },
    },
    mixins: [
        commonFunctions
    ],
    created() {
        EventBus.on('accountWasStored', (data) => {
            this.isVisible = false;
            this.getAccountsList();
            this.successMessage = 'Account was added successfully!';
        });
    },
    methods: {
        openAccountDealsList(accountId, accountName) {
            console.log('showAccountDealsList')
            const data = {
                accountId: accountId,
                accountName: accountName,
            };
            EventBus.emit('showAccountDealsList', data);
        },
        openAddAccountModal() {
            EventBus.emit('openAddAccountModal');
        },
        getAccountsList() {
            axios.get('/api/account', []).then(response => {
                this.accounts = response.data;
            })
        }
    }
}
</script>

<template>
    <div>
        <h3>Accounts</h3>
        <div class="alert alert-success" role="alert" v-if="successMessage">
            {{ successMessage }}
        </div>
        <button @click="openAddAccountModal" class="btn btn-primary">Add account</button>
        <div class="row mt-3">
            <table>
                <thead>
                <tr>
                    <th>Account Name</th>
                    <th>Website</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="account in accounts">
                    <td>{{account.account_name}}</td>
                    <td>{{account.website}}</td>
                    <td>{{account.phone}}</td>
                    <td>
                        <button class="btn btn-primary" @click="openAccountDealsList(account.id, account.account_name)"><font-awesome-icon icon="eye" title="View assigned deals" /></button>
                    </td>
                </tr>
                </tbody>

            </table>
        </div>

    </div>
</template>

<style scoped>

</style>
