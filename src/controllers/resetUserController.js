const helpers = require("../utils/helpers");
const {connectAw, connectLog} = require("../config/db");

async function resetPackerUser(data){
    let logConnection, awConnection, query, values;

    try {
        awConnection = await connectAw();
        verifyUserRecord(data.id, awConnection);
    } catch(error) {

    } finally {
        if (awConnection) await awConnection.end();
    }
}

async function verifyUserRecord(id, awConnection) {
    try {
        let [rows] = await awConnection.execute("select 1 from usuarios where IdUsuario = ?", id);
        if (rows.length > 0) return {success: true, message: `The user with ID ${id} does exist.`};
        else return {success: false, message: `The user with ID ${id} doesn't exist.`};
    } catch(error) {
        error.cause = "An error has occurred while querying the demo packer user.";
        values = ["Instructions", "", error.cause, error.message];
        helpers.logError(values, connectLog);
        return {success: false, message: error.cause};
    }
}