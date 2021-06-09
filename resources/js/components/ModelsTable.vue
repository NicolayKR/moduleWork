<template>
    <div class="container">
        <div v-if="flagTable">
            <lineChart 
            v-for="models_item in modelsData" :key="models_item.id"
            :models_item="models_item"></lineChart>
        </div>
    </div>
</template>

<script>
import lineChart from './LineChart';

export default {
    components: {lineChart},
    data() {
        return {
            modelsData:[],
            modelsDataHistory:[],
            graphData:[],
            flagTable: false
        }
    },
    mounted(){
        this.getModules();
        this.getModulesHistory();
    },
    methods:{
        async getModules(){
            try{
            const response = await axios.get(`/getModels`) 
                console.log(response); 
                this.modelsData = response.data;
                this.flagTable = true;
                }
                catch{
                    this.flagTable = false;
                }                            
        },
        async getModulesHistory(){
            try{
            const response = await axios.get(`/getModelsHistory`) 
                console.log(response); 
                this.modelsDataHistory = response.data;
                for (var key_obj in this.modelsDataHistory) {
                    let graphData ={};
                    graphData.name = this.modelsDataHistory[key_obj].name;
                    graphData.downloads = this.modelsDataHistory[key_obj].downloads;
                    graphData.dates = this.modelsDataHistory[key_obj].created_date;
                    this.graphData.push(graphData);
                    }
                console.log(this.graphData);
                }
                catch{
                }                            
        },

    }
}
</script>
