var xmlhttp = new XMLHttpRequest();
var url = "/getGraphData";
xmlhttp.open("GET", url, true);
xmlhttp.send();
xmlhttp.onreadystatechange = function(){
    if(this.readyState== 4 && this.status == 200){
        var data = JSON.parse(this.responseText);
        var dataSet =[];
        var dates = [];
        for(var key in data) {
            dates = Array.from(new Set(dates.concat(data[key].dates)))
            var currentData ={}
            //Название Линии
            currentData.label = data[key].name;
            //Количество скачиваний
            currentData.data = data[key].downloads;
            //Рандомный цвет
            r = Math.floor(Math.random() * (256)),
            g = Math.floor(Math.random() * (256)),
            b = Math.floor(Math.random() * (256)),
            currentData.borderColor = '#' + r.toString(16) + g.toString(16) + b.toString(16);
            //
            currentData.backgroundColor = 'transparent'; 
            currentData.borderWidth = 2;
            dataSet.push(currentData);
        };
        
        plottingGraph(dates,dataSet);
    }
}

function plottingGraph(label, dataSets){
    var ctx = document.getElementById('canvas').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: label,
            // for()
            datasets: dataSets
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
    });
}
