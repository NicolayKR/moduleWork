<template>
    <div class="wrapp">
        <div v-if="flagTable">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th style="width: 70%">Название модуля</th>
                        <th style="width: 15%">Платно</th>
                        <th style="width: 15%">Скачиваний</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for ="models_item in modelsData">
                        <td>{{models_item.name}}</td>
                        <td>{{models_item.price}}</td>
                        <td>{{models_item.current_downloads}}</td>
                    </tr>
                </tbody>
            </table>
            
        </div>

        <div v-else>
            <b-alert show variant="success" class=error__block>
                Мы пытаемся соедениться с базой данных
                <div class="spinner-border text-success" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </b-alert>   
        </div>
    </div>
</template>

<script>
import { Line } from 'vue-chartjs'
import Graph from './Graph'

export default {
    component: {
        Graph
    }
    data() {
        return {
            modelsData:[],
            flagTable: false
        }
    },
    async mounted(){
        this.getModules();
        //this.getGraphData(); 
    },
    methods:{
        async getModules(){
            try{
                const response = await axios.get(`/getModels`) 
                //console.log(response); 
                this.modelsData = response.data;
                console.log(this.modelsData);

                var ctx = document.getElementById('canvas').getContext('2d');
                var myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: label,
                        // for()
                        datasets:  [{
                            label: '# of Votes',
                            data: [12, 19, 3, 5, 2, 3],
                            backgroundColor: [
                                'rgba(255, 99, 132, 0.2)',
                                'rgba(54, 162, 235, 0.2)',
                                'rgba(255, 206, 86, 0.2)',
                                'rgba(75, 192, 192, 0.2)',
                                'rgba(153, 102, 255, 0.2)',
                                'rgba(255, 159, 64, 0.2)'
                            ],
                            borderColor: [
                                'rgba(255, 99, 132, 1)',
                                'rgba(54, 162, 235, 1)',
                                'rgba(255, 206, 86, 1)',
                                'rgba(75, 192, 192, 1)',
                                'rgba(153, 102, 255, 1)',
                                'rgba(255, 159, 64, 1)'
                            ],
                            borderWidth: 1
                        }]
                    },
                    options: {
                        elements:{
                            line:{
                                tension:0,
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                this.flagTable = true;
                }
                catch{
                    setTimeout(this.flagTable = false,10000);
                }                            
        },
        async getGraphData(){
            try{
                const response = await axios.get(`/getGraphData`) 
                //console.log(response); 
                this.graphData = response.data;
                console.log(this.graphData);
                this.flagGraph = true;
            }
            catch{
                setTimeout(this.flagGraph = false,10000);
            } 
        }              
    }
}
</script>

<style lang="scss" scoped>
.error__block{
    margin-top: 100px;
    text-align: center;
    font-weight: 600;
}
.text-success{
    margin-left: 20px;
}
</style>