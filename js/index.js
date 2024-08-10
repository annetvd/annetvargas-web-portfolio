import {handleResponse, resetModal, validateEmail} from "./utils.js";
import {config} from "./config.js";

const blue = document.querySelector("#blue");
const backG = document.querySelector("#backG");
const devices = document.querySelector("#devices");
const h1 = document.querySelector("#title > h1");
const p = document.querySelector("#title > p");
const title = document.querySelector("#title");
const menuA = document.querySelectorAll("#menu > a");
const menu = document.querySelector("#menu");
const nav = document.querySelector("nav");
const coverArrow = document.querySelector("#coverText > svg");
const navArrow = document.querySelector("#navbarNav > svg");
const navbarNav =  document.querySelector("#navbarNav");
const video = document.querySelector("#video");
const form = document.querySelector("#contact-form");
const modalElement = document.querySelector("#modal-dialog");
const email = document.querySelector("#email");
var volume;
const svgH = 820;
const svgX = -2;
const h1FS = 47;
const h1FSxs = 43;
const pFS = 19;
const pFSxs = 17;
const viewBox = " 2 2200 820";
const srcXxl = "images/xxl/";
const srcMd = "images/md/";
const titleW = 373;
const minTopNavMd = 410;
const heightPor = .503372 //(2015 * 100) / 4003 blue.png
let gridT = -1;
let modal;

document.addEventListener("DOMContentLoaded", () => {
    let width = window.innerWidth;
    modal = new bootstrap.Modal(modalElement);
    responsiveCover(width);
    stickyMenu(width);
    initializePlyr();
    confPlyr();
});

window.addEventListener("resize", () => {
    let width = window.innerWidth;
    responsiveCover(width);
    stickyMenu(width);
    confPlyr();
});

window.addEventListener("orientationchange", () => {
    let width = window.innerWidth;
    responsiveCover(width);
    stickyMenu(width);
    confPlyr();
});

window.addEventListener("scroll", () => {
    let width = window.innerWidth;
    stickyMenu(width);
});

document.addEventListener('fullscreenchange', (event) => {
    confPlyr();
});

document.querySelector("#modal-close-btn").addEventListener("click", () => {
    modal.hide();
});

email.addEventListener("keyup", () => {
    validateEmail(email);
});

email.addEventListener("keydown", () => {
    email.setCustomValidity('');
});

document.querySelector("#submit-button").addEventListener("click", (event) => {
    event.preventDefault();
    let modalMessage = modalElement.querySelector("p");
    resetModal(modalMessage, document.querySelectorAll(".notification-modal > svg"));

    if (form.checkValidity() == true){
        let status;
        let successIcon = "send";
        let parameters = {
            name: document.querySelector("#name").value,
            email: email.value,
            phone: document.querySelector("#phone").value,
            iAm: document.querySelector("#i-am").value,
            message: document.querySelector("#message").value
        }

        fetch(`${config.nodeServerUrl}/message`, {
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
            if (status == 200) form.reset();
        }).catch((error) => {
            handleResponse(successIcon, -1, config.networkErrorMessage, modal, modalMessage);
        });
    } else {
        form.reportValidity();
    }
});

function confPlyr(){
    let width = parseInt(getComputedStyle(video).width);
    if (width <= 795){
        volume.style.display = "none";
    } else{
        volume.style.display = "flex";
    }
}

function initializePlyr(){
    const plyr = new Plyr(video, {
        title: "Project Introduction",
        captions: {
            active: true,
        },
        markers: {
            enabled: true,
            points: [
                {
                    time: 15,
                    label: "Accounting user",
                },
                {
                    time: 234,
                    label: "Income reports",
                },
                {
                    time: 380,
                    label: "Statistician user",
                },
                {
                    time: 393,
                    label: "Certificates",
                },
                {
                    time: 523,
                    label: "Statistics reports",
                },
                {
                    time: 632,
                    label: "Auxiliary user",
                },
                {
                    time: 662,
                    label: "Packer user",
                },
                {
                    time: 695,
                    label: "Help",
                },
                {
                    time: 716,
                    label: "Administrator u",
                },
                {
                    time: 747,
                    label: "Reset password",
                },
                {
                    time: 796,
                    label: "Mobile App",
                },
                {
                    time: 844,
                    label: "App menus",
                },
                {
                    time: 858,
                    label: "Agenda",
                },
                {
                    time: 898,
                    label: "Statistics",
                },
            ],
        }
    });

    volume = document.querySelector(".plyr__volume");
}

