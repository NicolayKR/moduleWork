<template>
    <div class="container">
        
    </div>
</template>

<script>
    export default {
        data() {
            return {
                name: ''
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
                    this.cityWeathers = response.data;
                    }
                    catch{
                    }                            
            },
        }
    }
</script>
