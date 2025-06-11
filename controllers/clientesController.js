const Cliente = require('../models/clienteModel');

exports.getAll = async (req, res) => {
  try {
    const clientes = await Cliente.getAll();
    res.status(200).json(clientes);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

exports.getById = async (req, res) => {
  try {
    const cliente = await Cliente.getById(req.params.id);
    if (!cliente) return res.status(404).json({ error: 'Cliente no encontrado' });
    res.status(200).json(cliente);
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};

exports.create = async (req, res) => {
  try {
    const id = await Cliente.create(req.body);
    res.status(201).json({ id });
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
};

exports.update = async (req, res) => {
  try {
    const updated = await Cliente.update(req.params.id, req.body);
    if (!updated) return res.status(404).json({ error: 'Cliente no encontrado' });
    res.status(200).json({ message: 'Cliente actualizado correctamente' });
  } catch (error) {
    res.status(400).json({ error: error.message });
  }
};

exports.delete = async (req, res) => {
  try {
    const deleted = await Cliente.delete(req.params.id);
    if (!deleted) return res.status(400).json({ error: 'No se puede eliminar cliente con camisetas asociadas o no existe' });
    res.status(200).json({ message: 'Cliente eliminado' });
  } catch (error) {
    res.status(500).json({ error: error.message });
  }
};
