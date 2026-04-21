//EVENTOS PARA PANEL DE ADMINISTRACION
const btnGestion = document.getElementById("btn-gestion");
const flechaAbajo = document.getElementById("flecha-abajo");
const flechaArriba = document.getElementById("flecha-arriba");
const flechaIzquierda = document.getElementById("flecha-iz");
const flechaDerecha = document.getElementById("flecha-der");
const listaGestion = document.getElementById("lista-gestion");
const menuPanel = document.getElementById("menuPanel");
const generalGestion = document.querySelector(".general-gestion");
const generalAnalitica = document.querySelector(".general-analiticas");
const general = document.querySelector(".general");
const generalPanel = document.querySelector(".general-panel");
const imgLogo = document.getElementById("img-logo");


flechaIzquierda.addEventListener("click",()=>{
    menuPanel.classList.toggle("menu-cerrado");
    flechaDerecha.classList.toggle("mostrar-flechas");
    flechaIzquierda.classList.toggle("ocultar-flechas");
    generalPanel.classList.toggle("general-panel-cerrado");
    generalGestion.classList.toggle("ocultar");
    generalAnalitica.classList.toggle("ocultar");
    general.classList.toggle("ocultar");
    imgLogo.classList.toggle("ocultar");
    setTimeout(() => {
        Object.values(Chart.instances).forEach(chart => {
            chart.resize();
        });
    }, 450);
});

flechaDerecha.addEventListener("click",()=>{
    menuPanel.classList.toggle("menu-cerrado");
    flechaDerecha.classList.toggle("mostrar-flechas");
    flechaIzquierda.classList.toggle("ocultar-flechas");
    generalPanel.classList.toggle("general-panel-cerrado");
    generalGestion.classList.toggle("ocultar");
    generalAnalitica.classList.toggle("ocultar");
    general.classList.toggle("ocultar");
    imgLogo.classList.toggle("ocultar");
    setTimeout(() => {
        Object.values(Chart.instances).forEach(chart => {
            chart.resize();
        });
    }, 450);
});


//AJAX PARA PANEL DE CONTROL
const insertarDatos = document.getElementById("informacion");
const usuarios = document.getElementById("usuarios");
const productos = document.getElementById("productos");
const ligas = document.getElementById("ligas");
const equipos = document.getElementById("equipos");
const pedidos = document.getElementById("pedidos");
const btnGeneral = document.getElementById("btn-general");

function cerrarMenuMovil() {
    menuPanel.classList.remove('menu-abierto');
    overlayMenu.classList.remove('visible');
}

insertarDatos.addEventListener("click", (e)=>{
    if (e.target && e.target.id === 'subirProducto') {
        fetch('./admin/subirProductoForm.php')
            .then(response => response.text())
            .then(html => { insertarDatos.innerHTML = html; })
            .catch(error => console.error('Error:', error));
    }

    if (e.target && e.target.id === 'gestionarStock') {
        fetch('./admin/gestionarStock.php')
            .then(response => response.text())
            .then(html => {
                insertarDatos.innerHTML = html;
                const m = document.getElementById("modalEdicion");
                if (m) m.style.display = "none";
                // DATATABLES
            if (document.getElementById("tablaStock")) {
                new DataTable('#tablaStock', {
                    responsive: true,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json'
                    },
                    columnDefs: [{ orderable: false, targets: [0, 5] }],
                    order: [[1, 'asc']],
                    pageLength: 10
                });
            }
            })
            .catch(error => console.error('Error:', error));
    }
});

btnGeneral.addEventListener("click",()=>{
    cerrarMenuMovil();
    fetch('./admin/general.php', { method: 'POST', body: new FormData() })
    .then(res => res.text())
    .then(html => { insertarDatos.innerHTML = html; })
    .catch(err => console.error("Error:", err));
});

usuarios.addEventListener("click",()=>{
    cerrarMenuMovil();
    fetch('./admin/obtenerUsuarios.php', { method: 'POST', body: new FormData() })
    .then(res => res.text())
    .then(html => { 
        insertarDatos.innerHTML = html;
        // DATATABLES
        if (document.getElementById("tablaUsuarios")) {
            new DataTable('#tablaUsuarios', {
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json'
                },
                columnDefs: [{ orderable: false, targets: [6] }],
                order: [[1, 'asc']],
                pageLength: 10
            });
        }
    })
    .catch(err => console.error("Error:", err));
});

