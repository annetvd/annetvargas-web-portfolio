<!DOCTYPE html>
<html lang="en">

<head>
    <title>Web portfolio</title>
    <meta name charset="utf-8" />
    <meta name="description" property="og:description" content="Data analysis web platform - A tool that integrates administrative control and business intelligence." />
    <meta name="author" content="Annet Vargas Dueñas" />
    <meta name="viewport" content="width=device-width" />

    <!-- content=""> -->
    <link rel="shorcut icon" href="..\Imagenes\av.ico">

    <!-- Open Graph -->
    <meta property="og:title" content="Data analysis web platform" />
    <meta property="og:site_name" content="annetvd" />
    <meta property="og:url" content="https://annetvd.000webhostapp.com" />

    <!-- Docs styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <!------------- url -----------------------------------------------------------------------------------
----------------------------------------------------------------------->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <link href="..\css\inicio.css" rel="stylesheet">
</head>

<body>
    <script>

    </script>
    <header>
        <nav>
            <div id="navContainer" class="navbar navbar-expand-sm navbar-light px-3 bg-white py-0 row-container">
                <span class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="btnNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse px-0" id="navbarNav">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="height: 50px;" alt="">
                            <path fill-rule="evenodd" d="M15.22 6.268a.75.75 0 0 1 .968-.431l5.942 2.28a.75.75 0 0 1 .431.97l-2.28 5.94a.75.75 0 1 1-1.4-.537l1.63-4.251-1.086.484a11.2 11.2 0 0 0-5.45 5.173.75.75 0 0 1-1.199.19L9 12.312l-6.22 6.22a.75.75 0 0 1-1.06-1.061l6.75-6.75a.75.75 0 0 1 1.06 0l3.606 3.606a12.695 12.695 0 0 1 5.68-4.974l1.086-.483-4.251-1.632a.75.75 0 0 1-.432-.97Z" clip-rule="evenodd" />
                        </svg>
                        <ul class="navbar-nav text-black">
                            <li><a class="dropdown-item px-4 px-sm-3" href="#more">Read more</a></li>
                            <li><a class="dropdown-item px-4 px-sm-3" href="#contact">Contact</a></li>
                            <li><a class="dropdown-item px-4 px-sm-3" href="#try">Try it</a></li>
                        </ul>
                    </div>
                </span>
            </div>
        </nav>

        <svg id="backG" class="absolute" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="-2 2 2200 820" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
            <defs>
                <!-- shadow -->
                <radialGradient id="shadow" cx="0%" cy="0%" r="100%" fx="10%" fy="10%" gradientTransform="translate(1.49, .14)">
                    <stop offset="40%" style="stop-color:rgb(140,140,140);stop-opacity:1" />
                    <stop offset="100%" style="stop-color:rgb(255,255,255);stop-opacity:1" />
                </radialGradient>
            </defs>
            <use xlink:href="..\Imagenes\start\xxl\backG.svg#Layer_1" fill="url(#shadow)" />
        </svg>
        <div class="cover row justify-content-end" id="cover">
            <!-- agregar srcset para todos menos blue porque son imagenes diferentes y no funciona con JavaScript srcset="..\Imagenes\start\md\blue.png 887w, ..\Imagenes\start\xxl\blue.png"-------------------------------------------------------------------------------
            --------------------------------------------------------------------------------------------------
            --------------------------------- -->
            <img id="blue" class="" src="" alt="" />
            <img id="devices" class="absolute" src="" alt="" />
            <span id="coverText" class="absolute">
                <div id="menu" aria-hidden="true">
                    <a href="#more">Read more</a>
                    <a href="#contact">Contact</a>
                    <a href="#try">Try it</a>
                </div>
                <span id="title">
                    <h1>Data analysis <br />web platform</h1>
                    <p>A tool that integrates administrative <br />control and business intelligence.</p>
                </span>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" alt="">
                    <path fill-rule="evenodd" d="M15.22 6.268a.75.75 0 0 1 .968-.431l5.942 2.28a.75.75 0 0 1 .431.97l-2.28 5.94a.75.75 0 1 1-1.4-.537l1.63-4.251-1.086.484a11.2 11.2 0 0 0-5.45 5.173.75.75 0 0 1-1.199.19L9 12.312l-6.22 6.22a.75.75 0 0 1-1.06-1.061l6.75-6.75a.75.75 0 0 1 1.06 0l3.606 3.606a12.695 12.695 0 0 1 5.68-4.974l1.086-.483-4.251-1.632a.75.75 0 0 1-.432-.97Z" clip-rule="evenodd" />
                </svg>
            </span>
        </div>
    </header>

    <main>
        <div style="height: 4500px;" class="container p-0">
            <div id="about" class="bg-container bg-white">
                <img id="aboutB" class="background" src="" alt="" />
                <span class="row p-0 mb-4 px-0 px-xxl-5">
                    <h2 class="text-center">About the<br class="d-sm-none" /> proyect</h2>
                    <span class="p-5 row justify-content-center gx-5 m-0 bg-content gy-5 pt-0 pt-sm-2 px-2 px-sm-5 mb-1 mb-md-3" height="">
                        <span class="col-12 col-sm-9 col-md-6 col-xl-5 container-xs px-3 px-sm-4">
                            <div class="shadow-css px-4 pt-5 pb-4 me-0 me-md-1 me-lg-2 bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon mb-1 mt-2" alt="">
                                    <path fill-rule="evenodd" d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 0 1 .75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 0 1 9.75 22.5a.75.75 0 0 1-.75-.75v-4.131A15.838 15.838 0 0 1 6.382 15H2.25a.75.75 0 0 1-.75-.75 6.75 6.75 0 0 1 7.815-6.666ZM15 6.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" clip-rule="evenodd" />
                                    <path d="M5.26 17.242a.75.75 0 1 0-.897-1.203 5.243 5.243 0 0 0-2.05 5.022.75.75 0 0 0 .625.627 5.243 5.243 0 0 0 5.022-2.051.75.75 0 1 0-1.202-.897 3.744 3.744 0 0 1-3.008 1.51c0-1.23.592-2.323 1.51-3.008Z" />
                                </svg>
                                <p class="mt-3 px-2">This project was built from 2 main approaches: the optimization of information capture
                                    and the creation of modules for the creation of statistics and automatic reports.</p>
                            </div>
                        </span>
                        <span class="col-12 col-sm-9 col-md-6 col-xl-5 container-xs px-3 px-sm-4">
                            <div class="shadow-css px-4 pt-5 pb-4 me-0 ms-md-1 ms-lg-2 bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon mb-1 mt-2" alt="">
                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
                                </svg>
                                <p class="mt-3 px-2">It proposes solutions to problems related to the security and integrity of information,
                                    the systematization of processes, data analysis and easy access to information.</p>
                            </div>
                        </span>
                    </span>
                </span>
            </div>

            <div class="bg-container blue">
                <img id="webApp" class="background" src="" alt="" />
                <span class="row p-0 justify-content-center py-3 py-lg-5 my-5 text-white px-lg-4 px-xl-5">
                    <div class="col-auto bg-content pb-3 me-xl-5 ps-4 ps-sm-0 ps-xxl-2 pe-4 pe-sm-0 mb-4 mb-sm-5 mb-lg-0">
                        <div class="ps-2 pb-4 me-xl-5">
                            <h2 class="text-start ps-4 pe-3 pe-sm-0">Business web<br /> application</h2>
                        </div>
                        <div class="translucent-box p-4 mb-1 mb-lg-0">
                            <p class="m-0 p-2 pb-3">Transform pieces of information into a unified view of the organization to
                                gain valuable insights and create intelligent strategies.</p>
                        </div>
                    </div>
                    <div class="w-100 d-inline d-lg-none"></div>
                    <span class="col-auto check-list ps-sm-3 ps-xl-2 bg-content ms-2 ms-sm-3 ms-lg-5 me-sm-3 me-md-4 me-lg-2 me-xl-4">
                        <div class="row row-cols-auto mt-lg-2">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106 100" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
                                <use xlink:href="..\Imagenes\start\check.svg#Layer_1" />
                            </svg>
                            <p>Reduce resource consumption.</p>
                        </div>
                        <div class="row row-cols-auto">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106 100" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
                                <use xlink:href="..\Imagenes\start\check.svg#Layer_1" />
                            </svg>
                            <p>Optimize the transaction of information among departments.</p>
                        </div>
                        <div class="row row-cols-auto">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106 100" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
                                <use xlink:href="..\Imagenes\start\check.svg#Layer_1" />
                            </svg>
                            <p>Simplify data access and collection.</p>
                        </div>
                        <div class="row row-cols-auto pb-0">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106 100" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
                                <use xlink:href="..\Imagenes\start\check.svg#Layer_1" />
                            </svg>
                            <p>Provide a data analysis service to clients.</p>
                        </div>
                    </span>
                    <span class="col-auto check-list bg-content ms-2 ms-sm-0 ms-lg-2 ms-xxl-4 mt-1 mt-sm-0">
                        <div class="row row-cols-auto mt-3 mt-sm-0 mt-lg-2">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106 100" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
                                <use xlink:href="..\Imagenes\start\check.svg#Layer_1" />
                            </svg>
                            <p>Generate automatic statistical graphs.</p>
                        </div>
                        <div class="row row-cols-auto">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106 100" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
                                <use xlink:href="..\Imagenes\start\check.svg#Layer_1" />
                            </svg>
                            <p>Transform queries and reports into downloadable PDF and CSV files.</p>
                        </div>
                        <div class="row row-cols-auto pb-0">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106 100" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
                                <use xlink:href="..\Imagenes\start\check.svg#Layer_1" />
                            </svg>
                            <p>Read, store, consult and share documents easily.</p>
                        </div>
                    </span>
                </span>
            </div>

            <div class="bg-container bg-whithe">
                <img id="androidApp" class="background" src="" alt="" />
                <div class="row py-3 py-sm-4 py-lg-5 px-0 mt-5 mb-4 mb-sm-5 justify-content-center">
                    <span class="row p-0 m-0 pe-lg-5 col-auto ps-lg-2 ps-xl-0 justify-content-center pt-2 pt-md-0">
                        <div class="shadow-css androidApp bg-content bg-white col-auto px-0 px-sm-4 py-4 py-md-5 me-lg-3 ms-md-2 ms-lg-0">
                            <h2 class="text-start px-4 px-md-3 mt-1">Consultation Android application</h2>
                            <p class="px-4 px-md-3 mb-sm-3 mb-md-4">to make faster data-driven decisions.</p>
                        </div>
                        <span class="col-auto mx-3 mx-lg-2 mx-xl-5 px-xl-3 d-none d-md-inline"></span>
                        <span class="w-100 d-md-none"></span>
                        <span class="check-list second-list bg-content col-auto mt-3 mt-sm-4 mt-md-0 pe-0 pe-sm-2">
                            <div class="row row-cols-auto mt-4">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106 100" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
                                    <use xlink:href="..\Imagenes\start\check.svg#Layer_1" />
                                </svg>
                                <p>Access to information at your fingertips from anywhere.</p>
                            </div>
                            <div class="row row-cols-auto">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106 100" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
                                    <use xlink:href="..\Imagenes\start\check.svg#Layer_1" />
                                </svg>
                                <p>Make immediate and updated queries directly from the source.</p>
                            </div>
                            <div class="row row-cols-auto pb-0">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 106 100" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="">
                                    <use xlink:href="..\Imagenes\start\check.svg#Layer_1" />
                                </svg>
                                <p>Provide relevant information for planning and decision-making.</p>
                            </div>
                        </span>
                        <span class="col-auto p-0 ms-2 ms-xxl-1 me-xxl-3 d-none d-xl-inline"></span>
                    </span>
                    <span class="row p-0 m-0 justify-content-center py-2 py-md-0 px-2 px-sm-0">
                        <h2 class="text-center my-5 my-sm-4 my-md-5">Tech stack</h2>
                        <span class="row p-0 m-0 col-auto justify-content-center bg-content gap-md-1 gap-lg-4 gap-xl-5 mt-4 mt-md-0">
                            <div class="shadow-css tech-stack bg-white col-auto p-4 pt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon mt-4 mb-2" alt="">
                                    <path d="M4.08 5.227A3 3 0 0 1 6.979 3H17.02a3 3 0 0 1 2.9 2.227l2.113 7.926A5.228 5.228 0 0 0 18.75 12H5.25a5.228 5.228 0 0 0-3.284 1.153L4.08 5.227Z" />
                                    <path fill-rule="evenodd" d="M5.25 13.5a3.75 3.75 0 1 0 0 7.5h13.5a3.75 3.75 0 1 0 0-7.5H5.25Zm10.5 4.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm3.75-.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" clip-rule="evenodd" />
                                </svg>
                                <p class="px-2 m-0">PHP, MySQL, FPDF, JSON, XML, CSV & PHPMailer.</p>
                            </div>
                            <span class="my-3 pt-1 d-sm-none"></span>
                            <div class="shadow-css tech-stack bg-white col-auto p-4 pt-2 mx-lg-3 mx-xl-2 mx-xxl-3">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon mt-4 mb-2" alt="">
                                    <path fill-rule="evenodd" d="M2.25 5.25a3 3 0 0 1 3-3h13.5a3 3 0 0 1 3 3V15a3 3 0 0 1-3 3h-3v.257c0 .597.237 1.17.659 1.591l.621.622a.75.75 0 0 1-.53 1.28h-9a.75.75 0 0 1-.53-1.28l.621-.622a2.25 2.25 0 0 0 .659-1.59V18h-3a3 3 0 0 1-3-3V5.25Zm1.5 0v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5Z" clip-rule="evenodd" />
                                </svg>
                                <p class="px-2 m-0">HTML, CSS, JavaScript, JQUERY, AJAX, Chart.js & Bootstrap.</p>
                            </div>
                            <span class="my-3 pt-1 my-md-3 pt-md-0 d-lg-none"></span>
                            <div class="shadow-css tech-stack bg-white col-auto p-4 pt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon p-1 mt-4 mb-2" alt="">
                                    <path d="M10.5 18.75a.75.75 0 0 0 0 1.5h3a.75.75 0 0 0 0-1.5h-3Z" />
                                    <path fill-rule="evenodd" d="M8.625.75A3.375 3.375 0 0 0 5.25 4.125v15.75a3.375 3.375 0 0 0 3.375 3.375h6.75a3.375 3.375 0 0 0 3.375-3.375V4.125A3.375 3.375 0 0 0 15.375.75h-6.75ZM7.5 4.125C7.5 3.504 8.004 3 8.625 3H9.75v.375c0 .621.504 1.125 1.125 1.125h2.25c.621 0 1.125-.504 1.125-1.125V3h1.125c.621 0 1.125.504 1.125 1.125v15.75c0 .621-.504 1.125-1.125 1.125h-6.75A1.125 1.125 0 0 1 7.5 19.875V4.125Z" clip-rule="evenodd" />
                                </svg>
                                <p class="px-2 m-0 text-center mb-1 mb-sm-0 pb-3 pb-sm-0">Android, Volley & MPAndroidChart.</p>
                            </div>
                        </span>
                    </span>
                </div>
            </div>

            <div class="bg-container">
                <!-- rol? -->
                <img id="videoB" class="background d-none d-sm-block" src="" alt="" />
                <div class="video-backg m-0 mb-1 mx-0 mx-xxl-1 p-0 pt-1 pt-sm-1 pt-lg-0">
                    <div class="row px-0 px-sm-4 pb-3 pt-0 pt-sm-4 pt-lg-5 mb-4 mt-sm-4 mx-0 justify-content-center">
                        <div class="video mt-4 bg-content p-0">
                            <video id="video" crossorigin controls preload="metadata" alt="Project Introduction: Web platform for administrative income control and statistics generation for an association. This video provides an overview of the platform, highlighting its main functionality and how it is used. The different users who can access the platform are detailed, as well as the available forms, the interaction between catalogs, movements, and report generation. Additionally, the project includes a mobile agenda application that includes data from suppliers and packers, as well as statistical visualization for managerial control.">
                                <!-- cambiar a rutas actualizadas -------------------------------------------------
                        -----------------------------------------------------------------------------------
                        -------------------------------------------------------------------------------- -->
                                <source src="..\Imagenes\start\video\video-1280.mp4" type="video/mp4" media="(max-width: 920px)">
                                <source src="..\Imagenes\start\video\video-1920.mp4" type="video/mp4">
                                <track src="subtitles.vtt" kind="subtitles" srclang="en" label="English" default>
                            </video>
                        </div>
                        <span class="more bg-content">
                            <h2 class="bg-content text-white">View more</h2>
                        </span>
                    </div>
                </div>
            </div>

            <div class="bg-container bg-white">
                <img id="charts" class="background" src="" alt="" />
                <div class="row px-4 px-lg-0 py-4 my-1 my-sm-2 my-lg-4 justify-content-center">
                    <button class="col-9 col-sm-5 shadow-css button try-button blue text-white bg-content">
                        Try the web app <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="3 3 15 15" class="arrow-up">
                            <path fill-rule="evenodd" d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                    <button class="col-9 col-sm-5 shadow-css button bg-white bg-content mt-3 mt-sm-0">
                        Review the proyect <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="3 3 15 15" class="arrow-up">
                            <path fill-rule="evenodd" d="M5.22 14.78a.75.75 0 0 0 1.06 0l7.22-7.22v5.69a.75.75 0 0 0 1.5 0v-7.5a.75.75 0 0 0-.75-.75h-7.5a.75.75 0 0 0 0 1.5h5.69l-7.22 7.22a.75.75 0 0 0 0 1.06Z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>

                <div class="px-4 px-sm-5 pb-5 mb-3 mt-1 mt-lg-4 pt-3">
                    <span class="row pb-4 mb-2 px-0 px-sm-3 bg-content justify-content-center justify-content-lg-start">
                        <form class="col-12 row row-cols-1 px-4 py-4 mb-5 mt-4 shadow-css bg-content bg-white text-start form">
                            <h2 class="text-center mt-1 mb-0">Contact me</h2>
                            <span>
                                <label class="form-label">Phone:</label>
                                <input id="phone" class="form-control form-control-sm" type="tel" maxlength="10" minlength="10" NAME="phone" pattern="[0-9]+" />
                            </span>
                            <span>
                                <label class="form-label">Name:</label>
                                <input id="name" class="form-control form-control-sm" type="text" maxlength="50" NAME="name" required />
                            </span>
                            <span>
                                <label class="form-label">Email:</label>
                                <input id="email" class="form-control form-control-sm" type="text" maxlength="50" NAME="email" required pattern="[a-z0-9._%+-ñ]+@[a-z0-9.-]+\.[a-z]{2,}$" />
                            </span>
                            <span>
                                <label class="form-label">I'm a:</label>
                                <input id="iAm" class="form-control form-control-sm" type="text" maxlength="80" NAME="iAm" required />
                            </span>
                            <span>
                                <label class="form-label">Message:</label>
                                <textarea id="message" class="form-control form-control-sm" maxlength="700" NAME="message" autocomplete="off" required></textarea>
                            </span>
                            <button class="col-8 button blue text-white mb-4">Send</button>
                        </form>
                    </span>
                </div>
            </div>
        </div>

    </main>

    <footer>

    </footer>

    <script src="https://cdn.plyr.io/3.7.8/plyr.js"></script>
    <script rel="preload" src="../js/inicio.js" defer></script>
    <!-- bootstrap -->
    <script src="../Librerias/bootstrap.min.js"></script>
</body>

</html>
<!-- <filesMatch ".(css|jpg|jpeg|png|gif|js|ico)$">
    Header set Cache-Control "max-age=31536000, public"
    </filesMatch> -->