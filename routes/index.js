const express = require('express');
const router = express.Router();

//IMportar las rutas de los diferentes módulos
const usersRoutes = require('./users');

//Middleware para capturar rutas no manejadas en este archivo
router.use((req, res, next) => {
    console.log(`Ruta no encontrada: ${req.method} ${req.url}`);
    res.status(404).send('Ruta no encontrada');
});
module.exports = router;
//Configurar las rutas de los diferentes módulos