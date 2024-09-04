
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="tailwind.js"></script>
    <script src="https://kit.fontawesome.com/824e030594.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Pizzam-East</title>
</head>

<body>
    <nav class="h-20 flex flex-col md:flex-row justify-between items-center p-4">
        <div class="logo">
            <a href="index.php"><img class="logos" src="recursos/logo.png" alt="logo-pizzam"></a>
        </div>

        <div class="flex flex-col md:flex-row justify-evenly items-center md:w-3/4">

                <div><p class="uppercase font-semibold">Acerca de</p></div>
                <div><a href="index.php#menu"><p class="uppercase font-semibold">Menú</p></a></div>
                <div><p class="uppercase font-semibold">Ubicación</p></div>
                
            <?php
            session_start();
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo '<div class="flex items-center gap-2">
                        <div class="relative group">
                            <p class="uppercase font-semibold cursor-pointer group-hover:underline text-white">' . $username . '</p>
                            <i class="fa-solid fa-user fa-lg text-gray-500 group-hover:text-black"></i>
                            <div class="hidden md:absolute bg-white border border-gray-300 p-2 rounded shadow-md group-hover:block">
                                <a href="/logout.php" class="block">Cerrar Sesión</a>
                                <a href="/dashboard.php" class="block">Ir al Dashboard</a>
                            </div>
                        </div>
                    </div>';
            } else {
                echo '<div><a href="/login.php" class="uppercase font-semibold text-white hover:underline">Login</a></div>';
                echo '<div><a href="/register.php" class="uppercase font-semibold text-white hover:underline">Registro</a></div>';
            }
            ?>

            <div><a href="carrito.php"><button class="text-white bg-lime-600 rounded-xl w-36 h-10">Compras Online</button></a></div>
        </div>

        <div class="flex justify-evenly items-center gap-2 w-1/12 bg-red-600 h-20" style="position: relative;">
        
            <a href=""><i class="fa-solid fa-magnifying-glass fa-xl " style="color: #000000;"></i></a>
            <a href="" ><i class="fa-solid fa-cart-shopping fa-xl " style="color: #000000;"></i> </a>

            </div>
        </div>
    </nav>

</body>
<style>
    
</style>