function RegistrarProducto() {
    const usuario = JSON.parse(localStorage.getItem('usuario'));
    if (!usuario) {
        alert("Sesión no válida. Inicie sesión.");
        window.location.href = "index.html";
        return;
    }

    let name = document.getElementById("txtNombreProducto").value;
    let cost = document.getElementById("txtCosto").value;
    let photo = document.getElementById("txtFoto").value;

    if (name === "" || cost === "" || photo === "") {
        alert("Completa todos los campos");
        return;
    }

    let producto = {
        Name: name,
        Cost: cost,
        Photo: photo,
        UserId: usuario.Id // tabla: Products.UserId
    };

    fetch("/app/producto", {
        method: "POST",
        body: JSON.stringify(producto)
    })
        .then(resp => {
            if (resp.status === 201) {
                alert("Producto registrado.");
                window.location.href = "panel.html";
            } else {
                alert("Error al registrar producto.");
            }
        });
}