function grafico(img){
        var id = img.id;
        var nombre = img.alt;
        // console.log(id);
        // console.log(nombre);

          var dId = { id: id };
        
          var requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dId),
            redirect: 'follow'
          };
            
            fetch("http://127.0.0.1:8000/api/grafico", requestOptions)
                .then(res => res.json())
                .then(result => result.data.forEach(element => {
                    // console.log(element.empresa_id == id);
                        // console.log("entro");
                        console.log(element.fecha);
                        console.log(element.valor);
                        var data = [element.fecha, element.valor];
                        mostrarGraf(data, nombre)}))
                .catch(error => console.error(error.message));

    }

function mostrarGraf(info, nombre){
//   Highcharts.getJSON(info , function (data) {
//   Highcharts.stockChart('container', {
//     title: {
//       text: 'valor de '+nombre
//     },

//     subtitle: {
//       text: 'Using ordinal X axis'
//     },

//     xAxis: {
//       gapGridLineWidth: 0
//     },

//     rangeSelector: {
//       buttons: [{
//         type: 'hour',
//         count: 1,
//         text: '1h'
//       }, {
//         type: 'day',
//         count: 1,
//         text: '1D'
//       }, {
//         type: 'all',
//         count: 1,
//         text: 'All'
//       }],
//       selected: 1,
//       inputEnabled: false
//     },

//     series: [{
//       name: nombre,
//       type: 'area',
//       data: data,
//       gapSize: 5,
//       tooltip: {
//         valueDecimals: 2
//       },
//       fillColor: {
//         linearGradient: {
//           x1: 0,
//           y1: 0,
//           x2: 0,
//           y2: 1
//         },
//         stops: [
//           [0, Highcharts.getOptions().colors[0]],
//           [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
//         ]
//       },
//       threshold: null
//     }]
//   });
// });

// Highcharts.getJSON(info, function (data) {

    // Create the chart
    Highcharts.stockChart('container', {

        rangeSelector: {
            selected: 1
        },

        title: {
            text: 'AAPL Stock Price'+nombre
        },

        series: [{
            name: 'AAPL Stock Price',
            data: info,
            step: true,
            tooltip: {
                valueDecimals: 2
            }
        }]
    });
// });




} 