export const commonFunctions = {
    data() {
        return {
            isVisible: false,
            errorMessage: null,
            successMessage: null,
            errors: {}
        };
    },
    methods: {
        closeModal () {
            this.isVisible = false;
            this.resetErrors();
            this.formData = this.$options.data().formData
        },
        resetErrors () {
            this.errorMessage = null;
            this.errors = {}; // Очищуємо помилки перед запитом
        },
    },
};
