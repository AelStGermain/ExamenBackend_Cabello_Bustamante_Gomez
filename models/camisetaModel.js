const db = require('../config/db');

const Camiseta = {
  async getAll() {
    const [rows] = await db.query('SELECT * FROM camisetas');
    return rows;
  },

  async getById(jsonBody) {
    const [rows] = await db.query('SELECT * FROM camisetas WHERE id = ?', [jsonBody.id]);
    if (rows.length === 0) throw new Error('Camiseta no encontrada');
    return rows[0];
  },

  async create(jsonBody) {
    const [result] = await db.query(
      'INSERT INTO camisetas (titulo, club, pais, tipo, color, precio, precio_oferta, detalles, codigo_producto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)',
      [
        jsonBody.titulo,
        jsonBody.club,
        jsonBody.pais,
        jsonBody.tipo,
        jsonBody.color,
        jsonBody.precio,
        jsonBody.precio_oferta || null,
        jsonBody.detalles,
        jsonBody.codigo_producto
      ]
    );
    if (result.affectedRows === 0) throw new Error('Error al crear la camiseta');
    return result.insertId;
  },

  async update(jsonBody) {
    await db.query(
      'UPDATE camisetas SET titulo = ?, club = ?, pais = ?, tipo = ?, color = ?, precio = ?, precio_oferta = ?, detalles = ?, codigo_producto = ? WHERE id = ?',
      [
        jsonBody.titulo,
        jsonBody.club,
        jsonBody.pais,
        jsonBody.tipo,
        jsonBody.color,
        jsonBody.precio,
        jsonBody.precio_oferta || null,
        jsonBody.detalles,
        jsonBody.codigo_producto,
        jsonBody.id
      ]
    );
  },

  async delete(jsonBody) {
    await db.query('DELETE FROM camisetas WHERE id = ?', [jsonBody.id]);
  }
};

module.exports = Camiseta;