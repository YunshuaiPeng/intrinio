require('./bootstrap');

import {createApp} from "vue";
import SecurityHistoricalDatum from "./components/SecurityHistoricalDatum";

const app = createApp({
    components: {
        SecurityHistoricalDatum
    }
});

app.mount("#app");
