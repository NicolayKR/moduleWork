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
            
            <graph :dataSet="graphData" :label ="graphLabel"/>

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
import graph from './Graph'


export default {
    components: {
        graph
    },
    data() {
        return {
            modelsData:[],
            graphData: [],
            graphLabel: [],
            flagTable: false
        }
    },
    async mounted(){
        this.getModules();
        this.getGraphData(); 
        this.getGraphLabel(); 
    },
    methods:{
        async getModules(){
            try{
                const response = await axios.get(`/getModels`) 
                //console.log(response); 
                this.modelsData = response.data;
                console.log(this.modelsData);
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
        } ,
        async getGraphLabel(){
            try{
                const response = await axios.get(`/getGraphLabel`) 
                //console.log(response); 
                this.graphLabel = response.data;
                console.log(this.graphLabel);
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