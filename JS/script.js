const paginaActual = window.location.pathname;


//Funcion para añadir favoritos
function gestionarFavorito(idProducto) {
    let formData = new FormData();
    formData.append('id_producto', idProducto);

    fetch('anadirFavorito.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === "error_login") {
            alert("Debes iniciar sesión para añadir favoritos");
        } else {
            let vacio = document.getElementById('corazon-vacio');
            let lleno = document.getElementById('corazon-lleno');

            if (data === "añadido") {
                vacio.style.display = 'none';
                lleno.style.display = 'block';
            } else if (data === "eliminado") {
                vacio.style.display = 'block';
                lleno.style.display = 'none';
            }
        }
    })
    .catch(error => console.error('Error:', error));
}; 


// Definimos los IDs que queremos controlar
const ids = ["logo-Movil", "img-login", "img-pagUsu", "img-carrito"];

// DETECTAR CUANDO EL USUARIO HACE SCROLL
window.addEventListener('scroll', function() {

    if(paginaActual.includes("paginaUsuario.php")){

    } else {
        ids.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                if (window.scrollY > 100) {
                    el.style.setProperty('display', 'inline-block', 'important');
                } else {
                    el.style.setProperty('display', 'none', 'important');
                }
            }
        });
    }
    
});

//DETECTAR PAGINA PERFIL USUARIO


if (paginaActual.includes("paginaUsuario.php")) {
    ids.forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            el.classList.add("ver");
        }
    });
}

// Evento para cambiar los productos segun los filtros sin recargar la pagina
document.addEventListener('DOMContentLoaded', () => {
    const contenedor = document.getElementById('contenedorProductos');


    const selectLiga = document.getElementById('ligasR');
    const selectEquipo = document.getElementById('equiposR');
    const selectTalla = document.getElementById('tallasR');

    function filtrarResponsivo() {
        contenedor.innerHTML = `
            <div class="d-flex justify-content-center my-5">
                <div class="spinner-border text-info" role="status">
                    <span class="visually-hidden">Cargando...</span>
                </div>
            </div>
        `;

        const datosParaEnviarR = new FormData();

        if (selectLiga) {
            datosParaEnviarR.append('filtroR-ligas', selectLiga.value);
        }

        if (selectEquipo) {
            datosParaEnviarR.append('filtroR-equipos', selectEquipo.value);
        }

        
        if (selectTalla) {
            datosParaEnviarR.append('filtroR-tallas', selectTalla.value);
        }

        datosParaEnviarR.append('id_categoria', document.getElementById('id_categoria')?.value || '');

        fetch('obtenerProductos.php', {
            method: 'POST',
            body: datosParaEnviarR
        })
        .then(res => res.text())
        .then(html => {
            contenedor.innerHTML = html;
        })
        .catch(err => console.error("Error al filtrar:", err));
    }

    if (selectLiga) selectLiga.addEventListener('change', filtrarResponsivo);
    if (selectEquipo) selectEquipo.addEventListener('change', filtrarResponsivo);
    if (selectTalla) selectTalla.addEventListener('change', filtrarResponsivo);
});




// Codigo para actualizar cantidad en carrito
document.addEventListener('DOMContentLoaded', () => {
    document.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('btn-qty')) {
            e.preventDefault();

            const boton = e.target;
            const id = boton.getAttribute('data-id');
            const accion = boton.getAttribute('data-accion');

            fetch(`actualizarCantidad.php?id=${id}&accion=${accion}`)
                .then(response => {
                    if (!response.ok) throw new Error('Error en la red');
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'success') {
                        const pError = document.getElementById("error");
                        const btnProcesar = document.getElementById("btn-procesar");

                        if (data.hayStock === 0) {
                            pError.innerHTML = 'No hay stock disponible';
                            if (btnProcesar) {
                                btnProcesar.disabled = true;
                                btnProcesar.style.opacity = "0.5"; 
                                btnProcesar.style.cursor = "not-allowed";
                            }
                        } else {
                            pError.innerHTML = '';
                            if (btnProcesar) {
                                btnProcesar.disabled = false;
                                btnProcesar.style.opacity = "1";
                                btnProcesar.style.cursor = "pointer";
                            }
                        }

                        // Actualizamos el input de cantidad
                        const inputCant = document.getElementById(`cant-${id}`);
                        if (inputCant) inputCant.value = data.nuevaCantidad;

                        // Actualizamos los totales del resumen
                        const resumenTotal = document.getElementById('resumen-total');
                        const resumenFinal = document.getElementById('resumen-final');
                        const envioDiv = document.getElementById('envio');

                        if (resumenTotal) resumenTotal.innerHTML = data.totalCesta;
                        if(data.totalCesta<100){
                            if (envioDiv) envioDiv.style.display = '';
                            if (resumenFinal) resumenFinal.innerHTML = data.totalConEnvio;
                        } else {
                            if (envioDiv) envioDiv.style.display = 'none';
                            if (resumenFinal) resumenFinal.innerHTML = data.totalSinEnvio;
                        }
                        
                
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    });
});





