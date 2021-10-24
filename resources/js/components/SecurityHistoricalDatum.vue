<template>
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
        <!--filters-->
        <div class="col-span-5 lg:col-span-4">
            <canvas id="chart" width="100%"></canvas>
        </div>
        <!--filters end-->

        <!--chart-->
        <div class="col-span-5 lg:col-span-1">
            <div class="flex flex-col gap-4">
                <div>
                    <h2 class="text-gray-500 text-base font-medium uppercase tracking-wide">Frequency</h2>
                    <select class="px-4 py-3 rounded w-full"
                            v-model="state.frequency"
                            @change="handleFrequencyFilterChange">
                        <option v-for="(frequency,index) in frequencies"
                                :key="index"
                                :value="frequency">
                            {{ frequency }}
                        </option>
                    </select>
                </div>
                <div>
                    <h2 class="text-gray-500 text-base font-medium uppercase tracking-wide">Start date</h2>
                    <input class="px-4 py-3 rounded w-full" type="date" v-model="state.startDate" min="2017-06-01"
                           max="2018-06-01">
                </div>
                <div>
                    <h2 class="text-gray-500 text-base font-medium uppercase tracking-wide">End date</h2>
                    <input class="px-4 py-3 rounded w-full" type="date" v-model="state.endDate" min="2017-06-01"
                           max="2018-06-01">
                </div>
                <div>
                    <button type="button"
                            @click="handleApplyFilter"
                            class="inline-flex items-center justify-center px-6 py-3 w-full border border-transparent text-base font-medium rounded text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Apply Filter
                    </button>

                </div>
            </div>
        </div>
        <!--chart end-->
    </div>
</template>

<script setup>
import {reactive, defineProps, computed, onMounted} from 'vue'
import Chart from 'chart.js/auto';

const props = defineProps({
    security: {
        type: Object,
        required: true
    },
    frequencies: {
        type: Array,
        required: true
    },
});

const state = reactive({
    data: [],
    tag: 'close_price',
    frequency: 'daily',
    startDate: '2017-06-01',
    endDate: '2017-07-01',
});

const chartInstance = reactive(null);

const labels = computed(() => {
    return state.data.map(datum => datum.date)
});

const closePrice = computed(() => {
    return state.data.map(datum => datum.value)
});

const chartElement = computed(() => {
    return document.getElementById('chart')
});

const chartConfig = computed(() => {
    return {
        type: 'line',
        data: {
            labels: labels.value,
            datasets: [{
                label: 'Close Price',
                data: closePrice.value,
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
            }]
        },
    };
});

onMounted(() => {
    fetchData().then(() => {
        initialChart()
    })
})

const fetchData = async () => {
    try {
        const {data} = await axios.get(
            `securities/${props.security.id}/historical-data/${state.tag}`,
            {
                params: {
                    frequency: state.frequency,
                    tag: state.tag,
                    startDate: state.startDate,
                    endDate: state.endDate,
                }
            });

        state.data = data;

        return Promise.resolve(data)
    } catch (e) {
        console.log(e)
    }
};

const initialChart = () => {
    state.chartInstance = newChartInstance();
};

const newChartInstance = () => {
    return new Chart(chartElement.value, chartConfig.value);
};

const handleApplyFilter = () => {
    fetchData().then(() => {
        redrawChart()
    })
};

const redrawChart = () => {
    state.chartInstance.destroy()
    state.chartInstance = newChartInstance();
};
</script>
