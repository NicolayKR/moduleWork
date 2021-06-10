<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: {
      dataSet:{
            default:()=>{}
        }, 
        label:{
            default:()=>[]
        }
  },
  data(){
      return {
        chartdata: {
            labels: this.label,
            datasets: this.dataSet,
        },
        options: {
                elements:{
                    line:{
                        tension:0,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        }
    },
    mounted () {
        this.renderChart(this.chartdata, this.options)
    }
}
</script>