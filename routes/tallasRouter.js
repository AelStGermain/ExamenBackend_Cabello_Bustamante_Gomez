const express = require('express');
const router = express.Router();
const controller = require('../controllers/tallasController');

router.get('/', controller.getAll);
router.get('/:id', controller.getById);
router.post('/', controller.create);
router.put('/:id', controller.update);
router.delete('/:id', controller.delete);

// Asociar tallas a camisetas (relación muchos a muchos)
router.post('/asociar', controller.asociarTallaACamiseta);
router.get('/camiseta/:camisetaId', controller.obtenerTallasDeCamiseta);

module.exports = router;