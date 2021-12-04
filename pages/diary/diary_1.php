<!-- Chart code -->
<script id="script_diary_1" type='text/javascript'>
var menuID = 1;
am4core.ready(function() { 
  am4core.options.autoDispose = true;
//console.log(am4core.registry.baseSprites);
$('#form-diary')[0].reset();

var type = $('#missionTipo-form-diary').val();
var dateIni = $('#missionDateIni-form-diary').val();
var dateEnd = $('#missionDateEnd-form-diary').val();
var tag = $('#missionTag-form-diary').val();

if (type=='') {
  type = 'Relato';
}
if (dateIni=='') {
  dateIni = new Date();
  dateIni.setDate(dateIni.getDate() - 30);
}
  
if (dateEnd=='') {
  dateEnd = new Date();
}
// console.log('tipo: '+type);
// console.log('data inicial: '+dateIni);
// console.log('data final: '+dateEnd);
// console.log('tag: '+tag);

createChart(type, dateIni, dateEnd, tag);

$('#classroom-search-btn').click(function (e) { 
  e.preventDefault();
  if (menuID==1) {
  type = $('#missionTipo-form-diary').val();
  dateIni = $('#missionDateIni-form-diary').val();
  dateEnd = $('#missionDateEnd-form-diary').val();
  tag = $('#missionTag-form-diary').val();  
  if (dateIni=='') {
    dateIni = new Date();
    dateIni.setDate(dateIni.getDate());
  }
  if (dateEnd=='') {
    dateEnd = dateIni;
  }
  createChart(type, dateIni, dateEnd, tag);    
  }
});
  
function createChart(type, dateIni, dateEnd, tag){

  
  //const
  const date1 = new Date(dateIni);
  const date2 = new Date(dateEnd);
  const diffTime = Math.abs(date2 - date1);
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
  //console.log(diffTime + " milliseconds");
  //console.log(diffDays + " days");

  // Themes begin
  am4core.useTheme(am4themes_animated);
  // Themes end
  //console.log('XXXXXXXXXXXXXXXXXXXXXXXXXX');
  //console.log(am4core.registry.baseSprites);
  // Create chart instance
  chart = am4core.create("chartdiv_1", am4charts.RadarChart);
  chart.scrollbarX = new am4core.Scrollbar();

  var dataChart = [];

  function adicionaZero(numero){
    if (numero <= 9) 
        return "0" + numero;
    else
        return numero; 
  }

  var catDay = 1;
  for(var i = 1; i <= diffDays+1; i++){
    var newDate = new Date(dateIni);
    newDate.setDate(newDate.getDate() -1  + i);
    let dataFormatada = (newDate.getFullYear() + "-" + (adicionaZero(newDate.getMonth()+1).toString()) + "-" + adicionaZero(newDate.getDate().toString()));
    let dataFormatadaBrasil = (adicionaZero(newDate.getDate().toString()) + "-" + (adicionaZero(newDate.getMonth()+1).toString()) + "-" + newDate.getFullYear());
    //console.log('nova data: '+newDate);
    $.ajax({
      type: "POST",
      url: path+'ajax/get_registers_count.php',
      data: {'cargo': 'student', 'id': sessionStorage.getItem('id'), 'type': type, 'date': dataFormatada, 'tag': tag},
      dataType: "json",
      success: function (response) {
        //console.log(response);    
        dataChart.push({category: catDay, value:response.count, dataFormatada:dataFormatadaBrasil});
        if(catDay==diffDays+1){
        //console.log('FINISH FOR:'+catDay);  
        //console.log('AFTER FOR');

        //criar gráfico
        var data = dataChart;
        //console.log(dataChart);
        //console.log('****************');
        chart.data = dataChart;
        chart.radius = am4core.percent(100);
        chart.innerRadius = am4core.percent(50);

        // Create axes
        var categoryAxis = chart.xAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "category";
        categoryAxis.renderer.grid.template.location = 0;
        categoryAxis.renderer.minGridDistance = 30;
        categoryAxis.tooltip.disabled = true;
        categoryAxis.renderer.minHeight = 110;
        categoryAxis.renderer.grid.template.disabled = true;
        //categoryAxis.renderer.labels.template.disabled = true;
        let labelTemplate = categoryAxis.renderer.labels.template;
        labelTemplate.radius = am4core.percent(-60);
        labelTemplate.location = 0.5;
        labelTemplate.relativeRotation = 90;

        var valueAxis = chart.yAxes.push(new am4charts.ValueAxis());
        valueAxis.renderer.grid.template.disabled = true;
        valueAxis.renderer.labels.template.disabled = true;
        valueAxis.tooltip.disabled = true;

        // Create series
        var series = chart.series.push(new am4charts.RadarColumnSeries());
        series.sequencedInterpolation = true;
        series.dataFields.valueY = "value";
        series.dataFields.categoryX = "category";
        series.columns.template.strokeWidth = 0;
        series.tooltipText = "{valueY}"+" ("+"{dataFormatada}"+")";
        series.columns.template.radarColumn.cornerRadius = 10;
        series.columns.template.radarColumn.innerCornerRadius = 0;

        series.tooltip.pointerOrientation = "vertical";

        // on hover, make corner radiuses bigger
        let hoverState = series.columns.template.radarColumn.states.create("hover");
        hoverState.properties.cornerRadius = 0;
        hoverState.properties.fillOpacity = 1;


        series.columns.template.adapter.add("fill", function(fill, target) {
          return chart.colors.getIndex(target.dataItem.index);
        })

        // Cursor
        chart.cursor = new am4charts.RadarCursor();
        chart.cursor.innerRadius = am4core.percent(50);
        chart.cursor.lineY.disabled = true;
        }else{
        //console.log('From AJAX:'+catDay);
        catDay++; 
        }
               
      }
      }); 
      //console.log('Outside: '+i);
      //dataChart.push({category: i, value:Math.round(Math.random() * 100)});
  }
      
}
    
}); // end am4core.ready()

</script>

<!-- diary/diary_1.php -->
<div id="chartdiv_1"></div>
<!-- END/ diary/diary_1.php -->