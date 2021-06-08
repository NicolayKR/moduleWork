<template>
    <div class="container">
        <b-table striped hover :items="modelsData"></b-table>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                modelsData: []
            }
        },
        mounted(){
            this.getModules();
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
