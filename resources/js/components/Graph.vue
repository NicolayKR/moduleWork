<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: {
        chartData:{
            default:()=>{}
        }, 
  },
  data(){
      return {
         option: { 
            legend: {
                display: false,
            },
            elements:{
                line:{
                    tension:0,
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            responseive : true , 
            keepAspectRatio : false , 
            animation : { 
                duration : 0 
            } , 
            hover : { 
                animationDuration : 0 
                }, 
            responseiveAnimationDuration : 0 
            }
        }
    },
    watch: {
        chartData () {
            this.$data._chart.update()
        }
    },
    mounted () {
        this.renderChart(this.chartData, this.option);
    },
    methods:{
    }
}
</script>