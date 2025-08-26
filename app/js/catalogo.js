document.addEventListener("DOMContentLoaded", function(){
    cargarCatalogo();
});

function cargarCatalogo() {
    fetch("/app/producto", { method: "GET" })
        .then(response => response.ok ? response.json() : Promise.reject())
        .then(data => {
            let grid = document.getElementById("catalogoGrid");
            grid.innerHTML = "";
            if (data.datos && data.datos.length > 0) {
                data.datos.forEach(prod => {
                    let card = document.createElement("div");
                    card.className = "producto-card";
                    card.innerHTML = `
                    <img src="${prod.Photo}" alt="${prod.Name}">
                    <div class="producto-nombre">${prod.Name}</div>
                    <div class="producto-costo">Costo: $${parseFloat(prod.Cost).toFixed(2)}</div>
                `;
                    grid.appendChild(card);
                });
            } else {
                grid.innerHTML = "<div style='grid-column:1/-1;text-align:center;color:#e53935;font-size:1.1em;'>No hay productos en el catálogo.</div>";
            }
        });
}