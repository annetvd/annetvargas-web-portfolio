const express = require("express");
const router = express.Router();
const messageContr = require("./controllers/messageController");
const resetUserContr = require("./controllers/resetUserController");

router.post("/message", async (req, res, next) => {
  const data = req.body;

  try {
    let result = await messageContr.logMessage(data);

    if (result.success == true){
      //I pass the connection to sendMessage(), and then I commit there if both logMessage() and sendMessage() have been completed successfully.
      let resultEmail = await messageContr.sendMessage(data, result.data);
      if (resultEmail.success == true){
        console.log("Message sent and inserted successfully");
        return res.status(200).send("Your message has been successfully sent. Thank you for reaching out.");
      } else {
        console.error(`${resultEmail.message}: ${resultEmail.data}`);
        return res.status(500).send("Sorry, your message couldn't be sent. Please try again later.");
      }
    } else {
      console.error(`${result.message}: ${result.data}`);
      return res.status(500).send("Sorry, your message couldn't be sent. Please try again later.");
    }
  } catch (error) {
    next(error);
  }
});

router.post("/reset-packer-access", async (req, res, next) => {
  const data = req.body;
  
  try {
    let result = await resetUserContr.resetPackerUser(data);
    if(result.success == true) {
      console.log(result.message);
      return res.status(200).send("The packer user's access has been reset successfully.");
    } else {
      console.error(`${result.message}: ${result.data}`);
      if(result.message == "User not found") {
        result = await resetUserContr.resetDbAwococado();
        if (result.success == false){
          console.error(`${result.message}: ${result.data}`);
          return res.status(500).send("An error occurred while resetting the packer user. Please try again later.");
        } else{
          console.log(result.message);
          return res.status(200).send("The packer user's access has been reset successfully.");
        }
      } else {
        return res.status(500).send("An error occurred while resetting the packer user. Please try again later.");
      }
    }
  } catch(error) {
    next(error);
  }
});

module.exports = router;