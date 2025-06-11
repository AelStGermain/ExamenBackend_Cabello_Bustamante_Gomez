const express = require('express');
const bodyParser = require('body-parser');
const dotenv = require('dotenv');

// Cargar variables de entorno
dotenv.config();

const app = express();

// Middleware para parsear JSON
app.use(bodyParser.json());

// Middleware para registrar solicitudes entrantes
app.use((req, res, next) => {
  console.log(`[${new Date().toISOString()}] ${req.method} ${req.url}`);
  res.setHeader('Content-Type', 'application/json');
  next();
});

// Rutas por entidad (según estructura MVC del examen)
const camisetasRoutes = require('./routes/camisetasRoutes');
const clientesRoutes = require('./routes/clientesRoutes');
// Si agregas tallas:
// const tallasRoutes = require('./routes/tallasRoutes');

// Configurar las rutas base
app.use('/api/camisetas', camisetasRoutes);
app.use('/api/clientes', clientesRoutes);
// app.use('/api/tallas', tallasRoutes);

// Ruta no encontrada
app.use((req, res, next) => {
  res.status(404).json({ error: 'Ruta no encontrada' });
});

// Manejo de errores generales
app.use((err, req, res, next) => {
  console.error('Error:', err.message);
  res.status(500).json({ error: 'Error interno del servidor' });
});

// Iniciar servidor
const PORT = process.env.PORT || 3000;
app.listen(PORT, () => {
  console.log(`Servidor corriendo en puerto ${PORT}`);
});
