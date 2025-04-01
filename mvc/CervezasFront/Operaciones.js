const apiUrl = 'http://localhost/cervezasBack/public/cervezas';

document.addEventListener('DOMContentLoaded', listarCervezas);
document.getElementById('formCerveza').addEventListener('submit', guardarCerveza);

function listarCervezas() {
  fetch(`${apiUrl}/listar`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' }
  })
  .then(res => res.json())
  .then(data => {
    const tbody = document.getElementById('tablaCervezas');
    tbody.innerHTML = '';
    (data.result.object || []).forEach(
        cerveza => {
      const tr = document.createElement('tr');
      tr.innerHTML = `
        <td>${cerveza.id}</td>
        <td>${cerveza.nombre}</td>
        <td>${cerveza.marca}</td>
        <td>${cerveza.ml}</td>
        <td>
          <button class="btn btn-success btn-sm" onclick="editarCerveza(${cerveza.id})">Modificar</button>
          <button class="btn btn-danger btn-sm" onclick="eliminarCerveza(${cerveza.id})">Eliminar</button>
        </td>`;
      tbody.appendChild(tr);
    });
  });
}

function guardarCerveza(e) {
  e.preventDefault();
  const id = document.getElementById('id').value;
  const nombre = document.getElementById('nombre').value;
  const marca = document.getElementById('marca').value;
  const ml = document.getElementById('ml').value;

  const datos = { id, nombre, marca, ml };

  const url = id ? `${apiUrl}/update` : `${apiUrl}/crear`;

  fetch(url, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(datos)
  })
  .then(res => res.json())
  .then(() => {
    resetForm();
    listarCervezas();
  });
}

function editarCerveza(id) {
  fetch(`${apiUrl}/buscar`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id })
  })
  .then(res => res.json())
  .then(data => {
    const cerveza = data.result.object[0];
    document.getElementById('id').value = cerveza.id;
    document.getElementById('nombre').value = cerveza.nombre;
    document.getElementById('marca').value = cerveza.marca;
    document.getElementById('ml').value = cerveza.ml;
  });
}

function eliminarCerveza(id) {
  if (!confirm('¿Deseas eliminar esta cerveza?')) return;

  fetch(`${apiUrl}/eliminar`, {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ id })
  })
  .then(res => res.json())
  .then(() => listarCervezas());
}

function resetForm() {
  document.getElementById('formCerveza').reset();
  document.getElementById('id').value = '';
}

function guardarCerveza(e) {
    e.preventDefault(); // Evita que se recargue el formulario
  
    const id = document.getElementById('id').value;
    const nombre = document.getElementById('nombre').value;
    const marca = document.getElementById('marca').value;
    const ml = document.getElementById('ml').value;
  
    const datos = { nombre, marca, ml };
    if (id) datos.id = id;
  
    const url = id 
      ? `${apiUrl}/update`    // Si hay ID, se actualiza
      : `${apiUrl}/agregar`;    // Si no hay ID, se inserta
  
    fetch(url, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(datos)
    })
    .then(res => res.json())
    .then(data => {
      if (data.result.codigo === 200 || data.result.codigo === 201) {
        resetForm();
        listarCervezas();
      } else {
        alert(data.result.mensaje || "Error al guardar");
      }
    })
    .catch(err => console.error('Error al guardar:', err));
  }
  


window.onload = function() {
    listarCervezas();
  };