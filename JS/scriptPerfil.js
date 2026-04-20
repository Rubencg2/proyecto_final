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
