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
        },
        windowWidth:{
            default: null
        },
        selectedDate:{
            default: null
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
            scales: {
                xAxes: [{
                    display: true,
                    ticks: { 
                        fontFamily: "'Roboto', sans-serif", 
                        fontColor: '#000'
                    }
                }],
                yAxes: [{
                    ticks: {                        
                        fontFamily: "'Roboto', sans-serif", 
                        fontColor: '#000'                           
                    }
                }]
            },
            tooltips :{
                display: true,
                bodyFontSize: 12
            },
            responseive : true ,
            maintainAspectRatio : false ,
            bezierCurve : false,
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
        this.updateGraphData();
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
        },
        updateGraphData(){
            if(this.windowWidth < 524){
                this.option.scales.xAxes[0].ticks.fontSize =  10;
                this.option.tooltips = false;
            };
            this.renderChart(this.currentData, this.option);
            this.updateChart();
        }
    }
}
</script>