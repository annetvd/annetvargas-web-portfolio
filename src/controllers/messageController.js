const helpers = require("../utils/helpers");
const emailUtil = require("../utils/emailUtil");
const {connectLog} = require("../config/db");
const config = require("../config/config");

async function logMessage(data){
    let logConnection, query, values;

    try {
      try {
        //open connection
        logConnection = await connectLog();
        await logConnection.connect();
      } catch(error) {
        if (error.cause === undefined) error.cause = "Error connecting Awococado database";
        values = ["Contact", data.name, error.cause, error.message];
        helpers.logError(values, connectLog);
        return {success: false, message: error.cause, data: error.message};
      }
      
      //begin transaction
      logConnection.beginTransaction();
      query = `INSERT INTO messages VALUES(null,?, ?, ?, ?, ?, ?)`;
      values = [helpers.getDateTime(), data.name, data.email, data.phone, data.iAm, data.message];

      logConnection.execute(query, values, (err, result) => {
        if (error) {
          //rollback
          logConnection.rollback();
          throw error;
        }
      });

      return {success: true, message: "Message insertion completed. Commit pending", data: logConnection};
      //If sendMessage() is completed successfully, the connection will be closed there.
    } catch(error) {
      error.cause = "Error logging the message in the database";
      values = ["Contact", data.name, error.cause, error.message];
      helpers.logError(values, connectLog);
      if (logConnection) await logConnection.end();
      return {success: false, message: error.cause, data: error.message};
    }
}

async function sendMessage(data, logConnection){
  let message = `
    <p>Name: ${data.name}</p>
    <p>E-mail: ${data.email}</p>
    <p>Phone: ${data.phone}</p>
    <p>I'm: ${data.iAm}</p>
    <br/>
    <p>Message: ${data.message}</p>`;

  let mailOptions = {
    from: `"${data.name}" <${config.systemEmail}>`,
    to: `"Annet" <${config.systemEmail}>`,
    subject: "Web portfolio",
    html: message
  };
  
  let result = await emailUtil.sendEmail(mailOptions);
  try {
    if(result.success == true){
      //commit
      logConnection.commit();
    } else {
      //rollback
      logConnection.rollback();
    }
    return result;
  } catch(error) {
    error.cause = "An error has occurred during the commit";
    values = ["Contact", data.name, error.cause, error.message];
    helpers.logError(values, connectLog);
    return {success: false, message: error.cause, data: error.message};
  } finally {
    if(logConnection) await logConnection.end();
  }
}

module.exports = {logMessage, sendMessage};