function vistaPrev(){
    for(var x=0; x<10; x++){
        if(localStorage.getItem(x)!=null){
            console.log(localStorage.getItem(x));
            document.getElementById(x).style.display = "none";
            document.getElementById('fin').innerHTML += show[x];
        }
    }

    if(localStorage.getItem("token")!=null){
        document.getElementById("form").style.display = "none";
        document.getElementById("contenido").style.display = "block";
    }
    

    document.getElementById("save").addEventListener("click", function(event) {
        
        event.preventDefault();
        
        guardado();
    });

    document.getElementById("regis").addEventListener("click", function(event) {
        
        event.preventDefault();
        
        registro();
    });

    document.getElementById("login").addEventListener("click", function(event) {
        
        event.preventDefault();
        
        login();
    });

    


}