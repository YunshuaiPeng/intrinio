<template>
    <div>
        <div class="w-3/4">
            <canvas id="chart" width="100%"></canvas>
        </div>
    </div>
</template>

<script>
import Chart from 'chart.js/auto';

export default {
    props: {
        security: {
            type: Object,
            required: true
        }
    },

    data() {
        return {
            data: [],
            tag: 'close_price',
            frequency: 'daily',
            startDate: '2017-06-01',
            endDate: '2017-07-01',
        }
    },

    computed: {
        labels() {
            return this.data.map(datum => datum.date)
        },

        closePrice() {
            return this.data.map(datum => datum.value)
        },
    },


    mounted() {
        this.fetchData().then(() => {
            this.initialChart()
        });
    },

    methods: {
        async fetchData() {
            try {
                let config = {
                    params: {
                        frequency: this.frequency,
                        startDate: this.startDate,
                        endDate: this.endDate,
                    }
                };

                let url = `securities/${this.security.id}/historical-data/${this.tag}`

                const {data} = await axios.get(url, config);

                this.data = data;

                return Promise.resolve()
            } catch (e) {
                console.log(e)
            }
        },

        initialChart() {
            let element = document.getElementById('chart');

            let chartInstance = new Chart(element, this.chartConfig());
        },

        chartConfig() {
            return {
                type: 'line',
                data: {
                    labels: this.labels,
                    datasets: [{
                        label: 'Close Price',
                        data: this.closePrice,
                        fill: false,
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1,
                    }]
                },
            };
        },
    }
}
</script>