// BARRA DE BUSQUEDA
document.addEventListener('DOMContentLoaded', () => {
    let btnLupa = document.getElementById('busqueda');
    let formulario = document.getElementById('buscador-formulario');

    if (btnLupa && formulario) {
        btnLupa.addEventListener('click', (e) => {
            e.preventDefault();
            formulario.classList.toggle('activo');
            if(formulario.classList.contains('activo')){
                formulario.querySelector('input').focus();
            }
        });

        document.addEventListener('click', (e) => {
            if (!formulario.contains(e.target) && !btnLupa.contains(e.target)) {
                formulario.classList.remove('activo');
            }
        });
    }
});


//FILTRO PARA EL PRECIO
const rango = document.getElementById('rango');
const burbuja = document.getElementById('burbuja');
const contenedor = document.getElementById('contenedorProductos');

function actualizarFiltrosYPrecio() {
    // 1. Actualizar la burbuja visualmente
    const val = rango.value;
    const min = rango.min || 0;
    const max = rango.max || 100;
    const porcentaje = Number(((val - min) * 100) / (max - min));
    
    burbuja.innerHTML = `${val}€`;
    burbuja.style.left = `calc(${porcentaje}% + (${8 - porcentaje * 0.15}px))`;

    // 2. Mostrar Spinner de carga
    contenedor.innerHTML = `
        <div class="d-flex justify-content-center my-5">
            <div class="spinner-border text-info" role="status"></div>
        </div>
    `;

    // 3. Recopilar TODOS los filtros activos
    const datosParaEnviar = new FormData();
    
    // Filtro de Liga
    const ligaActiva = document.querySelector('input[name="filtro_liga"]:checked');
    if (ligaActiva) datosParaEnviar.append('filtro_liga', ligaActiva.value);

    // Filtro de Equipo
    const equipoActivo = document.querySelector('input[name="filtro_equipo"]:checked');
    if (equipoActivo) datosParaEnviar.append('filtro_equipo', equipoActivo.value);

    // Filtro de Tallas
    const tallaActiva = document.querySelector('input[name="filtro_tallas"]:checked');
    if (tallaActiva) datosParaEnviar.append('filtro_tallas', tallaActiva.value);

    // Filtro de Precio (AQUÍ ENVIAMOS EL VALOR DEL RANGO)
    datosParaEnviar.append('rango', val);

    datosParaEnviar.append('id_categoria', document.getElementById('id_categoria')?.value || '');

    // 4. Enviar al servidor
    fetch('obtenerProductos.php', {
        method: 'POST',
        body: datosParaEnviar
    })
    .then(res => res.text())
    .then(html => {
        contenedor.innerHTML = html;
    })
    .catch(err => console.error("Error al filtrar:", err));
}

if (rango) {
    rango.addEventListener('change', actualizarFiltrosYPrecio);
}

// También debemos actualizar los otros filtros para que incluyan el precio
document.querySelectorAll('.filtro').forEach(input => {
    input.addEventListener('change', actualizarFiltrosYPrecio);
});

// Inicializar burbuja al cargar
if(document.getElementById('id_categoria')) {
    actualizarFiltrosYPrecio();
}





// MENU HAMBURGUESA
const menu = document.querySelector('.hamburguesa');


if (menu) {
    const hamburguesa = document.querySelector('.img-hamburguesa');
    const cerrar = document.querySelector('.img-cerrar');
    const nav = document.querySelector('nav');
    const body = document.body;

    menu.addEventListener("click",()=>{

        nav.classList.toggle('abierto');
        body.classList.toggle('bloquear-scroll');

        if (nav.classList.contains('abierto')) {
            hamburguesa.style.display = "none";
            cerrar.style.display = "block";
        } else {
            hamburguesa.style.display = "block";
            cerrar.style.display = "none";
        }  
    });
}










