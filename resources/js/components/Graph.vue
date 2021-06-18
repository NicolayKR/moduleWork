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
<<<<<<< HEAD
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
            tooltip:{
                bodyFontSize: 12
            },
            responseive : true ,
            maintainAspectRatio : false ,
=======
                xAxes: [{ticks: {fontFamily: "'Roboto', sans-serif", fontColor: '#000'}}]
            },
            responseive : false ,
            maintainAspectRatio : false , 
>>>>>>> f47bde4d1a391595e2674c69b85b346f71dd8359
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
                this.option.scales.xAxes[0].ticks.fontSize =  8;
                this.option.tooltips = false;
            };
            this.renderChart(this.currentData, this.option);
            this.updateChart();
        }
    }
}
</script>