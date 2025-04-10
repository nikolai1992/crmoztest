<template>
    <div v-if="isVisible" class="modal-backdrop">
        <div class="modal-window">
            <button @click="closeModal" class="close-button">X</button>
            <h3>Create deal form</h3>
            <div v-if="errorMessage" class="alert alert-danger">{{errorMessage}}</div>
            <form  @submit.prevent="sendRequest">
                <div class="row">
                    <div class="col-md-6">
                        <label for="dealName">Deal Name</label>
                        <input type="text" class="form-control" id="dealName" v-model="formData.Deal_Name" placeholder="Deal Name">
                        <span v-if="errors.Deal_Name" class="error">{{ errors.Deal_Name[0] }}</span>
                    </div>
                    <div class="col-md-6">
                        <label for="stage">Stage</label>
                        <input type="text" class="form-control" v-model="formData.Stage" id="stage" placeholder="Stage">
                        <span v-if="errors.Stage" class="error">{{ errors.Stage[0] }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="stage">Stage</label>
                        <select class="form-control" v-model="formData.Account_Name.id">
                            <option value="">Select an account</option>
                            <option v-for="account in accounts" :value="account.id">{{ account.account_name }}</option>
                        </select>
                    </div>
                </div>
                <br>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger" @click="closeModal">Cancel</button>
            </form>
        </div>
    </div>
</template>

<script>
import '../../../../css/shared-styles.css'; // Імпортування стилів
import {commonFunctions} from "../../../components/mixins/common-functions.js"
import {EventBus} from "../../../event-bus";
export default {
    name: "App",
    mixins: [
        commonFunctions
    ],
    props: {
        accounts: {
            type: Object,
            required: false
        },
    },
    created() {
        EventBus.on('openAddDealModal', (data) => {
            this.isVisible = true;
        });
    },
    data() {
        return {
            formData: {
                Deal_Name: null,
                Stage: null,
                Account_Name: {
                    id: null
                }
            },
        };
    },
    methods: {
        sendRequest () {
            this.resetErrors();
            axios.post('/api/deal', this.formData).then(response => {
                if (response.data.error == null) {
                    this.formData = this.$options.data().formData;
                    this.closeModal();
                    EventBus.emit('dealWasStored');
                } else {
                    console.log(response)
                }
            }).catch(error => {
                // Обробка помилки
                if (error.response && error.response.status === 422 || error.response && error.response.status === 421) {
                    // Записуємо помилки в об'єкт errors
                    this.errors = error.response.data.errors;
                } else {
                    this.errorMessage = error;
                }
            });
        },
    }
};
</script>
