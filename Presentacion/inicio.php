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
            <div id="navContainer" class="navbar navbar-expand-sm navbar-light px-3 bg-white py-0 rowContainer">
                <span class="container">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation" id="btnNav">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarNav">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" style="height: 50px;" alt="">
                            <path fill-rule="evenodd" d="M15.22 6.268a.75.75 0 0 1 .968-.431l5.942 2.28a.75.75 0 0 1 .431.97l-2.28 5.94a.75.75 0 1 1-1.4-.537l1.63-4.251-1.086.484a11.2 11.2 0 0 0-5.45 5.173.75.75 0 0 1-1.199.19L9 12.312l-6.22 6.22a.75.75 0 0 1-1.06-1.061l6.75-6.75a.75.75 0 0 1 1.06 0l3.606 3.606a12.695 12.695 0 0 1 5.68-4.974l1.086-.483-4.251-1.632a.75.75 0 0 1-.432-.97Z" clip-rule="evenodd" />
                        </svg>
                        <ul class="navbar-nav text-black">
                            <li><a class="dropdown-item" href="#more">Read more</a></li>
                            <li><a class="dropdown-item" href="#contact">Contact</a></li>
                            <li><a class="dropdown-item" href="#try">Try it</a></li>
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
            <img id="prueba" class="absolute" src="..\Imagenes\start\prueba4.png" />
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
        <!-- poner un background blanco y sobreponer sobre blue para evitar que sobresalga -->
        <div id="container" style="height: 1000px;">

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