document.addEventListener("DOMContentLoaded", function(){
    cargarProductos();
});

function cargarProductos() {
    fetch("/app/producto", { method: "GET" })
        .then(response => response.ok ? response.json() : Promise.reject())
        .then(data => {
            let sel = document.getElementById("selProducto");
            let opciones = "<option value='0'>Seleccione</option>";
            data.datos.forEach(prod => {
                opciones += `<option value="${prod.Id}">${prod.Name}</option>`;
            });
            sel.innerHTML = opciones;
        });
}

function RegistrarPromocion() {
    const usuario = JSON.parse(localStorage.getItem('usuario'));
    if (!usuario) {
        alert("Sesión no válida. Inicie sesión.");
        window.location.href = "index.html";
        return;
    }
    let pro_id = document.getElementById("selProducto").value;
    if (pro_id === "0") {
        alert("Seleccione un producto");
        return;
    }
    let promocion = {
        prom_usu_id: usuario.Id,  // tabla: tbl_promo.prom_usu_id
        prom_pro_id: pro_id       // tabla: tbl_promo.prom_pro_id
    };
    fetch("/app/promocion", {
        method: "POST",
        body: JSON.stringify(promocion)
    })
        .then(resp => {
            if(resp.status === 201) {
                alert("Promoción registrada.");
                window.location.href = "panel.html";
            } else {
                alert("Error al registrar promoción.");
            }
        });
}