function stickyMenu(width){
    let scrollY = window.scrollY;
    let minTopNav = 0;

    if (width >= 2100) { 
        minTopNav = width * .035;
    } else {
        if (width >= 1900) minTopNav = width * .025;
        else minTopNav = width * .0139; //19
    }
    
    //place nav
    if (width >= 1286){
        if (scrollY >= minTopNav){
            nav.style.visibility = "visible";
        } else{
            nav.style.visibility = "hidden";
        }
    } else {
        nav.style.visibility = "visible";
        //nav arrow
        if ((width < 888) && (width > 700)) {
            if (scrollY >= minTopNavMd) {
                navArrow.style.visibility = "";
                navArrow.style.position = "static";
            } else {
                navArrow.style.visibility = "hidden";
                navArrow.style.position = "absolute";
            }
        } else {
            navArrow.style.visibility = "";
            navArrow.style.position = "static";
        }
        //nav padding
        if (width < 576) {
            navbarNav.classList.add("px-0");
        } else {
            navbarNav.classList.remove("px-0");
        }
    }
}

function resizeSetup(width){
    let height = parseInt(width * heightPor);
    document.body.style.setProperty("--actual-width", width + "px");

    if(width >= 888){
        title.style.left = parseInt(width * .069) + "px";
        //fontSize
        if (parseInt(width * .036) >= h1FS){
            h1.style.fontSize = parseInt(width * .036) + "px";
            p.style.fontSize = parseInt(width * .0155) + "px";
        } else{
            h1.style.fontSize = h1FS + "px";
            p.style.fontSize = pFS + "px";
        }
        //devices
        if (width < 1286) {
            title.style.top = parseInt(height * .189) + "px";
            devices.style.width = parseInt(width - ((width * .15) + titleW)) + "px";
        } else {
            title.style.top = parseInt(height * .21) + "px";
        }
        devices.style.right = parseInt(height * .075) + "px";
    } else{
        title.style.left = "0px";
        title.style.top = "0px";
        //fontSize
        if (parseInt(width * .06) >= h1FS){
            h1.style.fontSize = parseInt(width * .06) + "px";
            p.style.fontSize = parseInt(width * .025) + "px";
        } else {
            if (width <= 575){
                h1.style.fontSize = h1FSxs + "px";
                p.style.fontSize = pFSxs + "px";
            } else {
                h1.style.fontSize = h1FS + "px";
                p.style.fontSize = pFS + "px";
            }
        }
        //arrow
        if (width >= 700) {
            let prop = width - parseInt(getComputedStyle(title).width);
            coverArrow.style.height = parseInt(prop * .5) + "px";
            coverArrow.style.marginLeft = parseInt(prop * .03) + "px"; 
        }
    }

    if (width >= 1286) {
        devices.style.width = parseInt(width * .6) + "px";
        mainSetup(height, .252, (svgX + viewBox));
        //menu
        menuA.forEach((a) => {
            a.style.paddingInline = parseInt(width * .03) + "px";
            a.style.fontSize = parseInt(width * .013) + "px";
        });
        menu.style.marginTop = parseInt(width * .028) + "px";
    } else {
        //nav
        if (width >= 992){
            mainSetup(height, .252, calculateViewBox(height, width, 6));
        } else{
            if (width >= 888){
                mainSetup(height, .3, calculateViewBox(height, width, 5));
            }
        }
    }
}

function mainSetup (height, proportion, cut){
    devices.style.top = parseInt(height * proportion) + "px";
    backG.setAttribute("viewBox", cut);
}

function calculateViewBox(height, width, div) {
    let scale = (svgH * 100) / height;
    let x = parseInt(-(((1445 - width) / div) * (scale / 100))) + svgX;
    return x + viewBox;
}

function responsiveCover(width){
    if(width >= 888){
        if(gridT != 0){
            printGridT(srcXxl);
            gridT = 0;
        }
    } else{
        if(gridT != 1){
            printGridT(srcMd);
            gridT = 1;
        }
    }
    resizeSetup(width);
}

function printGridT(src){
    devices.src = src + "devices.png";
    blue.src = src + "blue.png";
    video.setAttribute("data-poster", src + "poster.png");
}