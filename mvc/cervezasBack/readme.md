# 🍺 Gestor de Cervezas - Backend

Este proyecto corresponde a la parte backend del sistema "Gestor de Cervezas".  
Se trata de una API desarrollada en PHP, la cual expone cinco rutas para operar con cervezas mediante peticiones POST.  

Todas las respuestas son en formato JSON, siguiendo una estructura estándar con los campos:  
`result { codigo, mensaje, object[] }`

---

## 📌 Rutas disponibles (POST)

- **cervezas/listar**  
  Retorna todas las cervezas registradas.

- **cervezas/buscar**  
  Busca una cerveza por su ID.

- **cervezas/update**  
  Actualiza los datos de una cerveza existente.

- **cervezas/delete**  
  Elimina una cerveza por ID.

- **cervezas/insertar**  
  Agrega una nueva cerveza al sistema.

---

## 🧱 Tecnologías

- PHP puro (sin frameworks)
- Arquitectura básica tipo MVC
- MySQL
- Respuestas JSON
- Front Controller

---

## ⚙️ Requisitos

- Servidor local con Apache (XAMPP, Laragon, etc.)
- PHP 7.4 o superior
- MySQL
- Habilitar CORS si se accede desde frontend externo

---

## 🗂 Estructura general

