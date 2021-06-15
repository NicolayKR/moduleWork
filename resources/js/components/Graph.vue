<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  props: {
        chartData:{
            default:()=>{}
        }, 
        selected: {
            type: Array,
            default: [],
        }
  },
  data(){
      return {
        currentData: this.chartData,
        selectedWatcher: null,
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
            responseive : false , 
            maintainAspectRatio : false , 
            animation : { 
                duration : 500
            } , 
            hover : { 
                animationDuration : 500 
                }, 
            responseiveAnimationDuration : 500 
            }
        }
    },
    mounted () {
        this.renderChart(this.currentData, this.option);
        this.selectedWatcher = this.$watch('selected', this.updateChart, {
            deep: true
        });
    },
    methods:{
        updateChart(newVal) {
            const selected = this.$props.selected
                .map((item) => item.checked && item.name);
            this.currentData = {
                ...this.$props.chartData,
                datasets: this.$props.chartData.datasets
                .forEach((item) => {
                    item.hidden = !selected.includes(item.label)
                })
            }
            this.$data._chart.update()
        }
    }
}
</script>

<style>

</style>