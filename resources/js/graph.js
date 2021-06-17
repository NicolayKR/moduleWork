import graph from './Graph';

export default {
    components: {
        graph,
    },
    data() {
        return {
            modelsData:[],
            span_item:{
                 selected: undefined,
            },
            datacollection: {
                labels: [],
                datasets: []
            },
            current_datacollection: {
                labels: [],
                datasets: []
            },
            selected: [],
            flagTable: false,
            flagGraph: false,
        }
    },
    
    async mounted(){
        this.fillData();
    },
    methods:{
        async getModules(){
            try{
                const response = await axios.get(`/getModels`);
                this.modelsData = response.data;
                this.getDateFromGraph();  
                this.flagTable = true;
                this.flagGraph = true;
                }
                catch{
                    this.flagTable = false;
                    this.flagGraph = false;
                }                            
            },
        spanMovie(index){
            // event.target.classList.toggle('modules_colorline_inactive');
            for (var key in this.selected) {
                if(this.selected[key].name == this.current_datacollection.datasets[Number(index)].label){
                    this.selected[key].checked = !this.selected[key].checked;
                    this.setCurrentSelected();
                    }
                }
            },
        getDateFromGraph(){
            for(var key in this.modelsData) {
                    var current_dataset ={};
                    var checked_dataset ={};
                    current_dataset.label = this.modelsData[key].name;
                    current_dataset.data = this.modelsData[key].downloads;
                    current_dataset.borderColor = this.modelsData[key].borderColor;
                    //current_dataset.backgroundColor = this.modelsData[key].backgroundColor;
                    this.modelsData[key].backgroundColor.forEach(function(item) {
                        current_dataset.backgroundColor = item.replace(")",",0.4)");
                    });
                    current_dataset.borderWidth = this.modelsData[key].borderWidth;
                    current_dataset.hidden = false;
                    current_dataset.pointBackgroundColor = this.modelsData[key].pointBackgroundColor;
                    if(!localStorage.selected){
                        checked_dataset.name = this.modelsData[key].name;
                        checked_dataset.checked = true;
                        checked_dataset.id = this.modelsData[key].id;
                        this.selected.push(checked_dataset);
                    }
                    this.datacollection.labels = Array.from(new Set(this.datacollection.labels.concat(this.modelsData[key].dates)));
                    this.datacollection.datasets.push(current_dataset);
                }
            this.current_datacollection = this.datacollection;
        },
        setCurrentSelected(){
            localStorage.setItem ("selected", JSON.stringify(this.selected));
        },
        setSelected(){
            if(localStorage.selected){
                this.selected = JSON.parse (localStorage.getItem("selected"));
            }
            else{
                this.setCurrentSelected();
            }
        },
        fillData(){
            (async () => {
                await this.getModules();
                await this.setSelected();
                })()
        }
        
    },      
};