productos.addEventListener("click",()=>{
    cerrarMenuMovil();
    fetch('./admin/obtenerProductos.php', { method: 'POST', body: new FormData() })
    .then(res => res.text())
    .then(html => {
        insertarDatos.innerHTML = html;
        const m = document.getElementById("modalEdicion");
        if (m) m.style.display = "none";

        // DATATABLES
        if (document.getElementById("tablaProductos")) {
            new DataTable('#tablaProductos', {
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json'
                },
                columnDefs: [{ orderable: false, targets: [0, 4] }],
                order: [[1, 'asc']],
                pageLength: 10
            });
        }
        
    })
    .catch(err => console.error("Error:", err));
});

ligas.addEventListener("click",()=>{
    cerrarMenuMovil();
    fetch('./admin/obtenerLigas.php', { method: 'POST', body: new FormData() })
    .then(res => res.text())
    .then(html => { 
        insertarDatos.innerHTML = html; 
        // DATATABLES
        if (document.getElementById("tablaLigas")) {
            new DataTable('#tablaLigas', {
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json'
                },
                columnDefs: [{ orderable: false, targets: [2] }],
                order: [[1, 'asc']],
                pageLength: 10
            });
        }
    })
    .catch(err => console.error("Error:", err));
});

equipos.addEventListener("click",()=>{
    cerrarMenuMovil();
    fetch('./admin/obtenerEquipos.php', { method: 'POST', body: new FormData() })
    .then(res => res.text())
    .then(html => { 
        insertarDatos.innerHTML = html;
        // DATATABLES
        if (document.getElementById("tablaEquipos")) {
            new DataTable('#tablaEquipos', {
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json'
                },
                order: [[1, 'asc']],
                pageLength: 10,
                columnDefs: [
                    { orderable: false, targets: [2] },
                    { responsivePriority: 1, targets: 0 },
                    { responsivePriority: 2, targets: 2 },
                    { responsivePriority: 3, targets: 1 }  
                ]
            });
        }
    })
    .catch(err => console.error("Error:", err));
});

pedidos.addEventListener("click",()=>{
    cerrarMenuMovil();
    fetch('./admin/obtenerPedidos.php', { method: 'POST', body: new FormData() })
    .then(res => res.text())
    .then(html => { 
        insertarDatos.innerHTML = html;
        // DATATABLES
        if (document.getElementById("tablaPedidos")) {
            new DataTable('#tablaPedidos', {
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json'
                },
                columnDefs: [{ orderable: false, targets: [4] }],
                order: [[1, 'asc']],
                pageLength: 10
            });
        } 
    })
    .catch(err => console.error("Error:", err));
});


// EDITAR PRODUCTOS
document.addEventListener("click", (e) => {
    const esBtnEditar = e.target.classList.contains("btn-editar") && e.target.getAttribute("data-id");
    const esImgProducto = e.target.classList.contains("img-producto") || e.target.classList.contains("img-producto-movil");

    if (esBtnEditar || esImgProducto) {
        const idProducto = e.target.getAttribute("data-id");
        const modal = document.getElementById("modalEdicion");
        const tablaContenedor = document.getElementById("contenedor-tabla-productos");

        if (!modal || !idProducto) return;

        fetch(`./admin/datos_producto.php?id=${idProducto}`)
            .then(response => response.json())
            .then(data => {
                if (!data) return;

                document.getElementById("edit-id").value = data.id;
                document.getElementById("edit-nombre").value = data.nombre;
                document.getElementById("edit-descripcion").value = data.descripcion;
                document.getElementById("edit-precio").value = data.precio;
                document.getElementById("edit-url-imagen-actual").value = data.url_imagen;

                // Mostrar imagen actual
                const previewActual = document.getElementById("preview-imagen-actual");
                if (previewActual) previewActual.src = data.url_imagen;


                if (tablaContenedor) tablaContenedor.style.display = "none";
                modal.style.display = "block";
            })
            .catch(err => console.error("Error al obtener datos:", err));
    }
});

// Preview en tiempo real al seleccionar nueva imagen
document.addEventListener("change", (e) => {
    if (e.target && e.target.id === "edit-imagen") {
        const archivo         = e.target.files[0];
        const contenedorNueva = document.getElementById("contenedor-preview-nueva");
        const previewNueva    = document.getElementById("preview-nueva-imagen");

        if (archivo && contenedorNueva && previewNueva) {
            const reader = new FileReader();
            reader.onload = (ev) => {
                previewNueva.src = ev.target.result;
                contenedorNueva.style.display = "block";
            };
            reader.readAsDataURL(archivo);
        } else if (contenedorNueva) {
            contenedorNueva.style.display = "none";
        }
    }
});

