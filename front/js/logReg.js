
/////////
//Login//
/////////

function login(){
    const email = document.getElementById('logE').value;
    const password = document.getElementById('logP').value;

    var formdata = new FormData();
    formdata.append("email", email);
    formdata.append("password", password);
    
    var requestOptions = {
      method: 'POST',
      body: formdata,
      redirect: 'follow'
    };
    
    fetch("http://127.0.0.1:8000/api/login", requestOptions)
      .then(response => response.json())
      .then(result => {
        localStorage.setItem("token", result['authorisation']['token']);
        document.getElementById("form").style.display = "none";
        document.getElementById("contenido").style.display = "block";
      })
      .catch(error => {
        alert("Tu correo o contraseña no son correctos");
      });
}

////////////
//Registro//
////////////

function registro(){

    const nombre = document.getElementById('regN').value;
    const email = document.getElementById('regE').value;
    const password = document.getElementById('regP').value;


    var formdata = new FormData();
    formdata.append("name", nombre);
    formdata.append("email", email);
    formdata.append("password", password);

    var requestOptions = {
    method: 'POST',
    body: formdata,
    redirect: 'follow'
    };

    fetch("http://127.0.0.1:8000/api/register", requestOptions)
    .then(response => response.json())
    .then(result => {
        localStorage.setItem("token", result['authorisation']['token']);
        // localStorage.setItem("antes", ) Prueba para saber si el usuario estaba logeado antes 
        document.getElementById("form").style.display = "none";
        document.getElementById("contenido").style.display = "block";
    })
    .catch(error => console.log('error', error));
}

////////////
//Log Out///
////////////

function logOut(){
    localStorage.removeItem("token");
}