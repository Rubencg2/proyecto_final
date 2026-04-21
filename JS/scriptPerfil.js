//Funcion para eliminar favoritos
function eliminarFavorito(boton, idProducto) {
    let formData = new FormData();
    formData.append('id_producto', idProducto);

    fetch('./anadirFavorito.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        if (data === "eliminado") {
            const tarjeta = boton.closest('.col');
            tarjeta.remove();
        }
    })
    .catch(error => console.error('Error:', error));
}


const menuOpciones = document.getElementById("menuOpciones");
const contenedor = document.getElementById("contenido");
const perfil = document.getElementById("perfil");
const pedidos = document.getElementById("pedidos");
const datos = document.getElementById("datos");
const favoritos = document.getElementById("favoritos");

menuOpciones.addEventListener("click",(e)=>{
    if(e.target && e.target.id === "perfil"){
        fetch('./panelUsuario/general.php')
            .then(response => response.text())
            .then(html => { contenedor.innerHTML = html; })
            .catch(error => console.error('Error:', error));
    }

    if(e.target && e.target.id === "pedidos"){
        console.log("Cargando pedidos...");
        fetch('./panelUsuario/obtenerPedidos.php')
            .then(response => response.text())
            .then(html => { contenedor.innerHTML = html; })
            .catch(error => console.error('Error:', error));
    }

    if(e.target && e.target.id === "datos"){
        fetch('./panelUsuario/obtenerDatos.php')
            .then(response => response.text())
            .then(html => { contenedor.innerHTML = html; })
            .catch(error => console.error('Error:', error));
    }

    if(e.target && e.target.id === "favoritos"){
        fetch('./panelUsuario/obtenerFavoritos.php')
            .then(response => response.text())
            .then(html => { contenedor.innerHTML = html; })
            .catch(error => console.error('Error:', error));
    }

    
})

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
