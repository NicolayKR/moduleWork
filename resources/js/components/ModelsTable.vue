<template>
    <div class="container">
        <div v-if="flagTable">
            <lineChart 
            :v-for="models_item in modelsData" :key="models_item.id"
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
            graphData:[],
            flagTable: false
        }
    },
    mounted(){
        this.getModulesHistory();
    },
    methods:{
        async getModulesHistory(){
            try{
            const response = await axios.get(`/getModels`) 
                //console.log(response); 
                this.graphData = response.data;
                console.log(this.graphData);
                }
                catch{
                }                            
        },

    }
}
</script>
