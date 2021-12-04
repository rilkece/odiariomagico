<!-- Chart code -->
<script id="script_diary_2" type='text/javascript'>
var menuID = 2;
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
  dateIni.setDate(dateIni.getDate());
}
  
if (dateEnd=='') {
  dateEnd = new Date(dateIni);
  dateEnd.setDate(dateIni.getDate()+1);
}

// console.log('tipo: '+type);
// console.log('data inicial: '+dateIni);
// console.log('data final: '+dateEnd);
// console.log('tag: '+tag);

createChart(type, dateIni, dateEnd, tag);

$('#classroom-search-btn').click(function (e) { 
  e.preventDefault();
  if (menuID==2) {
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
  //console.log('*******************************');
  //console.log('tipo: '+type);
  //console.log('data inicial: '+dateIni);
  //console.log('data final: '+dateEnd);
  //console.log('tag: '+tag);
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

  var colorSet = new am4core.ColorSet();
  
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
    //console.log('nova data: '+newDate);
    $.ajax({
    type: 'POST',
    url: path+'ajax/get_registers.php',
    data: {'cargo': 'student', 'id': sessionStorage.getItem('id'), 'type': type, 'date': dataFormatada, 'tag': tag, 'interval': 'si'},
    dataType: "json",
    success: function (response) {
      var linhas = response.linhas;
      //console.log(linhas);
      if (linhas.length>0) {
        //console.log("Essa conta");
        for (let i = 0; i < linhas.length; i++) {
          const element = linhas[i];
          //console.log(element);
          var line = {
          "category": "",
          "start": element['date_ini'],
          "end": element['date_end'],
          "color": colorSet.getIndex(Math.floor((Math.random() * 15) + 1)),
          "text": element['name'],
          "textDisabled": false,
          "icon": element['image']
           };
           dataChart.push(line);          
          
        }
        
      }
      if (catDay==diffDays+1) {
        //console.log("Terminou em "+catDay+" resultados");
        //console.log(dataChart);
       
         // Themes begin
          am4core.useTheme(am4themes_animated);
          // Themes end
         // console.log('###########################');
          //console.log(am4core.registry.baseSprites);
        var chart = am4core.create("chartdiv_2", am4plugins_timeline.SerpentineChart);
        chart.curveContainer.padding(100, 20, 50, 20);
        chart.levelCount = 3;
        chart.yAxisRadius = am4core.percent(20);
        chart.yAxisInnerRadius = am4core.percent(2);
        chart.maskBullets = false;

        

        chart.dateFormatter.inputDateFormat = "yyyy-MM-dd HH:mm:ss";
        chart.dateFormatter.dateFormat = "HH";

        //criar gráfico
        var data = dataChart;
        chart.data = data;  

        //criar gráfico
        chart.fontSize = 10;
        chart.tooltipContainer.fontSize = 10;

        var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
        categoryAxis.dataFields.category = "category";
        categoryAxis.renderer.grid.template.disabled = true;
        categoryAxis.renderer.labels.template.paddingRight = 25;
        categoryAxis.renderer.minGridDistance = 10;

        var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
        dateAxis.renderer.minGridDistance = 70;
        dateAxis.baseInterval = { count: 30, timeUnit: "minute" };
        dateAxis.renderer.tooltipLocation = 0;
        dateAxis.renderer.line.strokeDasharray = "1,4";
        dateAxis.renderer.line.strokeOpacity = 0.5;
        dateAxis.tooltip.background.fillOpacity = 0.2;
        dateAxis.tooltip.background.cornerRadius = 5;
        dateAxis.tooltip.label.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");
        dateAxis.tooltip.label.paddingTop = 7;
        dateAxis.endLocation = 0;
        dateAxis.startLocation = -0.5;

        var labelTemplate = dateAxis.renderer.labels.template;
        labelTemplate.verticalCenter = "middle";
        labelTemplate.fillOpacity = 0.4;
        labelTemplate.background.fill = new am4core.InterfaceColorSet().getFor("background");
        labelTemplate.background.fillOpacity = 1;
        labelTemplate.padding(7, 7, 7, 7);

        var series = chart.series.push(new am4plugins_timeline.CurveColumnSeries());
        series.columns.template.height = am4core.percent(15);

        series.dataFields.openDateX = "start";
        series.dataFields.dateX = "end";
        series.dataFields.categoryY = "category";
        series.baseAxis = categoryAxis;
        series.columns.template.propertyFields.fill = "color"; // get color from data
        series.columns.template.propertyFields.stroke = "color";
        series.columns.template.strokeOpacity = 0;
        series.columns.template.fillOpacity = 0.6;

        var imageBullet1 = series.bullets.push(new am4plugins_bullets.PinBullet());
        imageBullet1.locationX = 1;
        imageBullet1.propertyFields.stroke = "color";
        imageBullet1.background.propertyFields.fill = "color";
        imageBullet1.image = new am4core.Image();
        imageBullet1.image.propertyFields.href = "icon";
        imageBullet1.image.scale = 0.5;
        imageBullet1.circle.radius = am4core.percent(100);
        imageBullet1.dy = -5;


        var textBullet = series.bullets.push(new am4charts.LabelBullet());
        textBullet.label.propertyFields.text = "text";
        textBullet.disabled = true;
        textBullet.propertyFields.disabled = "textDisabled";
        textBullet.label.strokeOpacity = 0;
        textBullet.locationX = 1;
        textBullet.dy = - 100;
        textBullet.label.textAlign = "middle";

        chart.scrollbarX = new am4core.Scrollbar();
        chart.scrollbarX.align = "center"
        chart.scrollbarX.width = am4core.percent(75);
        chart.scrollbarX.opacity = 0.5;

        var cursor = new am4plugins_timeline.CurveCursor();
        chart.cursor = cursor;
        cursor.xAxis = dateAxis;
        cursor.yAxis = categoryAxis;
        cursor.lineY.disabled = true;
        cursor.lineX.strokeDasharray = "1,4";
        cursor.lineX.strokeOpacity = 1;

        dateAxis.renderer.tooltipLocation2 = 0;
        categoryAxis.cursorTooltipEnabled = false;


        var label = chart.createChild(am4core.Label);
        label.text = tag;
        label.isMeasured = false;
        label.y = am4core.percent(40);
        label.x = am4core.percent(50);
        label.horizontalCenter = "middle";
        label.fontSize = 20;
        
      }else{
        //console.log('From AJAX:'+catDay);
        catDay++;
      }
        
    }
});

  }

}
}); // end am4core.ready()
</script>

<!-- diary/diary_2.php -->
<div id="chartdiv_2"></div>
<!-- END/ diary/diary_2.php -->