// Enviar formulario de actualización
document.addEventListener("submit", (e) => {
    if (e.target && e.target.id === "formEditar") {
        e.preventDefault();
        const formData = new FormData(e.target);

        fetch("./admin/actualizar_producto.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(() => { location.reload(); })
        .catch(err => console.error("Error al actualizar:", err));
    }
});

// Cerrar modal
document.addEventListener("click", (e) => {
    const modal = document.getElementById("modalEdicion");
    const tablaContenedor = document.getElementById("contenedor-tabla-productos") || document.querySelector(".tabla");

    if (!modal) return;

    if (e.target.classList.contains("close")) {
        modal.style.setProperty("display", "none", "important");
        if (tablaContenedor) tablaContenedor.style.display = "block";
    }
});


// GESTIONAR STOCK
document.addEventListener("click", (e) => {
    if (e.target && e.target.classList.contains("btn-stock")) {
        const idProducto = e.target.getAttribute("data-id");
        const modal = document.getElementById("modalEdicion");
        const tablaContenedor = document.getElementById("contenedor-tabla-productos");

        if (!modal) return;

        fetch(`./admin/datos_stock.php?id=${idProducto}`)
            .then(response => response.json())
            .then(data => {
                if (data) {
                    document.getElementById("edit-id").value = data.id;
                    document.getElementById("edit-nombre").value = data.nombre;
                    document.getElementById("edit-precio").value = data.precio;
                    document.getElementById("edit-talla").value = data.talla;
                    document.getElementById("edit-stock").value = data.stock;

                    if (tablaContenedor) tablaContenedor.style.display = "none";
                    modal.style.display = "block";
                }
            })
            .catch(err => console.error("Error al obtener datos:", err));
    }
});

// Delegación de eventos para botones dinámicos y estáticos
document.addEventListener('click', (e) => {
    
    if (e.target && (e.target.id === 'subirProducto' || e.target.id === 'agregarProducto')) {
        e.preventDefault();
        fetch('./admin/subirProductoForm.php')
            .then(r => r.text())
            .then(html => insertarDatos.innerHTML = html);
    }
});


// ANALÍTICAS
const btnAnaliticas = document.getElementById('btn-analiticas');

btnAnaliticas.addEventListener('click', (e)=> {
    e.preventDefault();
    cerrarMenuMovil();

    fetch('./admin/obtenerAnaliticas.php')
        .then(response => response.text())
        .then(html => {
            insertarDatos.innerHTML = html;
            const scripts = insertarDatos.querySelectorAll("script");
            scripts.forEach(scriptViejo => {
                const scriptNuevo = document.createElement("script");
                if (scriptViejo.src) {
                    scriptNuevo.src = scriptViejo.src;
                } else {
                    scriptNuevo.textContent = scriptViejo.textContent;
                }
                document.body.appendChild(scriptNuevo);
                document.body.removeChild(scriptNuevo);
            });
        })
        .catch(error => console.error('Error cargando analíticas:', error));
});


// GESTIÓN FORMULARIOS SECUNDARIOS
insertarDatos.addEventListener("click", (e) => {
    if (e.target && e.target.id === 'agregarProducto') {
        fetch('./admin/subirProductoForm.php')
            .then(response => response.text())
            .then(html => { insertarDatos.innerHTML = html; })
            .catch(error => console.error('Error:', error));
    }

    if (e.target && e.target.id === 'crearLiga') {
        fetch('./admin/crearLigaForm.php')
            .then(response => response.text())
            .then(html => { insertarDatos.innerHTML = html; })
            .catch(error => console.error('Error:', error));
    }

    if (e.target && e.target.id === 'crearEquipo') {
        fetch('./admin/crearEquipoForm.php')
            .then(response => response.text())
            .then(html => { insertarDatos.innerHTML = html; })
            .catch(error => console.error('Error:', error));
    }
});

insertarDatos.addEventListener("click",(e)=>{
    if(!e.target || e.target.id !== "btn-completar") return;
    e.preventDefault();

    fetch("./admin/completar_pedido.php", {
        method: "POST",
    })
    .then(response => response.text())
    .then(() => { location.reload(); })
    .catch(err => console.error("Error al actualizar:", err));
})

// MENÚ RESPONSIVO
const btnAbrirMenu = document.getElementById('btn-abrir-menu');
const overlayMenu  = document.getElementById('overlay-menu');

if (btnAbrirMenu) {
    btnAbrirMenu.addEventListener('click', () => {
        menuPanel.classList.toggle('menu-abierto');
        overlayMenu.classList.toggle('visible');
    });

    overlayMenu.addEventListener('click', () => {
        cerrarMenuMovil();
    });
}