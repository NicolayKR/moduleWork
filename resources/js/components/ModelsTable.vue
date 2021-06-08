<template>
    <div class="container">
        <b-table striped hover :items="modelsData">
            
        </b-table>
        <canvas ref="myChart" width="800" height="300"></canvas>
    </div>
</template>

<script>
import Chart from 'chart.js';
    export default {
        data() {
            return {
                modelsData: [],

            }
        },
        mounted(){
            this.getModules();
            new Chart(this.$refs.myChart, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May'],
                    datasets: [
                    {
                        label: 'График скачиваний модуля',
                        data: [300, 700, 450, 750, 450]
                    }
                    ]
                }
            });
        },
        methods:{
            async getModules(){
               try{
                const response = await axios.get(`/can`)  
                    console.log(response);
                    this.modelsData = response.data;

                    }
                    catch{

                    }                            
            },
        }
    }
</script>
