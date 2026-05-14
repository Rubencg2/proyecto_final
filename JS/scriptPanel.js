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

pedidos.addEventListener("click", () => {
    cerrarMenuMovil();
    fetch('./admin/obtenerPedidos.php', { method: 'POST', body: new FormData() })
    .then(res => res.text())
    .then(html => {
        insertarDatos.innerHTML = html;

        if (document.getElementById("tablaPedidos")) {
            const table = new DataTable('#tablaPedidos', {
                responsive: true,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/2.0.8/i18n/es-ES.json'
                },
                columnDefs: [{ orderable: false, targets: [4] }],
                order: [[1, 'asc']],
                pageLength: 10
            });

            // Recalcular total con las filas filtradas
            function recalcularTotal() {
                let total = 0;
                table.column(2, { search: 'applied' }).data().each(function(valor) {
                    const num = parseFloat(valor.replace('€', '').replace(',', '.'));
                    if (!isNaN(num)) total += num;
                });
                const el = document.getElementById('total-pedidos');
                if (el) el.textContent = total.toFixed(2) + '€';
            }

            table.on('draw', recalcularTotal);
        }
    })
    .catch(err => console.error("Error:", err));
});


// EDITAR PRODUCTOS
document.addEventListener("click", (e) => {
    const esBtnEditar = e.target.classList.contains("btn-editar") && e.target.getAttribute("data-id");
    const esBtnDeshabilitar = e.target.classList.contains("btn-deshabilitar") && e.target.getAttribute("data-idD");
    const esBtnHabilitar = e.target.classList.contains("btn-habilitar") && e.target.getAttribute("data-idH");
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

    if(esBtnDeshabilitar){
        const idProducto = e.target.getAttribute("data-idD");

        fetch(`./admin/deshabilitarProducto.php?id=${idProducto}`)
        .then(
            setTimeout(() => {
                productos.click();
            }, 1000)
        )
        .catch(err => console.error("Error al deshabilitar el producto:", err));
    }

    if(esBtnHabilitar){
        const idProducto = e.target.getAttribute("data-idH");

        fetch(`./admin/habilitarProducto.php?id=${idProducto}`)
        .then(
            setTimeout(() => {
                productos.click();
            }, 1000)
        )
        .catch(err => console.error("Error al habilitar el producto:", err));
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
        .then(() => { productos.click(); })
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
    if(!e.target || !e.target.classList.contains("btn-completar")) return;
    e.preventDefault();
 
    const id_pedido = e.target.getAttribute("data-id");
    if (!id_pedido) return;
 
    const formData = new FormData();
    formData.append("id_pedido", id_pedido);
 
    fetch("./admin/completar_pedido.php", {
        method: "POST",
        body: formData,
    })
    .then(response => response.text())
    .then(() => { 
        pedidos.click();
    })
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

// =============================================
// GESTIÓN DE TALLAS Y STOCK
// =============================================

const tallasStock = document.getElementById("tallasStock");

if (tallasStock) {
    tallasStock.addEventListener("click", () => {
        cerrarMenuMovil();
        fetch('./admin/gestionTallasStock.php')
            .then(res => res.text())
            .then(html => {
                insertarDatos.innerHTML = html;

                if (document.getElementById("tablaTallas")) {
                    new DataTable('#tablaTallas', {
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
            .catch(err => console.error("Error:", err));
    });
}

// Abrir modal de tallas al hacer clic en "Gestionar Tallas"
document.addEventListener("click", (e) => {
    if (!e.target || !e.target.classList.contains("btn-gestionar-tallas")) return;

    const idProducto = e.target.getAttribute("data-id");
    if (!idProducto) return;

    const modal = document.getElementById("modalTallas");
    if (!modal) return;

    // Reset feedback
    const feedback = document.getElementById("tallas-feedback");
    if (feedback) { feedback.style.display = "none"; feedback.textContent = ""; }

    // Show loading state
    document.getElementById("tallas-loading").style.display = "block";
    document.getElementById("tallas-grid-container").innerHTML = "";
    document.getElementById("tallas-acciones").style.display = "none";
    modal.style.display = "flex";

    fetch(`./admin/getTallasProducto.php?id=${idProducto}`)
        .then(res => res.json())
        .then(data => {
            if (data.error) {
                console.error(data.error);
                return;
            }

            // Fill header
            document.getElementById("tallas-id-producto").value = data.producto.id;
            document.getElementById("tallas-nombre-producto").textContent = data.producto.nombre;
            document.getElementById("tallas-precio-producto").textContent = parseFloat(data.producto.precio).toFixed(2) + " €";
            document.getElementById("tallas-img-producto").src = data.producto.url_imagen;

            // Build talla cards
            const grid = document.getElementById("tallas-grid-container");
            grid.innerHTML = "";

            if (data.tallas.length === 0) {
                grid.innerHTML = "<p style='color:#888;grid-column:1/-1'>No hay tallas disponibles en la base de datos.</p>";
            } else {
                data.tallas.forEach(t => {
                    const card = document.createElement("div");
                    card.className = "talla-card " + (t.activa ? "activa" : "nueva");
                    card.dataset.idTalla = t.id_talla;

                    const stockVal = t.activa ? t.stock : 0;
                    const badgeNueva = !t.activa
                        ? `<span class="talla-badge-nueva">NUEVA</span>`
                        : "";

                    card.innerHTML = `
                        <div class="talla-card-top">
                            <input type="checkbox"
                                   class="talla-checkbox"
                                   data-id-talla="${t.id_talla}"
                                   ${t.activa ? "checked" : ""}>
                            <span class="talla-label">${t.talla}</span>
                            ${badgeNueva}
                        </div>
                        <div class="talla-stock-wrap">
                            <label>Stock:</label>
                            <input type="number"
                                   class="talla-stock-input"
                                   data-id-talla="${t.id_talla}"
                                   value="${stockVal}"
                                   min="0"
                                   ${t.activa ? "" : "disabled"}
                                   placeholder="0">
                        </div>
                    `;
                    grid.appendChild(card);
                });
            }

            document.getElementById("tallas-loading").style.display = "none";
            document.getElementById("tallas-acciones").style.display = "block";
        })
        .catch(err => {
            console.error("Error al cargar tallas:", err);
            document.getElementById("tallas-loading").style.display = "none";
        });
});

// Toggle checkbox: enable/disable stock input and card styles
document.addEventListener("change", (e) => {
    if (!e.target || !e.target.classList.contains("talla-checkbox")) return;

    const card       = e.target.closest(".talla-card");
    const stockInput = card.querySelector(".talla-stock-input");
    const checked    = e.target.checked;

    stockInput.disabled = !checked;

    if (checked) {
        card.classList.add("activa");
        card.classList.remove("nueva");
        card.classList.add("activando");
        if (!stockInput.value || stockInput.value === "0") stockInput.value = "0";
        stockInput.focus();
    } else {
        card.classList.remove("activa", "activando");
        card.classList.add("nueva");
        stockInput.value = "0";
    }
});

// Cerrar modal de tallas
document.addEventListener("click", (e) => {
    const modal = document.getElementById("modalTallas");
    if (!modal) return;

    if (
        e.target.id === "cerrarModalTallas" ||
        e.target.id === "btnCancelarTallas" ||
        (e.target === modal)
    ) {
        modal.style.display = "none";
    }
});

// Guardar tallas via AJAX
document.addEventListener("submit", (e) => {
    if (!e.target || e.target.id !== "formGestionTallas") return;
    e.preventDefault();

    const idProducto = document.getElementById("tallas-id-producto").value;
    const cards      = document.querySelectorAll(".talla-card");

    const tallas = Array.from(cards).map(card => {
        const checkbox   = card.querySelector(".talla-checkbox");
        const stockInput = card.querySelector(".talla-stock-input");
        return {
            id_talla: parseInt(card.dataset.idTalla),
            stock:    parseInt(stockInput.value) || 0,
            activa:   checkbox.checked
        };
    });

    const btn = document.getElementById("btnGuardarTallas");
    btn.disabled = true;
    btn.textContent = "Guardando...";

    fetch("./admin/guardarTallasStock.php", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({ id_producto: parseInt(idProducto), tallas })
    })
    .then(res => res.json())
    .then(data => {
        const feedback = document.getElementById("tallas-feedback");
        feedback.style.display = "block";
        if (data.ok) {
            feedback.className = "exito";
            feedback.textContent = data.mensaje;
            // Refresh the table after a short delay
            setTimeout(() => {
                document.getElementById("modalTallas").style.display = "none";
                if (tallasStock) tallasStock.click();
            }, 1400);
        } else {
            feedback.className = "error";
            feedback.textContent = "Error: " + data.error;
        }
    })
    .catch(err => {
        console.error("Error al guardar:", err);
        const feedback = document.getElementById("tallas-feedback");
        feedback.style.display = "block";
        feedback.className = "error";
        feedback.textContent = "Error de conexión al guardar los cambios.";
    })
    .finally(() => {
        btn.disabled = false;
        btn.textContent = "💾 Guardar Cambios";
    });
});


// =============================================
// DETALLE DE PEDIDO
// =============================================

let pedidoActivoId = null;

// Abrir modal al hacer clic en "Ver detalles"
document.addEventListener("click", (e) => {
    if (!e.target || !e.target.classList.contains("btn-ver-pedido")) return;

    const idPedido = e.target.getAttribute("data-id");
    if (!idPedido) return;

    const modal = document.getElementById("modalDetallePedido");
    if (!modal) return;

    pedidoActivoId = idPedido;

    // Reset state
    document.getElementById("detalle-lineas-container").innerHTML = "";
    document.getElementById("detalle-lineas-loading").style.display = "block";
    document.getElementById("detalle-resumen").style.display = "none";
    document.getElementById("detalle-acciones").style.display = "none";
    modal.style.display = "flex";

    fetch(`./admin/getDetallePedido.php?id=${idPedido}`)
        .then(res => res.json())
        .then(data => {
            if (data.error) { console.error(data.error); return; }

            const p = data.pedido;

            // Header
            document.getElementById("detalle-id").textContent = p.id;
            document.getElementById("detalle-fecha").textContent = "Fecha: " + p.fecha;

            const badgeEstado = document.getElementById("detalle-estado-badge");
            badgeEstado.textContent = p.estado.charAt(0).toUpperCase() + p.estado.slice(1);
            badgeEstado.className = "badge-estado badge-estado--" + p.estado;

            // User info
            const nombreCompleto = [p.nombre_usuario, p.apellidos].filter(Boolean).join(" ");
            document.getElementById("detalle-nombre-usuario").textContent = nombreCompleto || "—";
            document.getElementById("detalle-email-usuario").textContent  = p.email;

            // Line items
            const container = document.getElementById("detalle-lineas-container");
            container.innerHTML = "";

            let subtotal = 0;
            data.lineas.forEach(l => {
                subtotal += parseFloat(l.subtotal);
                const div = document.createElement("div");
                div.className = "detalle-linea";
                div.innerHTML = `
                    <img src="${l.url_imagen}" alt="${l.nombre}" onerror="this.src='./imagenes/foto_perfil.png'">
                    <div class="detalle-linea-info">
                        <div class="detalle-linea-nombre">${l.nombre}</div>
                        <div class="detalle-linea-meta">Talla: <strong>${l.talla}</strong> &nbsp;·&nbsp; Cantidad: <strong>×${l.cantidad}</strong></div>
                    </div>
                    <div class="detalle-linea-precios">
                        <div class="detalle-linea-subtotal">${parseFloat(l.subtotal).toFixed(2)} €</div>
                        <div class="detalle-linea-unitario">${parseFloat(l.precio_unitario).toFixed(2)} €/ud.</div>
                    </div>
                `;
                container.appendChild(div);
            });

            if (data.lineas.length === 0) {
                container.innerHTML = "<p style='color:#888;text-align:center;padding:20px;'>Sin productos registrados</p>";
            }

            // Totals
            document.getElementById("detalle-subtotal").textContent = subtotal.toFixed(2) + " €";
            document.getElementById("detalle-total").textContent    = parseFloat(p.total).toFixed(2) + " €";

            // Show/hide "Completar" button inside modal
            const btnCompletar = document.getElementById("btnCompletarDesdeDetalle");
            btnCompletar.style.display = p.estado !== "completado" ? "inline-block" : "none";
            btnCompletar.dataset.id = p.id;

            document.getElementById("detalle-lineas-loading").style.display = "none";
            document.getElementById("detalle-resumen").style.display = "flex";
            document.getElementById("detalle-acciones").style.display = "flex";
        })
        .catch(err => {
            console.error("Error al cargar detalle:", err);
            document.getElementById("detalle-lineas-loading").style.display = "none";
        });
});

// Completar pedido desde el modal de detalle
document.addEventListener("click", (e) => {
    if (!e.target || e.target.id !== "btnCompletarDesdeDetalle") return;

    const idPedido = e.target.dataset.id;
    if (!idPedido) return;

    const formData = new FormData();
    formData.append("id_pedido", idPedido);

    e.target.disabled = true;
    e.target.textContent = "Guardando...";

    fetch("./admin/completar_pedido.php", { method: "POST", body: formData })
        .then(() => {
            document.getElementById("modalDetallePedido").style.display = "none";
            pedidos.click(); // refresh table
        })
        .catch(err => console.error("Error:", err))
        .finally(() => {
            e.target.disabled = false;
            e.target.textContent = "✅ Marcar como Completado";
        });
});

// Cerrar modal de detalle
document.addEventListener("click", (e) => {
    const modal = document.getElementById("modalDetallePedido");
    if (!modal) return;

    if (
        e.target.id === "cerrarDetallePedido" ||
        e.target.id === "btnCerrarDetalle2"   ||
        e.target === modal
    ) {
        modal.style.display = "none";
    }
});
