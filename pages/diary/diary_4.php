<!-- Chart code -->
<script id="script_diary_4" type='text/javascript'>
  var menuID = 4;
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
      if (menuID==4) {
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
      
      $.ajax({
        type: "POST",
        url: path+'ajax/get_registers_count_fishbone.php',
        data: {'cargo': 'student', 'id': sessionStorage.getItem('id'), 'type': type, 'day': date1.getDate(), 'month': (date1.getMonth()+1), 'year': date1.getFullYear(), 'tag': tag},
        dataType: "json",
        success: function (response) {
          if (response.codigo==0) {
            alert("A data é futura.");
          } else {
            //console.log(response);

            // Themes begin
            am4core.useTheme(am4themes_animated);
            // Themes end
            var dataChart = []; 
            for (const key in response) {
              if (Object.hasOwnProperty.call(response, key)) {
                const element = response[key];
                //console.log(key+': '+element);

                var date2 = new Date(Date.now());
                var mes = date2.getMonth()+1;              
                var mesZerado = mes;
                if (mes<10) {
                  mesZerado="0"+mes;
                }
                var date2Formatted = "";
                switch (key) {
                  case 'Janeiro':
                    date2Formatted = date2.getFullYear()+"-01-01";
                    break;
                  case 'Fevereiro':
                    date2Formatted = date2.getFullYear()+"-02-01";
                    break;
                  case 'Março':
                    date2Formatted = date2.getFullYear()+"-03-01";
                    break;
                  case 'Abril':
                    date2Formatted = date2.getFullYear()+"-04-01";
                    break;
                  case 'Maio':
                    date2Formatted = date2.getFullYear()+"-05-01";
                    break;
                  case 'Junho':
                    date2Formatted = date2.getFullYear()+"-06-01";
                    break;
                  case 'Julho':
                    date2Formatted = date2.getFullYear()+"-07-01";
                    break;
                  case 'Agosto':
                    date2Formatted = date2.getFullYear()+"-08-01";
                    break;
                  case 'Setembro':
                    date2Formatted = date2.getFullYear()+"-09-01";
                    break;
                  case 'Outubro':
                    date2Formatted = date2.getFullYear()+"-10-01";
                    break;
                  case 'Novembro':
                    date2Formatted = date2.getFullYear()+"-11-01";
                    break;
                  case 'Dezembro':
                    date2Formatted = date2.getFullYear()+"-22-01";
                    break;
                  default:
                    if (key.includes("/"+mes)) {  
                      var dia = key.replace("/"+mes, "");                      
                      if (dia<10) {
                        dia = "0"+dia;                                                
                      }                    
                      date2Formatted = date2.getFullYear()+"-"+mesZerado+"-"+dia;
                    } else {
                      date2Formatted = key+"-01-01";                      
                    }
                    break;
                }

                //console.log('data: '+date2Formatted);

                var line = {
                  "category": "",
                  "dateName": key,
                  "date": date2Formatted,
                  "size": element,
                  "text": "Lorem ipsum dolor"
                };
                dataChart.push(line);                
              }
            }
            //console.log('TERMINOU');
            var chart = am4core.create("chartdiv_4", am4plugins_timeline.CurveChart);
            chart.curveContainer.padding(0, 100, 0, 120);
            chart.maskBullets = false;

            var colorSet = new am4core.ColorSet();

            chart.data = dataChart;

            chart.dateFormatter.inputDateFormat = "yyyy-MM-dd";

            chart.fontSize = 11;
            chart.tooltipContainer.fontSize = 11;

            var categoryAxis = chart.yAxes.push(new am4charts.CategoryAxis());
            categoryAxis.dataFields.category = "category";
            categoryAxis.renderer.grid.template.disabled = true;

            var dateAxis = chart.xAxes.push(new am4charts.DateAxis());
            dateAxis.renderer.points = [{ x: -400, y: 0 }, { x: 0, y: 50 }, { x: 400, y: 0 }]
            dateAxis.renderer.polyspline.tensionX = 0.8;
            dateAxis.renderer.grid.template.disabled = true;
            dateAxis.renderer.line.strokeDasharray = "1,4";
            dateAxis.baseInterval = {period:"day", count:1}; // otherwise initial animation will be not smooth

            dateAxis.renderer.labels.template.disabled = true;

            var series = chart.series.push(new am4plugins_timeline.CurveLineSeries());
            series.strokeOpacity = 0;
            series.dataFields.dateX = "date";
            series.dataFields.categoryY = "category";
            series.dataFields.value = "size";
            series.baseAxis = categoryAxis;

            var interfaceColors = new am4core.InterfaceColorSet();

            series.tooltip.pointerOrientation = "down";

            var distance = 100;
            var angle = 60;

            var bullet = series.bullets.push(new am4charts.Bullet());

            var line = bullet.createChild(am4core.Line);
            line.adapter.add("stroke", function(fill, target) {
              if (target.dataItem) {
                return chart.colors.getIndex(target.dataItem.index)
              }
            });

            line.x1 = 0;
            line.y1 = 0;
            line.y2 = 0;
            line.x2 = distance - 10;
            line.strokeDasharray = "1,3";

            var circle = bullet.createChild(am4core.Circle);
            circle.radius = 30;
            circle.fillOpacity = 1;
            circle.strokeOpacity = 0;

            var circleHoverState = circle.states.create("hover");
            circleHoverState.properties.scale = 1.3;

            series.heatRules.push({ target: circle, min: 20, max: 50, property: "radius" });
            circle.adapter.add("fill", function(fill, target) {
              if (target.dataItem) {
                return chart.colors.getIndex(target.dataItem.index)
              }
            });
            circle.tooltipText = "Total de "+type+"s: {value}";
            circle.adapter.add("tooltipY", function(tooltipY, target){
              return -target.pixelRadius - 4;
            });

            var yearLabel = bullet.createChild(am4core.Label);
            yearLabel.text = "{dateName}";
            yearLabel.strokeOpacity = 0;
            yearLabel.fill = am4core.color("#fff");
            yearLabel.horizontalCenter = "middle";
            yearLabel.verticalCenter = "middle";
            yearLabel.interactionsEnabled = false;

            var label = bullet.createChild(am4core.Label);
            //label.propertyFields.text = "text";
            label.strokeOpacity = 0;
            label.horizontalCenter = "right";
            label.verticalCenter = "middle";

            label.adapter.add("opacity", function(opacity, target) {
              if(target.dataItem){
                var index = target.dataItem.index;
                var line = target.parent.children.getIndex(0);

                if (index % 2 == 0) {
                  target.y = -distance * am4core.math.sin(-angle);
                  target.x = -distance * am4core.math.cos(-angle);
                  line.rotation = -angle - 180;
                  target.rotation = -angle;
                }
                else {
                  target.y = -distance * am4core.math.sin(angle);
                  target.x = -distance * am4core.math.cos(angle);
                  line.rotation = angle - 180;
                  target.rotation = angle;
                }
              }
              return 1;
            });

            var outerCircle = bullet.createChild(am4core.Circle);
            outerCircle.radius = 30;
            outerCircle.fillOpacity = 0;
            outerCircle.strokeOpacity = 0;
            outerCircle.strokeDasharray = "1,3";

            var hoverState = outerCircle.states.create("hover");
            hoverState.properties.strokeOpacity = 0.8;
            hoverState.properties.scale = 1.5;

            outerCircle.events.on("over", function(event){
              var circle = event.target.parent.children.getIndex(1);
              circle.isHover = true;
              event.target.stroke = circle.fill;
              event.target.radius = circle.pixelRadius;
              event.target.animate({property: "rotation", from: 0, to: 360}, 4000, am4core.ease.sinInOut);
            });

            outerCircle.events.on("out", function(event){
              var circle = event.target.parent.children.getIndex(1);
              circle.isHover = false;
            });

            chart.scrollbarX = new am4core.Scrollbar();
            chart.scrollbarX.opacity = 0.5;
            chart.scrollbarX.width = am4core.percent(50);
            chart.scrollbarX.align = "center";  


          }
        }
      });

    }

    

  }); // end am4core.ready()
</script>

<!-- diary/diary_4.php -->
<div id="chartdiv_4"></div>
<!-- END/ diary/diary_4.php -->