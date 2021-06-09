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
            
            flagTable: false
        }
    },
    mounted(){
        this.getModules();
    },
    methods:{
        async getModules(){
            try{
            const response = await axios.get(`/getModels`) 
                //console.log(response); 
                this.modelsData = response.data;
                console.log(this.modelsData);
                }
                catch{
                }                            
        },

    }
}
</script>
