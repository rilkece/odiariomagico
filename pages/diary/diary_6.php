<!-- Chart code -->
<script id="script_diary_6" type='text/javascript'>
var menuID = 6;
am4core.ready(function() {
  am4core.options.autoDispose = true;
    //console.log(am4core.registry.baseSprites);

    $('#form-diary')[0].reset();

    var type = $('#missionTipo-form-diary').val();
    var dateIni = $('#missionDateIni-form-diary').val();
    var dateEnd = $('#missionDateEnd-form-diary').val();
    var tag = $('#missionTag-form-diary').val();
    var tag2 = $('#missionTag-form-diary-2').val();
    var tag3 = $('#missionTag-form-diary-3').val();
    var tag4 = $('#missionTag-form-diary-4').val();
    var tag5 = $('#missionTag-form-diary-5').val();

    if (type=='') {
      type = 'Relato';
    }
    if (dateIni=='') {
      dateIni = new Date();
      dateIni.setDate(dateIni.getDate());
    }
      
    if (dateEnd=='') {
      dateEnd = new Date(dateIni);
      dateEnd.setDate(dateIni.getDate());
    }

    // console.log('tipo: '+type);
    // console.log('data inicial: '+dateIni);
    // console.log('data final: '+dateEnd);
    // console.log('tag: '+tag);
    // console.log('tag2: '+tag2);
    // console.log('tag3: '+tag3);
    // console.log('tag4: '+tag4);
    // console.log('tag5: '+tag5);

    createChart(type, dateIni, dateEnd, tag, tag2, tag3, tag4, tag5);
    
    $('#classroom-search-btn').click(function (e) { 
      e.preventDefault();
      if (menuID==6) {
        type = $('#missionTipo-form-diary').val();
        dateIni = $('#missionDateIni-form-diary').val();
        dateEnd = $('#missionDateEnd-form-diary').val();
        tag = $('#missionTag-form-diary').val();  
        tag2 = $('#missionTag-form-diary-2').val();
        tag3 = $('#missionTag-form-diary-3').val();
        tag4 = $('#missionTag-form-diary-4').val();
        tag5 = $('#missionTag-form-diary-5').val();
        if (dateIni=='') {
          dateIni = new Date();
          dateIni.setDate(dateIni.getDate());
        }
        if (dateEnd=='') {
          dateEnd = dateIni;
        }
          console.log('tipo: '+type);
          console.log('data inicial: '+dateIni);
          console.log('data final: '+dateEnd);
          console.log('tag: '+tag);
          console.log('tag2: '+tag2);
          console.log('tag3: '+tag3);
          console.log('tag4: '+tag4);
          console.log('tag5: '+tag5);
        createChart(type, dateIni, dateEnd, tag, tag2, tag3, tag4, tag5);  
      }
    });

    function createChart(type, dateIni, dateEnd, tag, tag2, tag3, tag4, tag5){

      
      //const
      const date1 = new Date(dateIni);
      const date2 = new Date(dateEnd);
      const diffTime = Math.abs(date2 - date1);
      var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
      //console.log(diffTime + " milliseconds");
      //console.log(diffDays + " days"); 

      function adicionaZero(numero){
        if (numero <= 9) 
            return "0" + numero;
        else
            return numero; 
      }

      let dataFormatada1 = (date1.getFullYear() + "-" + (adicionaZero(date1.getMonth()+1).toString()) + "-" + adicionaZero(date1.getDate().toString()));
      let dataFormatada2 = (date2.getFullYear() + "-" + (adicionaZero(date2.getMonth()+1).toString()) + "-" + adicionaZero(date2.getDate().toString()));

      if (dataFormatada1==dataFormatada2) {
        diffDays=0;        
      } 
      var colorSet = new am4core.ColorSet();
      
      var dataChart = [];

    function adicionaZero(numero){
        if (numero <= 9) 
            return "0" + numero;
        else
            return numero; 
      }

      var catDay = 1;
        // Themes begin
        am4core.useTheme(am4themes_animated);
            // Themes end
            var dataChart = [];  
            var colorSet = new am4core.ColorSet();
      for(var i = 1; i <= diffDays+1; i++){
        //const
        var newDate = new Date(dateIni);
        newDate.setDate(newDate.getDate() -1  + i);
        let dataFormatada = (newDate.getFullYear() + "-" + (adicionaZero(newDate.getMonth()+1).toString()) + "-" + adicionaZero(newDate.getDate().toString()));
      
        $.ajax({
          type: "POST",
          url: path+'ajax/get_registers_tags.php',
          data: {'cargo': 'student', 'id': sessionStorage.getItem('id'), 'type': type, 'date': dataFormatada, 'tag': tag, 'tag2': tag2, 'tag3': tag3, 'tag4': tag4, 'tag5': tag5, 'interval': 'si'},
          dataType: "json",
          success: function (response) {
            // console.log('dia: '+dataFormatada);          
            // console.log(response);           
      
            if (response.tag!='no') {
              //  console.log('##################');
              //  console.log('COMEÇO DA TAG');
              for (const key in response.tag) {
                if (Object.hasOwnProperty.call(response.tag, key)) {
                  const element = response.tag[key];
                  //  console.log('********************');
                  //  console.log('key: '+key);
                  //  console.log(element);
                  //  console.log('start: '+element['date_ini']);
                  //  console.log('end: '+element['date_end']);
                  //  console.log('task: '+tag);  
                  
                  var line = {
                    "category": tag,
                    "start": element['date_ini'],
                    "end": element['date_end'],
                    "color": colorSet.getIndex(1),
                    "task": element['name']
                  };
                  dataChart.push(line);  
                  
                }
              }
              //  console.log('FIM DA TAG');
            }else{              
              // console.log('##################');
              // console.log('TAG SEM RESULTADOS');
            }
            if (response.tag2!='no') {
              for (const key in response.tag2) {
                if (Object.hasOwnProperty.call(response.tag2, key)) {
                  const element = response.tag2[key];
                  
                  var line = {
                    "category": tag2,
                    "start": element['date_ini'],
                    "end": element['date_end'],
                    "color": colorSet.getIndex(2),
                    "task": element['name']
                  };
                  dataChart.push(line);  
                  
                }
              }
            }else{              
            }
            if (response.tag3!='no') {
              for (const key in response.tag3) {
                if (Object.hasOwnProperty.call(response.tag3, key)) {
                  const element = response.tag3[key];
                  
                  var line = {
                    "category": tag3,
                    "start": element['date_ini'],
                    "end": element['date_end'],
                    "color": colorSet.getIndex(3),
                    "task": element['name']
                  };
                  dataChart.push(line);  
                  
                }
              }
            }else{              
            }
            if (response.tag4!='no') {
              for (const key in response.tag4) {
                if (Object.hasOwnProperty.call(response.tag4, key)) {
                  const element = response.tag4[key];
                  var line = {
                    "category": tag4,
                    "start": element['date_ini'],
                    "end": element['date_end'],
                    "color": colorSet.getIndex(4),
                    "task": element['name']
                  };
                  dataChart.push(line);  
                  
                }
              }
            }else{              
            }
            if (response.tag5!='no') {
              for (const key in response.tag5) {
                if (Object.hasOwnProperty.call(response.tag5, key)) {
                  const element = response.tag5[key];
                  var line = {
                    "category": tag5,
                    "start": element['date_ini'],
                    "end": element['date_end'],
                    "color": colorSet.getIndex(5),
                    "task": element['name']
                  };
                  dataChart.push(line);  
                  
                }
              }
            }else{              
            }
            if (catDay==diffDays+1) {
              //console.log('TERMINOU');
            var chart = am4core.create("chartdiv_6", am4plugins_timeline.SpiralChart);
            //chart.curveContainer.padding(20,20,20,20);
            chart.levelCount = 2;
            chart.yAxisRadius = am4core.percent(25);
            chart.yAxisInnerRadius = am4core.percent(-25);
            chart.startAngle = -90;

            
            //console.log(dataChart);
            chart.data = dataChart;
            

            chart.dateFormatter.dateFormat = "yyyy-MM-dd hh:mm:ss";
            chart.dateFormatter.inputDateFormat = "yyyy-MM-dd hh:mm:ss";
            chart.fontSize = 11;

            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "category";
            categoryAxis.renderer.grid.template.disabled = true;
            categoryAxis.renderer.labels.template.paddingRight = 25;
            categoryAxis.renderer.minGridDistance = 10;
            categoryAxis.renderer.innerRadius = -60;
            categoryAxis.renderer.radius = 60;
            categoryAxis.renderer.labels.template.disabled = true;

            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.minGridDistance = 70;
            dateAxis.baseInterval = { count: 1, timeUnit: "hour" };
            dateAxis.renderer.tooltipLocation = 0;
            dateAxis.startLocation = -0.5;
            dateAxis.renderer.line.strokeDasharray = "1,4";
            dateAxis.renderer.line.strokeOpacity = 0.7;
            dateAxis.tooltip.background.fillOpacity = 0.2;
            dateAxis.tooltip.background.cornerRadius = 5;
            dateAxis.tooltip.label.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");
            dateAxis.tooltip.label.paddingTop = 7;

            var labelTemplate = dateAxis.renderer.labels.template;
            labelTemplate.verticalCenter = "middle";
            labelTemplate.fillOpacity = 0.7;
            labelTemplate.background.fill = new am4core.InterfaceColorSet().getFor("background");
            labelTemplate.background.fillOpacity = 1;
            labelTemplate.padding(7,7,7,7);

            var series1 = chart.series.push(new am4plugins_timeline.CurveColumnSeries());
            series1.columns.template.height = am4core.percent(20);
            series1.columns.template.tooltipText = "{task}: [bold]{openDateX}[/] - [bold]{dateX}[/]";

            series1.dataFields.openDateX = "start";
            series1.dataFields.dateX = "end";
            series1.dataFields.categoryY = "category";
            series1.columns.template.propertyFields.fill = "color"; // get color from data
            series1.columns.template.propertyFields.stroke = "color";
            series1.columns.template.strokeOpacity = 0;

            var bullet = new am4charts.CircleBullet();
            series1.bullets.push(bullet);
            bullet.circle.radius = 3;
            bullet.circle.strokeOpacity = 0;
            bullet.propertyFields.fill = "color";
            bullet.locationX = 0;


            var bullet2 = new am4charts.CircleBullet();
            series1.bullets.push(bullet2);
            bullet2.circle.radius = 3;
            bullet2.circle.strokeOpacity = 0;
            bullet2.propertyFields.fill = "color";
            bullet2.locationX = 1;

            chart.scrollbarX = new am4core.Scrollbar();
            chart.scrollbarX.align = "center"
            chart.scrollbarX.width = am4core.percent(70);

            var cursor = new am4plugins_timeline.CurveCursor();
            chart.cursor = cursor;
            cursor.xAxis = dateAxis;
            cursor.yAxis = categoryAxis;
            cursor.lineY.disabled = true;
            cursor.lineX.strokeDasharray = "1,4";
            cursor.lineX.strokeOpacity = 1;

            dateAxis.renderer.tooltipLocation2 = 0;
            categoryAxis.cursorTooltipEnabled = false;
            }else{
              catDay++;
            }
            
          }
        });
      }
    }  
}); // end am4core.ready()
</script>

<!-- diary/diary_6.php -->
<div id="chartdiv_6"></div>
<!-- END/ diary/diary_6.php -->