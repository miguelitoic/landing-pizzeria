<?php
include("includes/header.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


include("db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    $producto_id = $_POST['producto_id'];
    $cantidad = $_POST['cantidad'];

    $cantidad = max(1, min($cantidad, 10));

    $_SESSION['carrito'][$producto_id] = $cantidad;

}

if (isset($_GET['eliminar'])) {
    $producto_id = $_GET['eliminar'];
    unset($_SESSION['carrito'][$producto_id]);
    header("Location: " . $_SERVER['PHP_SELF']); // Redirigir al usuario
    exit();
  }

$productos_en_carrito = [];
if (isset($_SESSION['carrito']) && !empty($_SESSION['carrito'])) {

    $carrito_ids = implode(',', array_keys($_SESSION['carrito']));

    $sql_carrito = "SELECT * FROM productos WHERE id IN ($carrito_ids)";
    
    $result_carrito = $conn->query($sql_carrito);

    if ($result_carrito->num_rows > 0) {
        while ($row_carrito = $result_carrito->fetch_assoc()) {
            $producto_id = $row_carrito['id'];
            $row_carrito['cantidad'] = $_SESSION['carrito'][$producto_id];
            $productos_en_carrito[] = $row_carrito;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="tailwind.js"></script>
    <script src="https://kit.fontawesome.com/824e030594.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <title>Carrito de Compras</title>
</head>

<body>

    <main>
    
        <div class="banner-principal"></div>

        <section>
            <div class="flex flex-col items-center">
                <p class="uppercase font-semibold text-3xl text-center mt-8 ">Carrito de Compras</p>
                <hr class="w-[300px] border-amber-600 border mt-3 mb-10">
            </div>

                
        <div class="w-full flex flex-col items-center">
        <div class="flex flex-col w-2/3">
                <div class="overflow-x-auto sm:mx-0.5 lg:mx-0.5">
                    <div class="py-2 inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden">
                        <table class="min-w-full">
                        <thead class="bg-gray-800 border-b">
                            <tr>
                            <th scope="col" class="text-base uppercase font-medium text-white px-6 py-4 text-left">
                                Cantidad
                            </th>
                            <th scope="col" class="text-base uppercase font-medium text-white px-6 py-4 text-left">
                                Producto
                            </th>
                            <th scope="col" class="text-base uppercase font-medium text-white px-6 py-4 text-left">
                                P/U
                            </th>
                            <th scope="col" class="text-base uppercase font-medium text-white px-6 py-4 text-left">
                                Total
                            </th>
                            <th scope="col" class="text-base uppercase font-medium text-white px-6 py-4 text-left">
                               
                            </th>
                            </tr>
                    
                        </thead>

                        <?php 
                        $total_sum=0;
                        foreach ($productos_en_carrito as $indice => $producto ): ?>
                        <?php 
                        
                        
                        $total=$producto['precio']*$producto['cantidad'];
                        $total_sum+= $total;
                        
                        ?>
                        <tbody>
                            <tr class=" border-b">
                            <td class="text-sm font-light px-6 py-4 whitespace-nowrap">
                            <?php echo $producto['cantidad']; ?>
                            
                            </td>
                            <td class="text-sm font-light px-6 py-4 whitespace-nowrap">
                            <?php echo $producto['nombre']; ?>
                            </td>
                           
                            <td class="text-sm font-light px-6 py-4 whitespace-nowrap">
                            $<?php echo $producto['precio']; ?>
                            </td>
                            <td class="text-sm font-light px-6 py-4 whitespace-nowrap">
                            <?php echo "$".$total; ?>
                            </td>
                            <td class="text-sm font-light px-6 py-4 whitespace-nowrap">
                            <a href="carrito.php?eliminar=<?php echo $producto['id']; ?>"><i class="fa-regular fa-xl fa-trash-can"></i></a>
                            </td>
                            
                            <?php endforeach; ?>
                            <tr class="font-bold border-b">
                                <td></td>
                                <td></td>
                                <td class="text-right">Total:</td>
                                <td class="text-sm font-bold px-6 py-4 whitespace-nowrap">
                                $<?php echo $total_sum; ?>
                                </td>
                            </tr>


                        </tbody>

                        

                        </table>
                    </div>
                    </div>
                </div>
                </div>
                    
                
            </div>
        </div>
           
        <div class="w-full flex justify-center mb-10 mt-10 gap-4">
             <a href="index.php#menu"><button class="text-white bg-lime-600 rounded-xl w-36 h-10" >Volver al menu</button></a>
             <button class="text-white bg-lime-600 rounded-xl w-36 h-10" onclick="mostrarModal()">Metodos de Pago</button>                   
        </div>
                

        </section>

        <!-- Metodos de pago -->
        <div id="modal" class="hidden overflow-y-auto">
            <div class="modal-content">
                <div class="modal-header">
                <h2 class="font-bold">REGISTRO DE PAGO</h2>
                <button class="btn-abrir-modal btn btn-primary px-4 py-2 rounded-md text-sm font-medium bg-lime-600 text-white hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500">Ver datos</button>

                    <div class="modal-secundario overflow-y-auto">
                        <button type="button" class="btn-cerrar-modal-secundario" onclick="cerrarModalSecundario()">X</button>
                        <div class="flex flex-col">
                            
                            <h2 class="text-center uppercase mt-3 font-bold">Datos Pago Movil</h1>
                            <br>
                            <div class="mb-2 text-center">
                                <label for="telefono">Telefono: </label>
                                <p id="telefono" class="font-bold">0412-2523636</p>
                            </div>
                            <div class="mb-2 text-center">
                                <label for="cedula">Cedula:</label>
                                <p id="telefono" class="font-bold">v-12158673</p>
                            </div>
                            <div class="mb-2 text-center">
                                <label for="telefono">Banco: </label>
                                <p id="telefono" class="font-bold">Mercantil (0105) </p>
                            </div>

                            <div class="flex justify-center">
                                <hr class="w-[200px] border-amber-600 border mt-3 mb-3">
                            </div>
                           

                            <h2 class="text-center uppercase font-bold">Datos ZELLE</h1>
                            <br>
                            <div class="mb-2 text-center">
                                <label for="telefono">Nombre: </label>
                                <p id="telefono" class="font-bold">Pizzam-East</p>
                            </div>
                            <div class="mb-2 text-center">
                                <label for="cedula">Correo:</label>
                                <p id="telefono" class="font-bold">pizzameast_zelle@gmail.com</p>
                            </div>
                            <div class="mb-2 text-center">
                                <label for="telefono">Colocar en la descripcion: </label>
                                <p id="telefono" class="font-bold">Pago Pizzam</p>
                            </div>
                            
                            <div class="flex justify-center">
                                <hr class="w-[200px] border-amber-600 border mt-3 mb-3">
                            </div>
                            
                        </div>
                    </div>

                <button type="button" class="close-modal" onclick="cerrarModal()">X</button>
                </div>
                <div class="modal-body">
                <form id="formulario" class="space-y-4">
                    <div class="form-group flex flex-col">
                        <label for="opcion" class="text-sm font-medium mb-2">Metodo de pago:</label>
                        <select id="opcion" name="opcion" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 w-full px-3 py-2">
                        <option>--Selecciona un metodo de pago--</option>
                        <option value="2">Pago Movil</option>
                        <option value="3">Tarjeta de credito</option>
                        <option value="4">Zelle</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 gap-4">
                        <div class="form-group">
                        <label for="nombre" class="text-sm font-medium mb-2">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 w-full px-3 py-2">
                        </div>
                        <div class="form-group">
                        <label for="telefono" class="text-sm font-medium mb-2">Telefono:</label>
                        <input type="text" id="telefono" name="telefono" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 w-full px-3 py-2">
                        </div>
                        <div class="form-group">
                        <label for="n-ref" class="text-sm font-medium mb-2">Numero de referencia</label>
                        <input type="text" id="n-ref" name="n-ref" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 w-full px-3 py-2">
                        </div>
                        <div class="form-group">
                        <label for="fecha" class="text-sm font-medium mb-2">Fecha del pago:</label>
                        <input type="date" id="fecha" name="fecha" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 w-full px-3 py-2">
                        </div>
                    
                        <div class="form-group flex justify-end items-center">
                        <label for="total" class="text-sm font-medium mr-2">Total a pagar:</label>
                        <input type="text" id="total" name="total" class="bg-gray-200 border border-gray-300 text-gray-700 text-sm rounded-md px-3 py-2 w-24" disabled value=" $<?php echo $total_sum; ?>">
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button type="button" class="btn btn-secondary px-4 py-2 rounded-md text-sm font-medium bg-gray-200 text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" onclick="limpiarFormulario()">Limpiar</button>
                        <button type="submit" id="submitButton" class="btn btn-primary px-4 py-2 rounded-md text-sm font-medium bg-lime-600 text-white hover:bg-lime-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-lime-500">Registrar</button>
                    </div>
                    </form>
                
                </div>
        </div>
   
        </main>

    <footer class="w-full">
        <div class="w-full flex flex-col items-center">
            <div class="size-72 flex justify-center">
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
<style>
    img.logos {
    width: 17%;
}
i.fa-solid.fa-user.fa-lg.text-gray-500.group-hover\:text-black {
    display: none;
}

#modal {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 100;
  }
  
  .modal-content {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 80%;
    max-width: 500px;
    background-color: #fff;
    border-radius: 10px;
    padding: 20px;
  }
  
  .modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  
  .modal-header h2 {
    margin: 0;
  }
  
  .close-modal {
    border: none;
    background-color: transparent;
    cursor: pointer;
  }
  
  .modal-body {
    margin-top: 20px;
  }
  
  .modal-footer {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
  }
  
  .modal-footer button {
    margin-left: 10px;
  }

  .modal-secundario {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  display: none;
}


.btn-cerrar-modal-secundario {
  position: absolute;
  top: 10px;
  right: 10px;
  padding: 5px 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  cursor: pointer;
}

.modal-secundario {
  top: 21.5%;
  left: 135%;
  transform: translate(-50%, -50%);
  width: 300px;
  height: 250px;
  background-color: #fff;
  border-radius: 10px;
}

</style>

<script>

function mostrarModal() {
  document.getElementById("modal").classList.remove("hidden");
}

function cerrarModal() {
  document.getElementById("modal").classList.add("hidden");
}

const btnAbrirModalSecundario = document.querySelector('.btn-abrir-modal');
const modalSecundario = document.querySelector('.modal-secundario');

btnAbrirModalSecundario.addEventListener('click', () => {
  modalSecundario.style.display = 'block';
});     

// Función para cerrar el modal secundario
function cerrarModalSecundario() {
  modalSecundario.style.display = 'none';
}

</script>