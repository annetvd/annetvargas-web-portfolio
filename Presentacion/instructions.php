<?php
$src_md = "../Imagenes/start/md/";
$src_xxl = "../Imagenes/start/xxl/";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Instructions</title>
    <meta name charset="utf-8" />
    <meta name="description" property="og:description" content="Find information about each type of user and recommendations before accessing the project." />
    <meta name="author" content="Annet Vargas Dueñas" />
    <meta name="viewport" content="width=device-width" />

    <!-- icon -->
    <link rel="shorcut icon" href="..\Imagenes\av.ico">

    <!-- Open Graph -->
    <meta property="og:title" content="Instructions for logging in to the data analysis web platform" />
    <meta property="og:site_name" content="annetvd" />
    <meta property="og:url" content="https://annetvd.000webhostapp.com" />

    <!-- Docs styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.8/plyr.css" />
    <link href="..\css\instructions.css" rel="stylesheet">
</head>

<body style="background-color: #1f2aaf;">
    <header role="banner">
        <nav role="navigation">
            <div id="navContainer" class="navbar navbar-expand-sm navbar-light px-3 bg-white py-0 row-container">
                <span class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="btnNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse px-0" id="navbarNav">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="height: 50px;" alt="" aria-hidden="true">
                            <path fill-rule="evenodd" d="M15.22 6.268a.75.75 0 0 1 .968-.431l5.942 2.28a.75.75 0 0 1 .431.97l-2.28 5.94a.75.75 0 1 1-1.4-.537l1.63-4.251-1.086.484a11.2 11.2 0 0 0-5.45 5.173.75.75 0 0 1-1.199.19L9 12.312l-6.22 6.22a.75.75 0 0 1-1.06-1.061l6.75-6.75a.75.75 0 0 1 1.06 0l3.606 3.606a12.695 12.695 0 0 1 5.68-4.974l1.086-.483-4.251-1.632a.75.75 0 0 1-.432-.97Z" clip-rule="evenodd" />
                        </svg>
                        <ul class="navbar-nav text-black">
                            <li><a class="dropdown-item px-4 px-sm-3" href="inicio.php">Home</a></li>
                            <li><a class="dropdown-item px-4 px-sm-3" href="inicio.php#contact">Contact</a></li>
                            <li><a class="dropdown-item px-4 px-sm-3" href="#">Start</a></li>
                        </ul>
                    </div>
                </span>
            </div>
        </nav>

        <span id="cover" class="cover bg-container d-block">
            <!-- agregar más sombra a la portada index -->
            <img class="background" src="<?php echo $src_xxl; ?>instructions.png" srcset="<?php echo $src_md; ?>instructions.png 887w, <?php echo $src_xxl; ?>instructions.png" alt="" aria-hidden="true" />
            <img class="cover-space" src="<?php echo $src_xxl; ?>height.png" alt="" aria-hidden="true" />
            <svg class="absolute laptop-shadow" version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 500 500" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="" aria-hidden="true">
                <defs>
                    <radialGradient id="gradient" cx="50%" cy="50%" r="100%" fx="50%" fy="50%">
                        <stop offset="10%" style="stop-color:rgba(38,55,107,.8);" />
                        <stop offset="50%" style="stop-color:rgba(255,255,255,.0);" />
                    </radialGradient>
                </defs>
                <ellipse cx="250" cy="250" rx="250" ry="250" fill="url(#gradient)" />
            </svg>
            <img id="laptop" class="absolute laptop" src="" alt="" aria-hidden="true" />
            <span class="m-0 p-0 coverText">
                <div class="absolute bg-content">
                    <h1 class="">Before visiting <br />the web platform</h1>
                    <p class="">Use the following users to test the different experiences this web application offers.</p>
                </div>
            </span>
        </span>
    </header>

    <main role="main" class="bg-container p-0 users-shadow" style="min-height: 1000px;">
        <img class="background" src="<?php echo $src_xxl; ?>users.png" srcset="<?php echo $src_md; ?>users.png 887w, <?php echo $src_xxl; ?>users.png" alt="" aria-hidden="true" />
        <div class="container">
            <span class="d-block m-0 py-5 px-2 px-xl-5">
                <span class="row justify-content-center py-2 px-0">
                    <ul class="row users-list justify-content-center px-2 px-sm-3 px-md-0 py-md-2 py-lg-3 py-xl-1">
                        <li class="bg-content col-12 col-md-5">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 299 283" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="" aria-hidden="true">
                                <use xlink:href="..\Imagenes\start\coins.svg#Layer_1" />
                            </svg>
                            <h2 class="mt-xl-4 pt-4">Accounting</h2>
                            <p class="mt-3">Operate an agile workflow with custom-made administrative tools, monitor cash receipts and interact with the client in an automated way.</p>
                            <a href="#" class="button btn-users row p-0 text-center w-100" role="button" aria-label="Log In as Accounting"><span>Accounting login</span></a>
                        </li>
                        <li class="bg-content col-12 col-md-5">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 351 233" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="" aria-hidden="true">
                                <use xlink:href="..\Imagenes\start\lineChart.svg#Layer_1" />
                            </svg>
                            <h2 class="mt-xl-4 pt-4">Statistics</h2>
                            <p class="mt-3">Manage the organization's most important source of information and access statistical analysis to identify patterns and trends.</p>
                            <a href="#" class="button btn-users row p-0 text-center w-100" role="button" aria-label="Log In as Statistics"><span>Statistics login</span></a>
                        </li>
                        <li class="bg-content col-12 col-md-5">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 285 281" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="" aria-hidden="true">
                                <use xlink:href="..\Imagenes\start\gears.svg#Layer_1" />
                            </svg>
                            <h2 class="mt-xl-4 pt-4">Administrator</h2>
                            <p class="mt-3">Monitor all movements of the platform, register users and use the tools provided by the application to protect the information stored on the server.</p>
                            <a href="#" class="button btn-users row p-0 text-center w-100" role="button" aria-label="Log In as Administrator"><span>Administrator login</span></a>
                        </li>
                        <span class="w-100 d-none d-xxl-inline"></span>
                        <li class="bg-content col-12 col-md-5">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 219 280" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="" aria-hidden="true">
                                <use xlink:href="..\Imagenes\start\file.svg#Layer_1" />
                            </svg>
                            <h2 class="mt-xl-4 pt-4">Auxiliary</h2>
                            <p class="mt-3">Supports the statistical user by capturing validated, homogeneous and quality data.</p>
                            <a href="#" class="button btn-users row p-0 text-center w-100" role="button" aria-label="Log In as Assistant"><span>Assistant login</span></a>
                        </li>
                        <span id="reserve" class="bg-content col-12 col-md-5 p-0">
                            <li class="bg-content w-100 accordion-height m-0">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 172 281" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" alt="" aria-hidden="true">
                                    <use xlink:href="..\Imagenes\start\avocado.svg#Layer_1" />
                                </svg>
                                <h2 class="mt-xl-4 pt-4">Packer</h2>
                                <p class="mt-3 pb-0">Examine statistical analyzes of the evolution of the organization, as well as your company, and download them in PDF or CSV format to share and/or create your own analyses.</p>
                                <div class="accordion-item m-0 p-0">
                                    <h3 class="accordion-header row m-0 p-0" id="heading">
                                        <button class="accordion-button collapsed m-0 p-0" type="button" data-bs-toggle="collapse" data-bs-target="#collapse" aria-expanded="false" aria-controls="collapse" aria-label="Access help for packer"></button>
                                    </h3>
                                    <div id="collapse" class="accordion-collapse collapse p-0 m-0" aria-labelledby="heading">
                                        <div class="accordion-body p-0 m-0 row justify-content-center">
                                            <p class="pb-1 pb-xl-0">Modify this user's email to experience the password change process, as well as to send invoices, payment supplements and reports to your email.</p>
                                            <button class="reset-btn mt-2" type="button" aria-label="Reset username and password" title="If you have a problem with this user's email or password, click here." aria-describedby="reset-description">Reset user access</button>
                                            <p id="reset-description" class="absolute invisible">If you have trouble logging in as this user, click here.</p>
                                        </div>
                                    </div>
                                </div>
                                <a href="#" class="button btn-users row p-0 text-center w-100" role="button" aria-label="Log In as Packer"><span>Packer login</span></a>
                            </li>
                        </span>
                    </ul>
                </span>
                <span class="row justify-content-center px-2 px-sm-4 px-lg-5 py-2 py-sm-2 py-md-3 py-xxl-4 text-white">
                    <span class="row justify-content-center py-0 px-2 px-sm-2 px-md-4 text-width">
                        <p class="bg-content px-5">If you have any questions or want to see each of the benefits of this platform in detail, check the help section. This will support you depending on what pages the user you log in with has access to. I recommend that you log in as an administrator user, so you can see all the information in one place.</p>
                        <p class="bg-content px-5 mb-xl-3 pb-md-1">Feel free to reach out if you'd like additional information about this project or if you have any inquiries by sending me a message.</p>
                    </span>
                </span>
            </span>
        </div>
    </main>

    <footer class="bg-container blue" role="contentinfo">
        <img id="footer" class="background" src="<?php echo $src_xxl; ?>footer.png" srcset="<?php echo $src_md; ?>footer.png 887w, <?php echo $src_xxl; ?>footer.png" alt="" aria-hidden="true" />
        <span class="d-block container p-0 px-sm-2 px-md-0 px-xxl-5">
            <span class="row px-4 px-md-5 py-5">
                <p class="footer-title text-white bg-content my-0 py-0 px-2 px-sm-3 mx-3 pb-2 pb-sm-1 mb-sm-0 pe-5">Annet Vargas Dueñas</p>
                <div class="bg-content footer-content pb-2 px-3 mx-2">
                    <span class="ms-0 ps-1 me-5 me-sm-3 me-xxl-4 pe-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6" alt="phone">
                            <path fill-rule="evenodd" d="M1.5 4.5a3 3 0 0 1 3-3h1.372c.86 0 1.61.586 1.819 1.42l1.105 4.423a1.875 1.875 0 0 1-.694 1.955l-1.293.97c-.135.101-.164.249-.126.352a11.285 11.285 0 0 0 6.697 6.697c.103.038.25.009.352-.126l.97-1.293a1.875 1.875 0 0 1 1.955-.694l4.423 1.105c.834.209 1.42.959 1.42 1.82V19.5a3 3 0 0 1-3 3h-2.25C8.552 22.5 1.5 15.448 1.5 6.75V4.5Z" clip-rule="evenodd" />
                        </svg>
                        <p>+52 341 105 7551</p>
                    </span>
                    <span class="d-block d-sm-none m-0 mt-2 p-0"></span>
                    <span class="me-5 me-sm-3 me-xxl-4 pe-3">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-6 h-6" alt="email">
                            <path d="M1.5 8.67v8.58a3 3 0 0 0 3 3h15a3 3 0 0 0 3-3V8.67l-8.928 5.493a3 3 0 0 1-3.144 0L1.5 8.67Z" />
                            <path d="M22.5 6.908V6.75a3 3 0 0 0-3-3h-15a3 3 0 0 0-3 3v.158l9.714 5.978a1.5 1.5 0 0 0 1.572 0L22.5 6.908Z" />
                        </svg>
                        <p class="ms-1">annetvargasd@gmail.com</p>
                    </span>
                    <span class="d-block d-lg-none m-0 mt-2 p-0"></span>
                    <span class="ms-1 ms-lg-0 me-3 pe-1 text-wrap text-sm-nowrap">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" class="mb-0" alt="LinkedIn profile">
                            <path d="M0 1.146C0 .513.526 0 1.175 0h13.65C15.474 0 16 .513 16 1.146v13.708c0 .633-.526 1.146-1.175 1.146H1.175C.526 16 0 15.487 0 14.854zm4.943 12.248V6.169H2.542v7.225zm-1.2-8.212c.837 0 1.358-.554 1.358-1.248-.015-.709-.52-1.248-1.342-1.248S2.4 3.226 2.4 3.934c0 .694.521 1.248 1.327 1.248zm4.908 8.212V9.359c0-.216.016-.432.08-.586.173-.431.568-.878 1.232-.878.869 0 1.216.662 1.216 1.634v3.865h2.401V9.25c0-2.22-1.184-3.252-2.764-3.252-1.274 0-1.845.7-2.165 1.193v.025h-.016l.016-.025V6.169h-2.4c.03.678 0 7.225 0 7.225z" />
                        </svg>
                        <a href="https://www.linkedin.com/in/annet-vargas-dueñas" target="_blank">
                            https://www.linkedin.com/in/annet-vargas-dueñas
                        </a>
                    </span>
                </div>
            </span>
        </span>
    </footer>

    <script rel="preload" src="../js/instructions.js" defer></script>
    <!-- bootstrap -->
    <script src="../Librerias/bootstrap.min.js"></script>
</body>

</html>