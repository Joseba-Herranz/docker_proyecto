var show = new Array;
    show[0] =  '<img id="0" src="img/bbva.png" alt="BBVA" onclick="grafico(this)"> ';
    show[1] =  '<img id="1" src="img/caixa.png" alt="Caixa" onclick="grafico(this)"> ';
    show[2] =  '<img id="2" src="img/cellnex.png" alt="Cellnex" onclick="grafico(this)"> ';
    show[3] =  '<img id="3" src="img/ferrovial.png" alt="Ferrovial" onclick="grafico(this)"> ';
    show[4] =  '<img id="4" src="img/iberdrola.png" alt="Iberdrola" onclick="grafico(this)"> ';
    show[5] =  '<img id="5" src="img/inditex.png" alt="Inditex" onclick="grafico(this)"> ';
    show[6] =  '<img id="6" src="img/naturgy.png" alt="Naturgy" onclick="grafico(this)"> '; 
    show[7] =  '<img id="7" src="img/repsol.png" alt="Repsol" onclick="grafico(this)"> ';
    show[8] =  '<img id="8" src="img/santander.png" alt="Santander" onclick="grafico(this)"> ';
    show[9] =  '<img id="9" src="img/telefonica.png" alt="Telefonica" onclick="grafico(this)"> ';

$(function () {
    
    $("#inicio img").draggable({
        revert: "invalid",
        refreshPositions: true,
        drag: function (event, ui) {
            ui.helper.addClass("draggable");
        },
        stop: function (event, ui) {
            ui.helper.removeClass("draggable");
            var image = this.src.split("/")[this.src.split("/").length - 1];

        }
    });


    $("#fin").droppable({
        drop: function (event, ui) {
            if ($("#fin img").length == 0) {
                $("#fin").html("");
            }
            ui.draggable.addClass("dropped");
            $("#fin").append(ui.draggable);
            
            localStorage.setItem(ui.draggable.attr('id'), ui.draggable.attr('id'));
            
        }
    });

    $("#fin img").draggable({
        revert: "invalid",
        refreshPositions: true,
        drag: function (event, ui) {
            ui.helper.addClass("draggable");
        },
        stop: function (event, ui) {
            ui.helper.removeClass("draggable");
        }
    });

    $("#papelera").droppable({
        drop: function (event, ui) {
        ui.draggable.removeClass("dropped");
        ui.draggable.animate({
        top: 0,
        left: 0
        }, "slow");
        $("#inicio").append(ui.draggable);
        localStorage.removeItem(ui.draggable.attr('id'));
        }
    });
});

function guardado(){
    document.getElementById("arriba").style.display = "none";
    document.getElementById("abajo").style.display = "block";
    //  console.log("guardado");
    const mostrar = document.getElementById('mostrar');
    
    var toShow = `<button id="show" class="btn btn-info" onclick="opciones()">Seleccionar otra vez</button>` + "<br>";
    toShow += `<div id="container"></div>`;
    toShow += `<div class="d-flex flex-wrap">`;
    for(let x=0; x<10; x++){
        if(localStorage.getItem(x)!=null){
            toShow += `<div id='div${localStorage.getItem(x)}'>`;
            toShow += show[localStorage.getItem(x)];
            toShow += `<div>`;
            toShow += `<p id='valor${localStorage.getItem(x)}'>Valor actual</p>`;
            toShow += `</div>`;
            toShow += `</div>`;
        }
    }
    toShow += `</div>`;
    mostrar.innerHTML = toShow;  
    getValor();
    setInterval(getValor, 60000);
}

function getValor(){
    const options = {method: 'GET'};

    fetch('http://hz114496:1912/api/mostrar', options)
    .then(response => response.json())
    .then(response => { response.data.forEach(element => {
            var van = document.getElementById(`valor${element.empresa_id}`);
            if(van != null){
                if(element.SoB == 1){
                    van.innerHTML = `${element.valor}???`;
                    document.getElementById(`valor${element.empresa_id}`).style.color = "green";
                    setTimeout(function() {
                        document.getElementById(`valor${element.empresa_id}`).style.color = "black";
                    }, 3000);
                }else {
                    van.innerHTML = `${element.valor}???`;
                    document.getElementById(`valor${element.empresa_id}`).style.color = "red";
                    setTimeout(function() {
                        document.getElementById(`valor${element.empresa_id}`).style.color = "black";
                    }, 3000);
                }
            }
            previousValue = element.valor;
        });
    })
    .catch(err => console.error(err));
}

function opciones(){
    document.getElementById("arriba").style.display = "block";
    document.getElementById("abajo").style.display = "none";
}