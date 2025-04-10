<script>
import {EventBus} from "../../../event-bus";
import '../../../../css/shared-styles.css'; // Імпортування стилів
import {commonFunctions} from "../../../components/mixins/common-functions.js"
export default {
    name: "AccountCreate",
    mixins: [
        commonFunctions
    ],
    data() {
        return {
            formData: {
                Account_Name: null,
                Website: null,
                Phone: null,
            },
        };
    },
    created() {
        EventBus.on('openAddAccountModal', (data) => {
            this.isVisible = true;
        });
    },
    methods: {
        sendRequest () {
            this.resetErrors();
            axios.post('/api/account', this.formData).then(response => {
                if (response.data.error == null) {
                    this.formData = this.$options.data().formData;
                    this.closeModal();
                    EventBus.emit('accountWasStored');
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
}
</script>

<template>
    <div v-if="isVisible" class="modal-backdrop">
        <div class="modal-window">
            <button @click="closeModal" class="close-button">X</button>
            <h3>Create account form</h3>
            <div v-if="errorMessage" class="alert alert-danger">{{errorMessage}}</div>
            <form @submit.prevent="sendRequest">
                <div class="row">
                    <div class="col-md-6">
                        <label for="name">Account Name</label>
                        <input type="text" class="form-control" id="name" v-model="formData.Account_Name" placeholder="Account Name">
                        <span v-if="errors.Account_Name" class="error">{{ errors.Account_Name[0] }}</span>
                    </div>
                    <div class="col-md-6">
                        <label for="website">Website</label>
                        <input type="url" class="form-control" v-model="formData.Website" id="website" placeholder="Website">
                        <span v-if="errors.Website" class="error">{{ errors.Website[0] }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <label for="phone">Phone</label>
                        <input name="phone" v-model="formData.Phone" required type="tel" placeholder="+380"
                               class="form-control">
                        <span v-if="errors.Phone" class="error">{{ errors.Phone[0] }}</span>
                    </div>
                </div><br>
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger" @click="closeModal">Cancel</button>
            </form>
        </div>
    </div>
</template>

<style scoped>

</style>
