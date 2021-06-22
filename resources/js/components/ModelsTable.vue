<template>
    <div class="wrapp">
        <div class="container">
            <div v-if="flagTable">
                <div class="d-grid d-md-flex justify-content-md-end">
                    <a class="btn btn-primary btn-lg btn-sm" href="/logout">Выйти</a>
                </div>
                <div class="select_date">
                    <select v-model="selectedDate">
                        <option disabled value="">Выберите один из вариантов</option>
                        <option>За неделю</option>
                        <option>За месяц</option>
                        <option>За год</option>
                        <option>За все время</option>
                    </select>
                </div>
                <div v-if="flagGraph" class="graph">
                    <div class = "graph_title">Статистика скачиваний <br>(7 дней)<br></div>
                    <div class = "graph_wrapper">
                        <graph :chartData ="datacollection" :selected="selected" :windowWidth="windowWidth" :selectedDate="selectedDate"/>
                    </div>
                </div>
                <div class="table d-none d-sm-block">
                    <table class="table_wrapp">
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
                <div class="table-xs d-block d-sm-none">
                    <ul>
                        <li v-for ="(models_item,index) in modelsData">
                            <div class="table-xs_item">
                                <span 
                                    class = "table-xs_colorline"
                                    :style="{'background-color': models_item.borderColor}"
                                    :class ="{ modules_colorline_inactive: !selected[Number(index)].checked }"
                                    @click="spanMovie(index)" 
                                    ></span>
                                <div class="table-xs_name">{{models_item.name}}</div>
                                <div class="table-xs_element_wrapper">
                                    <span class="bold_price">{{getPrice(models_item.price)}}</span>
                                    <span>Загрузок: <span class="bold_downloads">{{models_item.current_downloads}}</span></span>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>    
            </div>
            <div v-else>
                <div class="alert alert-success error__block" role="alert">
                    <span>Мы пытаемся соедениться с базой данных</span>
                    <div class="spinner-border text-success" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
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
            windowWidth: window.innerWidth,
            datacollection: {
                labels: [],
                datasets: []
            },
            selectedDate: 'За неделю',
            selected: [],
            flagTable: false,
            flagGraph: false,
        }
    },

    async mounted(){
        this.fillData();
        window.onresize = () => {
            this.windowWidth = window.innerWidth
        }
    },
    watch:{
        selectedDate(){
            this.fillData();
        }
    },
    methods:{
        async getModules(){
            try{
                const response = await axios.get(`/getModels?&date=${this.getSelect(this.selectedDate)}`);
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
            getPrice(a){
                if(a == 1){
                    return 'Платно';
                }
                else{
                    return 'Бесплатно';
                }
            },
            getSelect(a){
                switch (a) {
                    case 'За неделю':
                        return 1;
                    case 'За месяц':
                        return 2;
                    case 'За год':
                        return 3;
                     case 'За все время':
                        return 4;
                }       
            },
        getDateFromGraph(){
            this.datacollection.labels = [];
            this.datacollection.datasets = [];
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

<style scoped lang="scss">

</style>
