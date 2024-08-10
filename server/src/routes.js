const express = require("express");
const router = express.Router();
const messageContr = require("./controllers/messageController");

router.post("/message", async (req, res) => {
  const data = req.body;

  try {
    let result = await messageContr.logMessage(data);
    let failureMsg = "Sorry, your message couldn't be sent. Please try again later.";

    if (result.success == true){
      //I pass the connection to sendMessage(), and then I commit there if both logMessage() and sendMessage() have been completed successfully.
      let resultEmail = await messageContr.sendMessage(data, result.data);
      if (resultEmail.success == true){
        console.log("Message sent and inserted successfully");
        return res.status(200).send("Your message has been successfully sent. Thank you for reaching out.");
      } else {
        console.error(`${resultEmail.message}: ${resultEmail.data}`);
        return res.status(500).send(failureMsg);
      }
    } else {
      console.error(`${result.message}: ${result.data}`);
      return res.status(500).send(failureMsg);
    }
  } catch (error) {
    next(error);
  }
});

module.exports = router;