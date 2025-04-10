import './bootstrap.js';
import { createApp } from 'vue';
import { library } from '@fortawesome/fontawesome-svg-core';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { faEye } from '@fortawesome/free-solid-svg-icons';
import { faPencilAlt } from '@fortawesome/free-solid-svg-icons';
// Додавання іконок у бібліотеку
library.add(faEye);
library.add(faPencilAlt);

const app = createApp({});

import DealsIndexComponent from "./components/Shared/deals/DealsIndexComponent.vue";
import DealCreateModalComponent from "./components/Shared/deals/DealCreateModalComponent.vue";
import DealEditModalComponent from "./components/Shared/deals/DealEditModalComponent.vue";
import AccountCreateModalComponent from "./components/Shared/accounts/AccountCreateModalComponent.vue";
import AccountsIndexComponent from "./components/Shared/accounts/AccountsIndexComponent.vue";
import AccountsDealsIndexModalComponent from "./components/Shared/accounts/deals/DealsIndexModalComponent.vue";

app.component('deal-create-modal-component', DealCreateModalComponent);
app.component('deal-edit-modal-component', DealEditModalComponent);
app.component('deals-index-component', DealsIndexComponent);

app.component('account-create-modal-component', AccountCreateModalComponent);
app.component('accounts-index-component', AccountsIndexComponent);
app.component('accounts-deals-index-modal-component', AccountsDealsIndexModalComponent);

app.component('font-awesome-icon', FontAwesomeIcon);

app.mount('#app');
