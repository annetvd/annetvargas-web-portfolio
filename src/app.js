const express = require("express");
const routes = require("./routes");

const app = express();
const port = 3000;

app.use(function(req, res, next) {
    res.setHeader("Access-Control-Allow-Origin", "http://localhost");
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
    if (err instanceof validationResult) {
        console.error("Validation error:", err);
        return res.status(422).json({ error: err.array() });
    }
    next(err);
});

app.use(function(err, req, res, next) {
    if (err.code === "ETIMEDOUT") {
        console.error("Request timeout:", err);
        return res.status(408).send("Your request couldn't be sent to the server. Please check your internet connection and try again.");
    }
    next(err);
});

app.use(function(err, req, res, next) {
    if (err.timeout) {
        console.error("Gateway timeout:", err);
        return res.status(504).send("The server took too long to respond. Please try again later.");
    }
    next(err);
});

app.use(function(err, req, res, next) {
    if (res.statusCode === 500){
        console.error("Unhandled error:", err);
        res.status(500).send("A server error has occurred. Please try again later.");
    }
    next(err);
});

app.listen(port, () => {
    console.log(`Server listening on http://localhost:${port}`);
});