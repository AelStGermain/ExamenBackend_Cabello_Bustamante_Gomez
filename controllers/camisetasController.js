const Camiseta = require('../models/camisetaModel');
const Cliente = require('../models/clienteModel');

exports.getAll = async (req, res) => {
  try {
    const camisetas = await Camiseta.getAll();
    res.status(200).json(camisetas);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

exports.getById = async (req, res) => {
  try {
    const camiseta = await Camiseta.getById(req.params.id);
    if (!camiseta) return res.status(404).json({ error: 'Camiseta no encontrada' });

    if (req.query.cliente_id) {
      const cliente = await Cliente.getById(req.query.cliente_id);
      if (cliente && cliente.categoria === 'Preferencial' && camiseta.precio_oferta) {
        camiseta.precio_final = camiseta.precio_oferta;
      } else {
        camiseta.precio_final = camiseta.precio;
      }
    }

    res.status(200).json(camiseta);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

exports.create = async (req, res) => {
  try {
    const id = await Camiseta.create(req.body);
    res.status(201).json({ id });
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
};

exports.update = async (req, res) => {
  try {
    const updated = await Camiseta.update(req.params.id, req.body);
    if (!updated) return res.status(404).json({ error: 'Camiseta no encontrada' });
    res.status(200).json({ message: 'Camiseta actualizada correctamente' });
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
};

exports.delete = async (req, res) => {
  try {
    const deleted = await Camiseta.delete(req.params.id);
    if (!deleted) return res.status(404).json({ error: 'Camiseta no encontrada' });
    res.status(200).json({ message: 'Camiseta eliminada' });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
