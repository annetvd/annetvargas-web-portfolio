const mysql = require("mysql2/promise");
require("dotenv").config();

//awococado
async function connectAw() {
    let connection;
    try {
        connection = await mysql.createConnection({
            host: process.env.DB_HOST,
            // port: process.env.DB_PORT,
            user: process.env.DBA_USER,
            password: process.env.DBA_PASS,
            database: process.env.DB_AWOCOCADO
        });
        
        return connection;
    } catch (error) {
        if (error.code === undefined){
            error.code = "ERROR_CONNECTING_AW_DB";
            error.cause = "Error connecting Awococado database";
        }
        throw error;
    }
}

//log
async function connectLog() {
    let connection;
    try {
        connection = await mysql.createConnection({
            host: process.env.DB_HOST,
            // port: process.env.DB_PORT,
            user: process.env.DBL_USER,
            password: process.env.DBL_PASS,
            database: process.env.DB_LOG
        });

        return connection;
    } catch (error) {
        if (connection) await connection.end();
        console.error("Error connecting to the log database: ", error.message);
    }
}

module.exports = {connectLog, connectAw};