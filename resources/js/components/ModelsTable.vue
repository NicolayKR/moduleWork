<template>
    <div class="wrapp">
        <div v-if="flagTable">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col" style="width: 70%">Название модуля</th>
                        <th scope="col" style="width: 15%">Платно</th>
                        <th scope="col" style="width: 15%">Скачиваний</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for ="(models_item,index) in modelsData">
                        <td class = "modules">
                            <span 
                            class = "modules_colorline"
                            :style="{'background-color': models_item.borderColor}"
                            @click="spanMovie(index)" 
                            ></span>
                            <div class="modules_name">{{models_item.name}}</div>
                        </td>
                        <td>{{models_item.price}}</td>
                        <td>{{models_item.current_downloads}}</td>
                    </tr>
                </tbody>
            </table>
            <div v-if="flagGraph">
                <graph :chartData ="this.datacollection"/>
            </div>
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
            span_item:{
                 selected: undefined,
            },
            datacollection: {
                labels: [],
                datasets: []
            },
            datacollection_current: {
                labels: [],
                datasets: []
            },
            flagTable: false,
            flagGraph: false
        }
    },
    async mounted(){
        this.getModules()
    },
    methods:{
        async getModules(){
            try{
                const response = await axios.get(`/getModels`);
                this.modelsData = response.data;
                for(var key in this.modelsData) {
                    var current_dataset ={}
                    current_dataset.label = this.modelsData[key].name;
                    current_dataset.data = this.modelsData[key].downloads;
                    current_dataset.borderColor = this.modelsData[key].borderColor;
                    current_dataset.backgroundColor = this.modelsData[key].backgroundColor;
                    current_dataset.borderWidth = this.modelsData[key].borderWidth;
                    this.datacollection.labels = Array.from(new Set(this.datacollection.labels.concat(this.modelsData[key].dates)));
                    this.datacollection.datasets.push(current_dataset);
                }   
                this.flagTable = true;
                this.flagGraph = true;
                }
                catch{
                    this.flagTable = false;
                    this.flagGraph = false;
                }                            
            },
        spanMovie(index){
            console.log(index);
           
            event.target.classList.toggle('modules_colorline_inactive');
            }
        }
}
</script>

<style lang="scss" scoped>
.table th, .table td {
    border-top: none !important;
}
.table td{
    border-bottom-width: 0px;
}
.error__block{
    margin-top: 100px;
    text-align: center;
    font-weight: 600;
}
.text-success{
    margin-left: 20px;
}
.modules{
    display:flex;
    position: relative;
    &_color-wrapper{
        max-width: 50px;
        top: 50%;
        transform: translateY(0%);
    }
    &_name{
        margin-left: 50px;
        }
    &_colorline{
        display: block;
        position: absolute;
        height: 30px;
        width: 30px;
        padding-left: 20px;
        top: 50%;
        transform: translateY(-50%);
        &_inactive{
            background-color: aliceblue !important;
            border: 2px solid;
            border-color: black;
        }
    }
}

</style>