const srcXxl = "../Imagenes/start/xxl/";
const srcMd = "../Imagenes/start/md/";
const usersBtn = document.querySelector(".btn-users");
const resetBtn = document.querySelector(".reset-btn");
const reserve = document.querySelector("#reserve");
const reserveLi = document.querySelector("#reserve > li");
const collapse = document.querySelector("#collapse");
const laptop = document.querySelector("#laptop");
const body = document.body;
let usersBtnWidth = -1;
let reserveLiHeight = -1;

document.addEventListener("DOMContentLoaded", () => {
    let width = window.innerWidth;
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

window.onload = () => {
    setPackerLiCss();
};

// document.addEventListener("click", () => {
//     alert(window.innerWidth);
// });

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
    body.style.setProperty("--width", width + "px");
}