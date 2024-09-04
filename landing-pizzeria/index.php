    <?php session_start(); ?>
    
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="tailwind.js"></script>
        <script src="https://kit.fontawesome.com/824e030594.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="styles.css">
        <title>Pizzam-East</title>
    </head>

    <body>
        <!-- Consulta de productos -->

        <?php
        include("db.php");
        $sql = "SELECT * FROM productos";
        $result = $conn->query($sql);
        $productos = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $productos[] = $row;
            }
        }
        ?>

        <!-- Carrito -->
        
        <!-- Header -->
    <nav class="h-20 flex flex-col md:flex-row justify-between items-center p-4">
        <div class="logo">
            <a href="index.php"><img class="logos" src="recursos/logo.png" alt="logo-pizzam"></a>
        </div>

        <div class="flex flex-col md:flex-row justify-evenly items-center md:w-3/4">

                <div><p class="uppercase font-semibold">Acerca de</p></div>
                <div><a href="index.php#menu"><p class="uppercase font-semibold">Menú</p></a></div>
                <div><p class="uppercase font-semibold">Ubicación</p></div>

            <div><a href="carrito.php"><button class="text-white bg-lime-600 rounded-xl w-36 h-10">Compras Online</button></a></div>
        </div>

        <div class="flex justify-evenly items-center gap-2 w-1/12 bg-red-600 h-20" style="position: relative;">

            <a href=""><i class="fa-solid fa-magnifying-glass fa-xl " style="color: #000000;"></i></a>

            <a href="carrito.php"><i class="fa-solid fa-cart-shopping fa-xl " style="color: #000000;"></i></a> 
            
        </div>
    </nav>


        <main>
            <!-- Primera Imagen landing -->

            <div class="banner-principal"></div>

            <!-- Menu -->
            <div class="flex flex-col items-center" id="menu">

                <p class="uppercase font-semibold text-3xl text-center mt-8 ">menu Pizzam-East</p>
                <hr class="w-[300px] border-amber-600 border mt-3 mb-10">

            </div>

            <section class="grid-cols-1 sm:grid md:grid-cols-3 place-items-center mb-10">

                <?php foreach ($productos as $producto): ?>

                    <div class="max-w-xs overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 mb-10">

                        <div class=" h-[148px] w-[320px] px-4 py-2">
                            <h1 class="text-xl font-bold text-gray-800 uppercase dark:text-white"><?php echo $producto['nombre']; ?></h1>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400"><?php echo $producto['descripcion']; ?></p>
                        </div>

                        <img class="object-cover w-full h-full mt-2" src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">

                        <div class="flex items-center justify-evenly px-4 py-2 bg-lime-600">

                            <h1 class="text-lg font-bold text-white">
                                $<?php echo $producto['precio']; ?>
                            </h1>

                            <!-- Datos para carrito -->

                            <form method="post" action="carrito.php" class="flex items-center justify-between gap-2">

                                <input type="hidden" name="producto_id" value="<?php echo $producto['id']; ?>">
                                <input type="hidden" name="titulo" value="<?php echo $producto['nombre']?>">
                                <input type="hidden" name="precio" value="<?php echo $producto['precio']?>">

                                <label class="text-white underline" for="cantidad">Cantidad:</label>
                                <input type="number" name="cantidad" value="1" min="1" max="10" style="width: 30px;">
                                
                                <button class="px-2 py-1 text-xs font-semibold text-gray-900 uppercase transition-colors duration-300 transform bg-white rounded hover:bg-gray-200 focus:bg-gray-400 focus:outline-none" type="submit">
                                    Al carrito
                                </button>
                            </form>

                        </div>
                    </div>

                <?php endforeach; ?>
            </section>
        </main>

        <!-- Promociones -->
        <section class="w-full h-[350px] flex flex-col items-center justify-center mt-10 mb-5">
            <hr class="w-11/12 border-amber-600 border">
            <p class="uppercase font-semibold text-3xl text-center m-8">¿Conoces nuestras promociones?</p>
            <img src="recursos/flayer-1-pizzam.png" alt="flayer-1-pizzam">
        </section>

        <!-- Testimonios -->
        <section class="img-2 h-[350px] bg-cover">
            <div class="flex flex-col items-center">
                <p class="uppercase text-lime-400 font-semibold text-3xl text-center pt-6">lo que dice la gente</p>
                <hr class="w-[300px] border-amber-600 border mt-3">
            </div>

            <div class="w-flex h-72 flex justify-evenly items-center">
                <div class="text-white w-1/6 p-5">
                    <p class="text-center text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas
                        consequatur nostrum tempora quidem rem deleniti, repudiandae necessitatibus sunt doloremque
                        laboriosam natus praesentium incidunt magni dicta quibusdam ipsa, repellat maxime provident.</p>
                    <p class="text-end text-sm italic mt-3">- Lorem ipsum dolor sit</p>
                </div>
                <div class="text-white w-1/6 p-5">
                    <p class="text-center text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas
                        consequatur nostrum tempora quidem rem deleniti, repudiandae necessitatibus sunt doloremque
                        laboriosam natus praesentium incidunt magni dicta quibusdam ipsa, repellat maxime provident.</p>
                    <p class="text-end text-sm italic mt-3">- Lorem ipsum dolor sit</p>
                </div>
                <div class="text-white w-1/6 p-5">
                    <p class="text-center text-sm">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptas
                        consequatur nostrum tempora quidem rem deleniti, repudiandae necessitatibus sunt doloremque
                        laboriosam natus praesentium incidunt magni dicta quibusdam ipsa, repellat maxime provident.</p>
                    <p class="text-end text-sm italic mt-3">- Lorem ipsum dolor sit</p>
                </div>
            </div>
        </section>

        <!-- Redes Sociales -->
        <footer class="w-full">
            <div class="w-full flex flex-col items-center">
                <div class="size-80 flex justify-center">
                    <img src="recursos/logo.png" alt="logo-pizzam">
                </div>
                <div class="mb-10 flex gap-5">
                    <i class="fa-brands fa-instagram fa-xl" style="color: #d4660c;"></i>
                    <i class="fa-brands fa-facebook fa-xl"></i>
                    <i class="fa-solid fa-phone fa-xl" style="color: #d4660c;"></i>
                </div>
                <div>
                    <p class="text-sm">@Copyright 2024</p>
                </div>
            </div>
        </footer>
    </body>

    </html>
