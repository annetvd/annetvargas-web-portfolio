const nodemailer = require("nodemailer");
if (process.env.NODE_ENV !== 'production') {
    const path = require("path");
    require("dotenv").config({path: path.resolve(__dirname, "../config/.env")});
}

async function sendEmail(mailOptions){
    let transporter = nodemailer.createTransport({
        host: "smtp.gmail.com",
        port: 587,
        secure: false,
        auth: {
            user: process.env.EMAIL_USER,
            pass: process.env.EMAIL_PASSWORD
        }
    });

    try{
        let info = await transporter.sendMail(mailOptions);
        if (info.accepted.length == 0) return {success: false, message: "The email was rejected by the destination server", data: info.response};
        else return {success: true, message: "Email sent successfully"};
    } catch(error){
        return {success: false, message: "An error ocurred while sending the email", data: error.message};
    }
}

module.exports = {sendEmail};