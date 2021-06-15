<template>
    <div class="wrapp">
        <div v-if="flagTable">
            <div v-if="flagGraph" class="graphWrapper">
                <div class = "graph_title">Статистика скачиваний</div>
                <div style="margin-top: 20px;">
                    <graph height="600" :chartData ="datacollection" :selected="selected" />
                </div>
            </div>
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
        graph,
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
            current_datacollection: {
                labels: [],
                datasets: []
            },
            selected: [],
            flagTable: false,
            flagGraph: false,
        }
    },
    
    async mounted(){
        this.getModules();   
    },
    methods:{
        async getModules(){
            try{
                const response = await axios.get(`/getModels`);
                this.modelsData = response.data;
                this.getDateFromGraph();  
                this.flagTable = true;
                this.flagGraph = true;
                }
                catch{
                    this.flagTable = false;
                    this.flagGraph = false;
                }                            
            },
        spanMovie(index){
            event.target.classList.toggle('modules_colorline_inactive');
            for (var key in this.selected) {
                if(this.selected[key].name == this.current_datacollection.datasets[Number(index)-1].label && this.selected[key].checked == true ){
                    this.selected[key].checked = false;
                }
                else(this.selected[key].checked = true);
                }
            },
        getDateFromGraph(){
            for(var key in this.modelsData) {
                    var current_dataset ={};
                    var checked_dataset ={};
                    current_dataset.label = this.modelsData[key].name;
                    current_dataset.data = this.modelsData[key].downloads;
                    current_dataset.borderColor = this.modelsData[key].borderColor;
                    //current_dataset.backgroundColor = this.modelsData[key].backgroundColor;
                    this.modelsData[key].backgroundColor.forEach(function(item) {
                        current_dataset.backgroundColor = item.replace(")",",0.4)");
                    });
                    current_dataset.borderWidth = this.modelsData[key].borderWidth;
                    current_dataset.hidden = false;
                    current_dataset.pointBackgroundColor = this.modelsData[key].pointBackgroundColor;
                    checked_dataset.name = this.modelsData[key].name;
                    checked_dataset.checked = true;
                    checked_dataset.id = this.modelsData[key].id;
                    this.selected.push(checked_dataset);
                    this.datacollection.labels = Array.from(new Set(this.datacollection.labels.concat(this.modelsData[key].dates)));
                    this.datacollection.datasets.push(current_dataset);
                }
            console.log(this.datacollection);
            this.current_datacollection = this.datacollection;
        }
        
    },
        
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
.graphWrapper{
    margin-top: 20px;
    min-height: 600px;
}
.graph_title{
    width: 100%;
    text-align: center;
    font-size: 2rem !important;
    color:black;
}
</style>