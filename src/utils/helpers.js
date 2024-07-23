const {DateTime} = require("luxon");

function getDateTime() {
    let localDate = DateTime.now().setZone("America/Mexico_City"); 
    return localDate.toFormat("yyyy/MM/dd HH:mm:ss");
}

async function logError(values, connectLog) {
    const maxLengthMss = 200;
    let logConnection;
    let query = `INSERT INTO errorLogs VALUES(null, ?, ?, ?, ?, ?)`;
    values[3] = values[3].length > maxLengthMss ? values[3].substring(0, maxLengthMss) : values[3];
    try {
        logConnection = await connectLog();
        logConnection.execute(query, [getDateTime(), ...values]);
    } catch (err) {
        console.error("Error logging an issue in the log database: " + err);
    } finally {
        if (logConnection) await logConnection.end();
    }
}

module.exports = {getDateTime, logError};