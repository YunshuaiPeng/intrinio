<template>
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

        <!--filters-->
        <div class="col-span-4 lg:col-span-1">
            <div class="flex flex-col gap-4 bg-white rounded-lg p-4 pr-6">
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
        <!--filters end-->

        <!--chart-->
        <div class="col-span-4 lg:col-span-3">
            <div class="bg-white rounded-lg p-4 pr-6">
                <canvas id="chart" width="100%"></canvas>
            </div>
            <div class="bg-white rounded-lg p-4 pr-6 mt-2">

                <button type="button"
                        @click="calculateMaximumProfit"
                        class="inline-flex items-center px-2.5 py-1.5 mb-2 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Calculate maximum profit
                </button>
                <div class="px-4 py-5 sm:p-0" v-if="maximumProfitState.calculated">
                    <dl class="sm:divide-y sm:divide-gray-200">
                        <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                出售日期
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ maximumProfitState.sellDate }}
                            </dd>
                        </div>
                        <div class="py-2 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">
                                利润
                            </dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ maximumProfitState.profit }}
                            </dd>
                        </div>
                    </dl>
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
    chartInstance: null,
    chartPointBackgroundColor: []
});

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
    let config = {
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

    if (state.chartPointBackgroundColor.length) {
        config.data.datasets[0].pointBackgroundColor = state.chartPointBackgroundColor;
    }

    return config;
});

onMounted(() => {
    fetchData().then(() => {
        initialChart();
    });
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

        return Promise.resolve(data);
    } catch (e) {
        alertError(e.response.data.errors)
        console.log(e.response);
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
        clearMaximumProfitState()
        redrawChart();
    });
};

const redrawChart = () => {
    state.chartInstance.destroy();
    state.chartInstance = newChartInstance();
};

const clearMaximumProfitState = () => {
    maximumProfitState.calculated = false;
    maximumProfitState.sellDate = '';
    maximumProfitState.profit = 0;
    state.chartPointBackgroundColor = [];
};

const alertError = (errors) => {
    let errorString = Object.entries(errors).map(([key, value]) => {
        return value.join('\n');
    }).join('\n');

    alert(errorString);
};

const maximumProfitState = reactive({
    calculated: false,
    sellDate: '',
    profit: 0,
});

const calculateMaximumProfit = () => {
    if (closePrice.value.length < 2) {
        return alert('数据太少，无法计算');
    }

    // 1. 通过算法计算出必要的数据
    let [sellIndex, profit] = maxProfitAlgorithm(closePrice.value);

    if (!sellIndex) {
        return alert('怎么卖都亏~');
    }

    // 2. 更新 maximumProfitState variable
    updateMaximumProfitState(sellIndex, profit);

    // 3. 填充 chartPointBackgroundColor 数组，高亮买入点和卖出点
    fillChartPointBackgroundColor(sellIndex);

    // 4. redraw
    redrawChart();
};

const maxProfitAlgorithm = (data) => {
    let minValue = data[0];
    let maxProfitIndex = null;

    let profit = 0;

    for (const index in data) {
        // 如果当前值比缓存的最小值还要小，则更新缓存
        if (data[index] < minValue) {
            minValue = data[index];
        }

        // 如果当前值与最小值的差值大于了缓存中的 profit，则更新缓存
        if (data[index] - minValue > profit) {
            profit = data[index] - minValue;

            // 记录 profit 最大时的 index
            maxProfitIndex = index;
        }
    }

    return [maxProfitIndex, profit];
};

const updateMaximumProfitState = (sellIndex, profit) => {
    maximumProfitState.calculated = true;
    maximumProfitState.sellDate = state.data[sellIndex].date;
    maximumProfitState.profit = Math.round(profit * 100) / 100;
}

const fillChartPointBackgroundColor = (sellIndex) => {
    for (let i = 0; i < state.chartInstance.data.datasets[0].data.length; i++) {
        if (i == sellIndex) {
            state.chartPointBackgroundColor[i] = 'red';
        } else {
            state.chartPointBackgroundColor[i] = 'rgba(0, 0, 0, 0.1)';
        }
    }
}
</script>
