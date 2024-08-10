import {config} from "./config.js"; 
import {resetModal, handleResponse} from "./utils.js";

const srcXxl = "images/xxl/";
const srcMd = "images/md/";
const usersBtn = document.querySelector(".btn-users");
const resetBtn = document.querySelector(".reset-btn");
const reserve = document.querySelector("#reserve");
const reserveLi = document.querySelector("#reserve > li");
const collapse = document.querySelector("#collapse");
const laptop = document.querySelector("#laptop");
const modalElement = document.querySelector("#modal-dialog");
let usersBtnWidth = -1;
let reserveLiHeight = -1;
let modal;

document.addEventListener("DOMContentLoaded", () => {
    let width = window.innerWidth;
    modal = new bootstrap.Modal(modalElement);
    printImg(width);
    setWidth(width);
    setPackerLiCss();
});

window.addEventListener("resize", () => {
    let width = window.innerWidth;
    printImg(width);
    setWidth(width);
    setPackerLiCss();
});

window.addEventListener("orientationchange", () => {
    let width = window.innerWidth;
    printImg(width);
    setWidth(width);
    setPackerLiCss();
});

document.querySelector(".reset-btn").addEventListener("click", (event) => {
    let modalMessage = modalElement.querySelector("p");
    let status;
    let successIcon = "success";
    let parameters = {
        user: event.target.getAttribute("data-user"),
        password: event.target.getAttribute("data-password"),
        userId: event.target.getAttribute("data-user-id")
    }
    // si funciona, modificar index.js
    resetModal(modalMessage, modalElement.querySelectorAll("svg"));

    fetch(`${config.nodeServerUrl}/reset-packer-user`, {
        method: "POST",
        headers: {
            "Content-Type": "application/json" 
        },
        body: JSON.stringify(parameters),
        credentials: "include"
    }).then((response) => {
        status = response.status;
        return response.text();
    }).then((text) => {
        handleResponse(successIcon, status, text, modal, modalMessage);
    }).catch((error) => {
        handleResponse(successIcon, -1, config.networkErrorMessage, modal, modalMessage);
    });
});

window.onload = () => {
    setPackerLiCss();
};

function setPackerLiCss() {
    resizeOReset();
    resizeOReserveLi();
}

function resizeOReset() {
    let newUsersBtnWidth = parseInt(getComputedStyle(usersBtn).width);
    if (newUsersBtnWidth != usersBtnWidth){
        resetBtn.style.maxWidth = newUsersBtnWidth + "px";
        usersBtnWidth = newUsersBtnWidth;
    }
}

function resizeOReserveLi() {
    let newReserveLiHeight = parseInt(getComputedStyle(reserveLi).height);
    if (newReserveLiHeight != reserveLiHeight){
        if (getComputedStyle(reserveLi).position != "absolute") {
            reserve.style.minHeight = "280px";
        } else {
            if (getComputedStyle(collapse).display != "none") {
                reserve.style.minHeight = "calc(" + (newReserveLiHeight - parseInt(getComputedStyle(collapse).height)) + "px + " + getComputedStyle(resetBtn).marginBottom + " - .1em)";
            } else {
                reserve.style.minHeight = newReserveLiHeight + "px";
            }
        }

        reserveLiHeight = newReserveLiHeight;
    }
}

function printImg(width){
    if(width >= 888){
        laptop.src = srcXxl + "laptop.png";
    } else{
        laptop.src = srcMd + "devices.png";
    }
}

function setWidth(width) {
    document.body.style.setProperty("--width", width + "px");
}

function redirectToLoginPage(user, password){
    document.querySelector("#user").value = user;
    document.querySelector("#password").value = password;
    document.querySelector("#set-login-user").submit();
}