const db = require('../config/db');

const Cliente = {
  async getAll() {
    const [rows] = await db.query('SELECT * FROM clientes');
    return rows;
  },

  async getById(jsonBody) {
    const [rows] = await db.query('SELECT * FROM clientes WHERE id = ?', [jsonBody.id]);
    if (rows.length === 0) throw new Error('Cliente no encontrado');
    return rows[0];
  },

  async create(jsonBody) {
    const [result] = await db.query(
      'INSERT INTO clientes (nombre_comercial, rut, direccion, categoria, contacto_nombre, contacto_email, descuento) VALUES (?, ?, ?, ?, ?, ?, ?)',
      [
        jsonBody.nombre_comercial,
        jsonBody.rut,
        jsonBody.direccion,
        jsonBody.categoria,
        jsonBody.contacto_nombre,
        jsonBody.contacto_email,
        jsonBody.descuento || 0
      ]
    );
    if (result.affectedRows === 0) throw new Error('Error al crear el cliente');
    return result.insertId;
  },

  async update(jsonBody) {
    await db.query(
      'UPDATE clientes SET nombre_comercial = ?, rut = ?, direccion = ?, categoria = ?, contacto_nombre = ?, contacto_email = ?, descuento = ? WHERE id = ?',
      [
        jsonBody.nombre_comercial,
        jsonBody.rut,
        jsonBody.direccion,
        jsonBody.categoria,
        jsonBody.contacto_nombre,
        jsonBody.contacto_email,
        jsonBody.descuento || 0,
        jsonBody.id
      ]
    );
  },

  async delete(jsonBody) {
    const [rows] = await db.query('SELECT COUNT(*) AS total FROM camisetas WHERE cliente_id = ?', [jsonBody.id]);
    if (rows[0].total > 0) throw new Error('No se puede eliminar cliente con camisetas asociadas');
    await db.query('DELETE FROM clientes WHERE id = ?', [jsonBody.id]);
  }
};

module.exports = Cliente;