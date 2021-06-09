<template>
  <div class="table_wrapper">
    <table class="table">
        <thead>
            <tr>
                <th scope="col-6">Название модуля</th>
                <th scope="col-3">Платно</th>
                <th scope="col-3">Скачиваний</th>
            </tr>
        </thead>
        <tbody>
          <tr>
              <td> {{models_item.name}} </td>
              <td> {{models_item.price}} </td>
              <td> {{models_item.downloads}} </td>
          </tr>
        </tbody>
    </table>
    <div class="modules_item_wrapp">
      <canvas ref="canvas" width="500" height="300"></canvas>
    </div>
     
  </div>

</template>

<script>
import { Line } from 'vue-chartjs'

export default {
    extends: Line,
    props:{
      models_item: {
          default:()=>{}
      },
    },
    data(){
      return{
          // name_current_modules: this.models_item.name,
      }
    },
    async mounted() {
      //this.getModelsHistory();
      this.renderChart({
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: 'Статистика скачиваний',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    })
    },
    methods:{
        // async getModelsHistory(){
        //         const response = await axios.get(`/getModelsHistory/?name=${this.models_item.name}`)             
        //         .then(function (response) {
        //         // handle success
        //         console.log(response);
        //       })
        //       .catch(function (error) {
        //         // handle error
        //         console.log(error);
        //       })                         
        // },
        getDate(a){
            const dateFormat = require('dateformat');
            const res = dateFormat(new Date(a), "dd.mm.yy")
            return res;
        }
      }
    }  
</script>

<style lang="scss" scoped>
.table_wrapper{
  margin-top: 20px;
}
.table{
  width: 100%;
}
.modules_item_wrapp{
  width: 600px;
}

</style>