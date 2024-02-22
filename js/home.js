document.addEventListener('DOMContentLoaded', function() {
    home();
});


function home() {
    fetch("../proc/proc_home.php")
    .then(sapo => sapo.text())
    .then(home =>{ 
        document.getElementById('home').innerHTML = home
        addFiltros()
    })
}

function addFiltros()
{
    document.getElementById("cocina").addEventListener("change",filtro)
    document.getElementById("precio").addEventListener("change",filtro)
    document.getElementById("comida").addEventListener("keyup",filtro)
}

function filtro() {
    var filtros = {
        cocina: document.getElementById('cocina').value,
        precio:  document.getElementById('precio').value,
        comida: document.getElementById('comida').value
    }
    fetch("../proc/proc_filtro.php",{
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: 'datos=' + encodeURIComponent(JSON.stringify(filtros))
    })

    .then(contenido =>contenido.text())
    .then(texto => document.getElementById('contenido').innerHTML = texto)
}

