<!DOCTYPE html>
<html lang="en">

<head>
    <title>Web portfolio</title>
    <meta name charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <!-- content=""> -->
    <link rel="shorcut icon" href="..\Imagenes\av.ico">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
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
        <div style="height: 1500px;" class="container p-0">
            <div id="about" class="bg-container bg-white">
                <img id="aboutB" class="background" src="" alt="" />
                <span class="row p-0 mb-4 px-0 px-xxl-5">
                    <h2 class="text-center">About the proyect</h2>
                    <span class="p-5 row justify-content-center gx-5 m-0 bg-content gy-5 pt-3 px-2 px-sm-5 mb-3" height="">
                        <span class="col-12 col-sm-10 col-md-6 col-xl-5">
                            <div class="shadow-css px-4 pt-5 pb-4 me-0 me-md-1 me-lg-2 bg-white">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="icon mb-1 mt-2" alt="">
                                    <path fill-rule="evenodd" d="M9.315 7.584C12.195 3.883 16.695 1.5 21.75 1.5a.75.75 0 0 1 .75.75c0 5.056-2.383 9.555-6.084 12.436A6.75 6.75 0 0 1 9.75 22.5a.75.75 0 0 1-.75-.75v-4.131A15.838 15.838 0 0 1 6.382 15H2.25a.75.75 0 0 1-.75-.75 6.75 6.75 0 0 1 7.815-6.666ZM15 6.75a2.25 2.25 0 1 0 0 4.5 2.25 2.25 0 0 0 0-4.5Z" clip-rule="evenodd" />
                                    <path d="M5.26 17.242a.75.75 0 1 0-.897-1.203 5.243 5.243 0 0 0-2.05 5.022.75.75 0 0 0 .625.627 5.243 5.243 0 0 0 5.022-2.051.75.75 0 1 0-1.202-.897 3.744 3.744 0 0 1-3.008 1.51c0-1.23.592-2.323 1.51-3.008Z" />
                                </svg>
                                <p class="mt-3 px-2">This project was built from 2 main approaches: the optimization of information capture
                                    and the creation of modules for the creation of statistics and automatic reports.</p>
                            </div>
                        </span>
                        <span class="col-12 col-sm-10 col-md-6 col-xl-5">
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
                <span class="row p-0 justify-content-center py-5 my-5 text-white px-lg-4 px-xl-5">
                    <!-- xl row p-0 justify-content-center py-5 my-5 text-white px-5 -->
                    <div class="col-auto bg-content pb-3 me-xl-5 ps-4 ps-sm-0 ps-xxl-2 pe-4 pe-sm-0 mb-5 mb-lg-0">
                        <!-- xl col-4 bg-content pe-5 ps-4 pb-3 ms-2 me-5 || col-4 col-xxl-3 pe-xl-3 ps-4 ps-xl-2-->
                        <div class="ps-0 ps-lg-2 pb-4 me-xl-5">
                            <h2 class="text-start ps-4 pe-3 pe-sm-0">Business web<br /> application</h2>
                        </div>
                        <div class="translucent-box p-4 mb-1 mb-lg-0">
                            <p class="m-0 p-2 pb-3">Transform pieces of information into a unified view of the organization to
                                gain valuable insights and create intelligent strategies.</p>
                        </div>
                    </div>
                    <div class="w-100 d-inline d-lg-none"></div>
                    <span class="col-auto check-list ps-sm-3 ps-xl-2 bg-content ms-2 ms-sm-3 ms-lg-5 me-sm-3 me-md-4 me-lg-2 me-xl-4">
                        <!-- col-6 check-list xl -->
                        <div class="row row-cols-auto">
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
                    <span class="col-auto check-list bg-content ms-2 ms-sm-0 ms-lg-2 ms-xxl-4 mt-4 mt-sm-0">
                        <div class="row row-cols-auto mt-3 mt-sm-0">
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
                <img id="androidApp" class="" src="" alt="" />
            </div>
        </div>

    </main>

    <footer>

    </footer>

    <script src="../js/inicio.js" defer></script>
    <!-- bootstrap -->
    <script src="../Librerias/bootstrap.min.js"></script>
</body>

</html>
<!-- <filesMatch ".(css|jpg|jpeg|png|gif|js|ico)$">
    Header set Cache-Control "max-age=31536000, public"
    </filesMatch> -->