const express = require("express");
const routes = require("./routes");
const config = require("./config/config");

const app = express();
const port = 3000;

app.use(function(req, res, next) {
    res.setHeader("Access-Control-Allow-Origin", config.clientSideAccessAllowed);
    res.setHeader("Access-Control-Allow-Methods", "GET, POST, PUT, DELETE, OPTIONS");
    res.setHeader("Access-Control-Allow-Headers", "Content-Type, Authorization");
    res.setHeader("Access-Control-Allow-Credentials", true);
    
    if (req.method === "OPTIONS") {
        res.sendStatus(200);
    } else {
        next();
    }
});

app.use(express.json());
app.use("/", routes);

app.use(function(req, res, next) {
    console.error("Resourse not found");
    res.status(404).send("The operation couldn't be completed successfully because the requested resource wasn't found.");
});

app.use(function(err, req, res, next) {
    if (err.code === "ETIMEDOUT") {
        console.error("Request timeout:", err.message);
        return res.status(408).send("Your request couldn't be sent to the server. Please check your internet connection and try again.");
    }
    next(err);
});

app.use(function(err, req, res, next) {
    if (err.timeout) {
        console.error("Gateway timeout:", err.message);
        return res.status(504).send("The server took too long to respond. Please try again later.");
    }
    next(err);
});

app.use(function(err, req, res, next) {
    console.error("Unhandled error:", err.message);
    res.status(500).send("A server error has occurred. Please try again later.");
});

app.listen(port, () => {
    console.log(`Server listening on port ${port}`);
});