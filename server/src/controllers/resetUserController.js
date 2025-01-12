const helpers = require("../utils/helpers");
const {connectAw, connectLog} = require("../config/db");
const config = require("../config/config");
const fetch = (...args) => import("node-fetch").then(({default: fetch}) => fetch(...args));

async function resetPackerUser(data){
    let awConnection, query, values;

    try {
        awConnection = await connectAw();
        let [rows] = await awConnection.execute("SELECT 1 FROM usuarios WHERE IdUsuario=?", [data.userId]);
        if (rows.length > 0){
            query = "UPDATE usuarios SET Correo=?, Contrasena=MD5(?) WHERE IdUsuario=?";
            values = [data.email, data.password, data.userId];
            await awConnection.execute(query, values);
            return {success: true, message: "The packer user's access has been reset successfully"};
        } else {
            values = ["Instructions", "", "User not found", `The packer user with IdUser ${data.userId} couldn't be found during the user reset task in the demo awococado web application.`];
            helpers.logError(values, connectLog);
            return {success: false, message: values[2], data: `the packer user with ID ${data.userId} does not exist`};
        }
    } catch(error) {
        error.cause = "Failed to update the packer user's access";
        values = ["Instructions", "", error.cause, error.message];
        helpers.logError(values, connectLog);
        return {success: false, message: error.cause, data: error.message};
    } finally {
        if (awConnection) await awConnection.end();
    }
}

async function resetDbAwococado(){
    let parameters, response;
    try {
        parameters = {
            backup : "respaldo-inicial.sql"
        };

        response = await fetch(`${config.clientHostDomain}/core/server.php/restoreAwococadoDB`, {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
            body: new URLSearchParams(parameters).toString()
        });

        if (response.ok) {
            return {success: true, message: "Successful restoration of the awococado database"};
        } else {
            throw new Error("The response from the PHP server to the request was unsuccessful");
        }
    } catch (error) {
        error.cause = "Error restoring the awococado database";
        values = ["Instructions", "", error.cause, error.message];
        helpers.logError(values, connectLog);
        return {success: false, message: error.cause, data: error.message};
    }
}

module.exports = {resetPackerUser, resetDbAwococado};