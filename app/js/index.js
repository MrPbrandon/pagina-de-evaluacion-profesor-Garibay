function mostrarRegistro(){
    document.getElementById("divIngresar").style.display= "none";
    document.getElementById("divRegistro").style.display ="block";
}
function mostrarIngresar(){
    document.getElementById("divIngresar").style.display= "block";
    document.getElementById("divRegistro").style.display ="none";
}

function Registrar(){
    let correcto = true;
    if (document.getElementById("txtNombre").value == ""){
        alert("Ingresa un Nombre");
        correcto = false;
    }
    if (document.getElementById("txtCorreo").value == ""){
        alert("Ingresa un Correo");
        correcto = false;
    }
    if (document.getElementById("txtContrasena").value == ""){
        alert("Ingresa la Contraseña");
        correcto = false;
    }
    if (document.getElementById("txtConfContrasena").value == ""){
        alert("Confirma tu Contraseña");
        correcto = false;
    }
    if (document.getElementById("txtConfContrasena").value != document.getElementById("txtContrasena").value){
        alert("Las contraseñas no coinciden");
        correcto = false;
    }
    if (!correcto){
        return;
    }
    var usuario = {
        name: document.getElementById("txtNombre").value,
        mail: document.getElementById("txtCorreo").value,
        password: document.getElementById("txtContrasena").value
    };
    var opciones = {
        method:"POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify(usuario)
    };
    fetch("/app/usuario", opciones)
        .then(function (respuesta) {
            if (respuesta.status == 201){
                alert("Registrado. Ahora puedes iniciar sesión.");
                mostrarIngresar();
            } else{
                alert("Error al registrar. ¿Correo ya registrado?");
            }
        });
}

function Ingresar() {
    var correo = document.getElementById("txtCorreoI").value;
    var contrasena = document.getElementById("txtContrasenaI").value;
    var opciones = { method: "GET" };
    fetch("/app/usuario/" + correo + "/" + contrasena, opciones)
        .then(function (respuesta){
            if (respuesta.status == 200){
                return respuesta.json();
            } else {
                alert("Correo o contraseña incorrectos");
                return null;
            }
        })
        .then(function(usuario){
            // usuario.datos es un array
            if(usuario && usuario.datos && usuario.datos.length > 0){
                localStorage.setItem('usuario', JSON.stringify(usuario.datos[0]));
                localStorage.setItem('sesionHora', Date.now());
                window.location.href = "panel.html";
            } else {
                alert("No se encontró usuario con esas credenciales");
            }
        });
}