<!-- Chart code -->
<script id="script_diary_5" type='text/javascript'>
  var menuID = 5;
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
      if (menuID==5) {
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
          // console.log('tipo: '+type);
          // console.log('data inicial: '+dateIni);
          // console.log('data final: '+dateEnd);
          // console.log('tag: '+tag);
          // console.log('tag2: '+tag2);
          // console.log('tag3: '+tag3);
          // console.log('tag4: '+tag4);
          // console.log('tag5: '+tag5);
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
            //console.log('dia: '+dataFormatada);          
            //console.log(response);            

            if (response.tag!='no') {
               //console.log('##################');
               //console.log('COMEÇO DA TAG');
              for (const key in response.tag) {
                if (Object.hasOwnProperty.call(response.tag, key)) {
                  const element = response.tag[key];
                   //console.log('********************');
                   //console.log('key: '+key);
                   //console.log(element);
                   //console.log('start: '+element['date_ini']);
                   //console.log('end: '+element['date_end']);
                   //console.log('task: '+tag);  
                  
                  var line = {
                    "start": element['date_ini'],
                    "end": element['date_end'],
                    "task":tag,
                    "event": element['name']
                  };
                  dataChart.push(line);  
                  
                }
              }
               //console.log('FIM DA TAG');
            }else{              
               //console.log('##################');
               //console.log('TAG SEM RESULTADOS');
            }
            if (response.tag2!='no') {
              for (const key in response.tag2) {
                if (Object.hasOwnProperty.call(response.tag2, key)) {
                  const element = response.tag2[key];
                  
                  var line = {
                    "start": element['date_ini'],
                    "end": element['date_end'],
                    "task":tag2,
                    "event": element['name']
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
                    "start": element['date_ini'],
                    "end": element['date_end'],
                    "task":tag3,
                    "event": element['name']
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
                    "start": element['date_ini'],
                    "end": element['date_end'],
                    "task":tag4,
                    "event": element['name']
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
                    "start": element['date_ini'],
                    "end": element['date_end'],
                    "task":tag5,
                    "event": element['name']
                  };
                  dataChart.push(line);  
                  
                }
              }
            }else{              
            }
            if (catDay==diffDays+1) {
              //console.log('TERMINOU');
            var container = am4core.create("chartdiv_5", am4core.Container);
            container.width = am4core.percent(100);
            container.height = am4core.percent(100);

            var interfaceColors = new am4core.InterfaceColorSet();
            var colorSet = new am4core.ColorSet();

            var chart = container.createChild(am4plugins_timeline.CurveChart);

            var line = {
              "task": ""
                  };
            dataChart.push(line);  

            chart.data = dataChart.reverse();            

            chart.dateFormatter.dateFormat = "yyyy-MM-dd hh:mm:ss";
            chart.dateFormatter.inputDateFormat = "yyyy-MM-dd hh:mm:ss";
            chart.dy = 90;
            chart.maskBullets = false;

            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "task";
            categoryAxis.renderer.labels.template.paddingRight = 25;
            categoryAxis.renderer.minGridDistance = 10;
            categoryAxis.renderer.innerRadius = 0;
            categoryAxis.renderer.radius = 100;
            categoryAxis.renderer.grid.template.location = 1;

            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.minGridDistance = 70;
            dateAxis.min = new Date(dateIni).getTime();
            dateAxis.max = new Date(dateEnd).getTime();

            dateAxis.baseInterval = { count: 1, timeUnit: "minute" };
            dateAxis.startLocation = -0.5;

            dateAxis.renderer.points = [{ x: -400, y: 0 }, { x: -250, y: 0 }, { x: 0, y: 60 }, { x: 250, y: 0 }, { x: 400, y: 0 }];
            dateAxis.renderer.autoScale = false;
            dateAxis.renderer.polyspline.tensionX = 0.8;
            dateAxis.renderer.tooltipLocation = 0;
            dateAxis.renderer.grid.template.disabled = true;
            dateAxis.renderer.line.strokeDasharray = "1,4";
            dateAxis.renderer.line.strokeOpacity = 0.7;
            dateAxis.tooltip.background.fillOpacity = 0.2;
            dateAxis.tooltip.background.cornerRadius = 5;
            dateAxis.tooltip.label.fill = new am4core.InterfaceColorSet().getFor("alternativeBackground");
            dateAxis.tooltip.label.paddingTop = 7;

            var labelTemplate = dateAxis.renderer.labels.template;
            labelTemplate.verticalCenter = "middle";
            labelTemplate.fillOpacity = 0.7;
            labelTemplate.background.fill = interfaceColors.getFor("background");
            labelTemplate.background.fillOpacity = 1;
            labelTemplate.padding(7,7,7,7);

            var series = chart.series.push(new am4plugins_timeline.CurveColumnSeries());
            series.columns.template.height = am4core.percent(15);
            series.columns.template.tooltipText = "{event}: [bold]{start}[/] - [bold]{end}[/]";

            series.dataFields.openDateX = "start";
            series.dataFields.dateX = "end";
            series.dataFields.categoryY = "task";
            series.columns.template.propertyFields.fill = "color"; // get color from data
            series.columns.template.propertyFields.stroke = "color";
            series.columns.template.strokeOpacity = 0;

            series.columns.template.adapter.add("fill", function (fill, target) {
              return chart.colors.getIndex(target.dataItem.index * 3);
            })

            var flagBullet1 = new am4plugins_bullets.FlagBullet();
            series.bullets.push(flagBullet1);
            flagBullet1.disabled = true;
            flagBullet1.propertyFields.disabled = "bulletf1";
            flagBullet1.locationX = 1;
            flagBullet1.label.text = "começo";

            var flagBullet2 = new am4plugins_bullets.FlagBullet();
            series.bullets.push(flagBullet2);
            flagBullet2.disabled = true;
            flagBullet2.propertyFields.disabled = "bulletf2";
            flagBullet2.locationX = 0;
            flagBullet2.background.fill = interfaceColors.getFor("background");
            flagBullet2.label.text = "fim";

            var bullet = new am4charts.CircleBullet();
            series.bullets.push(bullet);
            bullet.circle.radius = 3;
            bullet.circle.strokeOpacity = 0;
            bullet.locationX = 0;

            bullet.adapter.add("fill", function (fill, target) {
              return chart.colors.getIndex(target.dataItem.index * 3);
            })

            var bullet2 = new am4charts.CircleBullet();
            series.bullets.push(bullet2);
            bullet2.circle.radius = 3;
            bullet2.circle.strokeOpacity = 0;
            bullet2.propertyFields.fill = "color";
            bullet2.locationX = 1;

            bullet2.adapter.add("fill", function (fill, target) {
              return chart.colors.getIndex(target.dataItem.index * 3);
            })

            chart.scrollbarX = new am4core.Scrollbar();
            chart.scrollbarX.align = "center"
            chart.scrollbarX.width = 800;
            chart.scrollbarX.parent = chart.bottomAxesContainer;
            chart.scrollbarX.dy = - 90;
            chart.scrollbarX.opacity = 0.4;

            var cursor = new am4plugins_timeline.CurveCursor();
            chart.cursor = cursor;
            cursor.xAxis = dateAxis;
            cursor.yAxis = categoryAxis;
            cursor.lineY.disabled = true;
            cursor.lineX.strokeDasharray = "1,4";
            cursor.lineX.strokeOpacity = 1;

            dateAxis.renderer.tooltipLocation2 = 0;
            categoryAxis.cursorTooltipEnabled = false;


            /// clock
            var clock = container.createChild(am4charts.GaugeChart);
            clock.toBack();

            clock.radius = 120;
            clock.dy = -100;
            clock.startAngle = -90;
            clock.endAngle = 270;

            var axis = clock.xAxes.push(new am4charts.ValueAxis());
            axis.min = 0;
            axis.max = 12;
            axis.strictMinMax = true;

            axis.renderer.line.strokeWidth = 1;
            axis.renderer.line.strokeOpacity = 0.5;
            axis.renderer.line.strokeDasharray = "1,4";
            axis.renderer.minLabelPosition = 0.05; // hides 0 label
            axis.renderer.inside = true;
            axis.renderer.labels.template.radius = 30;
            axis.renderer.grid.template.disabled = true;
            axis.renderer.ticks.template.length = 12;
            axis.renderer.ticks.template.strokeOpacity = 1;

            // serves as a clock face fill
            var range = axis.axisRanges.create();
            range.value = 0;
            range.endValue = 12;
            range.grid.visible = false;
            range.tick.visible = false;
            range.label.visible = false;

            var axisFill = range.axisFill;

            // hands
            var hourHand = clock.hands.push(new am4charts.ClockHand());
            hourHand.radius = am4core.percent(60);
            hourHand.startWidth = 5;
            hourHand.endWidth = 5;
            hourHand.rotationDirection = "clockWise";
            hourHand.pin.radius = 8;
            hourHand.zIndex = 1;

            var minutesHand = clock.hands.push(new am4charts.ClockHand());
            minutesHand.rotationDirection = "clockWise";
            minutesHand.startWidth = 3;
            minutesHand.endWidth = 3;
            minutesHand.radius = am4core.percent(78);
            minutesHand.zIndex = 2;

            chart.cursor.events.on("cursorpositionchanged", function (event) {
              var value = dateAxis.positionToValue(event.target.xPosition)
              var date = new Date(value);
              var hours = date.getHours();
              var minutes = date.getMinutes();
              // set hours
              hourHand.showValue(hours + minutes / 60, 0);
              // set minutes
              minutesHand.showValue(12 * minutes/ 60, 0);       
            })    
            } else {
              catDay++;
            }

          }
            }); 

          }
                
          
     


    }


  }); // end am4core.ready()
</script>

<!-- diary/diary_5.php -->
<div id="chartdiv_5"></div>
<!-- END/ diary/diary_5.php -->