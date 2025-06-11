require("dotenv").config();

const mysql = require("mysql2/promise");
const requiredEnvVars = [
  "DB_HOST",
  "DB_USER",
  "DB_PASSWORD",
];
requiredEnvVars.forEach((envVar) => {  
  if (!process.env[envVar]) {
    throw new Error(`Falta la variable de entorno: ${envVar}`);
  }
});

//crear un pool de conexiones a la base de datos.
const db = mysql.createPool({
  host: process.env.DB_HOST,
  user: process.env.DB_USER,
  password: process.env.DB_PASSWORD,
  database: process.env.DB_NAME,
  waitForConnections: true,
  connectionLimit: 10,  
  queueLimit: 0,
});

module.exports = db;
 