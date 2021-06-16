<template>
    <div class="wrapp">
        <div class="container">
            <div v-if="flagTable">
                <div v-if="flagGraph" class="graphWrapper">
                    <div class = "graph_title">Статистика скачиваний</div>
                    <div style="margin-top: 10px;">
                        <graph height="600" :chartData ="datacollection" :selected="selected" />
                    </div>
                </div>
                <div class="table_wrapp">
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
                                    :class ="{ modules_colorline_inactive: !selected[Number(index)].checked }"
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
        this.fillData();
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
            // event.target.classList.toggle('modules_colorline_inactive');
            for (var key in this.selected) {
                if(this.selected[key].name == this.current_datacollection.datasets[Number(index)].label){
                    this.selected[key].checked = !this.selected[key].checked;
                    this.setCurrentSelected();
                    }
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
                    if(!localStorage.selected){
                        checked_dataset.name = this.modelsData[key].name;
                        checked_dataset.checked = true;
                        checked_dataset.id = this.modelsData[key].id;
                        this.selected.push(checked_dataset);
                    }
                    this.datacollection.labels = Array.from(new Set(this.datacollection.labels.concat(this.modelsData[key].dates)));
                    this.datacollection.datasets.push(current_dataset);
                }
            this.current_datacollection = this.datacollection;
        },
        setCurrentSelected(){
            localStorage.setItem ("selected", JSON.stringify(this.selected));
        },
        setSelected(){
            if(localStorage.selected){
                this.selected = JSON.parse (localStorage.getItem("selected"));
            }
            else{
                this.setCurrentSelected();
            }
        },
        fillData(){
            (async () => {
                await this.getModules();
                await this.setSelected();
                })()
        }
        
    },
        
}
</script>

<style lang="scss" scoped>
.wrapp{
    min-height: 100vh;
    padding: 15px;
    background-color: #f2f2f3;
    }

.table {
    margin-top: 10px;
    margin-bottom: 0;
    background-color: white;
    &_wrapp{
        margin-top:10px;
        padding-left:34px;
        padding-right:34px;
        padding-top:10px;
        background-color: white;
        box-shadow: 0 2px 10px 0 #d9dee8;
    }
}
.table th {
    padding: 20px ;
    font-family: 'Roboto', sans-serif;
    font-size: 12px;
    font-weight: bold;
    line-height: normal;
    color: #333333;
    font-stretch: normal;
    font-style: normal;
    letter-spacing: normal;
    text-align: center;
    text-transform: uppercase;
    border-bottom: 2px solid #3f4b86 !important;
    border-top: none !important;
}
.table .tr{
    border-bottom-width: 1px !important;
}
tbody tr:hover {
    background: #eef4ff; 
   }
.table td{
    border-bottom-width: 1px !important;
    padding: 24px;
    font-family: 'Roboto', sans-serif;
    font-size: 14px;
    font-weight: normal;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: center;
    color: #1a1a1a;
}
.error__block{
    margin: 30% auto;
    text-align: center;
    width: 50%;
    font-weight: 600;
}
.text-success{
    margin-left: 20px;
}
.modules{
    position: relative;
    &_color-wrapper{
        max-width: 50px;
        top: 50%;
        transform: translateY(0%);
    }
    &_name{
        margin-left: 47px;
        text-align: start;
        }
    &_colorline{
        display: block;
        position: absolute;
        height: 24px;
        width: 24px;
        padding-left: 24px;
        top: 50%;
        transform: translateY(-50%);
        border-radius: 2px;
        border: solid 2px #3f4b86;
        &_inactive{
            background-color: aliceblue !important;
            border-radius: 2px;
            border: solid 2px #3f4b86;
        }
    }
}
.graphWrapper{
    padding: 10px 34px;
    min-height: 600px;
    background-color: white;
    box-shadow: 0 2px 10px 0 #d9dee8;
}
.graph_title{
    padding-top:15px;
    font-family: 'Roboto', sans-serif;
    width: 100%;
    text-align: center;
    font-size: 29px;
    font-weight: bold;
    font-stretch: normal;
    font-style: normal;
    line-height: normal;
    letter-spacing: normal;
    text-align: center;
    color: #36353a;
}
.container{
    max-width: 1540px;
}
</style>