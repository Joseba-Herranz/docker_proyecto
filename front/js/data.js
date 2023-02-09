function grafico(img){
        var id = img.id;
        var nombre = img.alt;
          var dId = { id: id };
        
          var requestOptions = {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(dId),
            redirect: 'follow'
          };
            
            fetch("http://hz114496:1912/api/grafico", requestOptions)
                .then(res => res.json())
                .then(result => graf(result,id,nombre))
                .catch(error => console.error(error.message));
    }

function graf(result,id,nombre){
    let data = [];
    result['data'].forEach(element =>{
        if (element['empresa_id'] == id) {
          let fecha = new Date(element['fecha'])
          let date = fecha.getTime();
          data.push([date,element['valor']]);
        }
    });
    mostrarGraf(data, nombre)
}

function mostrarGraf(data, nombre){
  Highcharts.stockChart('container', {
    title: {
      text: 'valor de '+nombre
    },

    xAxis: {
      gapGridLineWidth: 0
    },

    rangeSelector: {
      buttons: [{
        type: 'hour',
        count: 1,
        text: '1h'
      }, {
        type: 'day',
        count: 1,
        text: '1D'
      }, {
        type: 'all', 
        text: 'All'
      }],
      selected: 1,
      inputEnabled: false
    },

    series: [{
      name: nombre,
      type: 'area',
      data: data,
      gapSize: 5,
      tooltip: {
        valueDecimals: 2
      },
      fillColor: {
        linearGradient: {
          x1: 0,
          y1: 0,
          x2: 0,
          y2: 1
        },
        stops: [
          [0, Highcharts.getOptions().colors[0]],
          [1, Highcharts.color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
        ]
      },
      threshold: null
    }]
  });


} 