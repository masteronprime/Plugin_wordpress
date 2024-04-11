<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>prueba extraccion rostro</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.1.0/css/all.css"
        integrity="sha512-ajhUYg8JAATDFejqbeN7KbF2zyPbbqz04dgOLyGcYEk/MJD3V+HJhJLKvJ2VVlqrr4PwHeGTTWxbI+8teA7snw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
    @import url('//fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,800&display=swap');
    @import url('https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400..700;1,400..700&family=Rajdhani:wght@300;400;500;600;700&family=Reddit+Mono:wght@200..900&family=Ruda:wght@400..900&display=swap');

    body,
    html {
        margin: 0;
        padding: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .Modal {
        font-family: "Rajdhani", sans-serif;
        font-weight: 500;
        font-style: normal;
        position: relative;
        background-color: #fff;
    }

    .Modal-Header {
        position: relative;
        display: flex;
        justify-content: space-between;
        width: 100%;
        height: 60px;
        border-bottom: 1px solid black;
    }

    .Header-icono-Cerrar {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
        padding: 0 12px;
        cursor: pointer;
    }

    .Header-Titulo {
        position: absolute;
        top: 0;
        left: 0;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        padding: 0 50px;
        pointer-events: none;
    }

    .Modal-Body-Botones {
        margin-bottom: 20px;
        overflow: hidden;
        background: #fff;
        border-radius: 6px;
    }

    .Boton-Upload {
        box-shadow: 0 4px 1px -1px rgba(0, 0, 0, .2), 0 1px 1px rgba(0, 0, 0, .14), 0 1px 3px rgba(0, 0, 0, .12);
    }

    .loader {
        margin-top: 100px;
        place-content: center;
        display: none;
        background-color: #FFF;
        color: #10B981;
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
    }

    .cargando {
        width: 120px;
        height: 30px;
        display: flex;
        flex-wrap: wrap;
        align-items: flex-end;
        justify-content: space-between;
        margin: 0 auto;
    }

    .texto-cargando {
        padding-top: 20px
    }

    .cargando span {
        font-size: 20px;
        text-transform: uppercase;
    }

    .pelotas {
        width: 30px;
        height: 30px;
        background-color: #10B981;
        animation: salto .5s alternate infinite;
        border-radius: 50%
    }

    .pelotas:nth-child(2) {
        animation-delay: .18s;
    }

    .pelotas:nth-child(3) {
        animation-delay: .37s;
    }

    .rostro {
        background-image: url('./fondo_transparente.jpg');
        background-position: center;
        background-repeat: no-repeat;
        border: 3px solid #10B981;
        border-radius: 20px;
        padding-left: 10px;
        padding-right: 10px;
        padding-top: 10px;
        padding-bottom: 10px;
        box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1), 0px 6px 6px rgba(0, 0, 0, 0.08);
    }

    @keyframes salto {
        from {
            transform: scaleX(1.25);
        }

        to {
            transform:
                translateY(-50px) scaleX(1);
        }
    }

    #Modal-recortado-imagen {
        /* display: grid !important;
        grid-template-columns: 1fr 1fr;
        row-gap: 30px; */
    }
    .contenedor-rostro{
        display: grid !important;
        grid-template-columns: 1fr 1fr;
        row-gap: 30px;
    }

    /* Estilo para el cursor de escritura */
    @keyframes cursor {
        0% {
            border-right: 2px solid #000;
        }

        50% {
            border-right: 2px solid transparent;
        }

        100% {
            border-right: 2px solid #000;
        }
    }

    /* Estilo para la animación de escritura */
    @keyframes escribir {
        from {
            width: 0;
        }

        to {
            width: 100%;
        }
    }

    #texto-animado {
        border-right: 2px solid #000;
        animation: escribir 2s steps(40, end), cursor 0.5s step-end infinite alternate;
    }
</style>

<body>

    <button onclick="toggleModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Mostrar Div</button>

    <div id="modal" class="w-full h-full z-[999999] justify-center" style="display: none;">
        <div class="w-full h-full" style="background: rgba(0, 0, 0, .65); animation: mask .2s linear;">
            <div class="Modal md:m-auto w-full h-full absolute inset-0 overflow-hidden shadow-lg rounded-lg animate-bubbles z-[999999] flex flex-col"
                style="width: 500px; height: 600px; z-index: 99999;">
                <div class="Modal-Contenido">
                    <div class="Modal-Header bg-emerald-400">
                        <div class="Header-icono-Cerrar" onclick="toggleModal()"><svg viewBox="0 0 30 30"
                                style="width: 30px; height: 30px;" fill="white">
                                <path
                                    d="M15,12.8786797 L21.9393398,5.93933983 C22.5251263,5.35355339 23.4748737,5.35355339 24.0606602,5.93933983 C24.6464466,6.52512627 24.6464466,7.47487373 24.0606602,8.06066017 L17.1213203,15 L24.0606602,21.9393398 C24.6464466,22.5251263 24.6464466,23.4748737 24.0606602,24.0606602 C23.4748737,24.6464466 22.5251263,24.6464466 21.9393398,24.0606602 L15,17.1213203 L8.06066017,24.0606602 C7.47487373,24.6464466 6.52512627,24.6464466 5.93933983,24.0606602 C5.35355339,23.4748737 5.35355339,22.5251263 5.93933983,21.9393398 L12.8786797,15 L5.93933983,8.06066017 C5.35355339,7.47487373 5.35355339,6.52512627 5.93933983,5.93933983 C6.52512627,5.35355339 7.47487373,5.35355339 8.06066017,5.93933983 L15,12.8786797 Z">
                                </path>
                            </svg></div>
                        <div class="Header-Titulo">
                            <p class="Texto-Titulo font-bold text-xl">Elige tus <span id="texto-animado"
                                    class="Texto-Titulo font-bold text-xl text-white"></span> </p>
                        </div>
                    </div>
                    <div id="Modal-Body" class="Modal-Body block">
                        <div class="Modal-Body-Botones">
                            <div class="container mx-auto items-center w-[80%] bg-[#e4e4e3] rounded-lg py-4 Boton-Upload hover:scale-105">
                                <button type="button" id="btnSubirArchivo"
                                    class="text-black w-80 h-10 rounded-xl mx-auto  font-bold flex gap-10 items-center"
                                    onclick="abrirModalRecorte()">
                                    <svg class="h-8 w-8 text-black hover:scale-110" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <p>Presione aquí para subir archivos</p>
                                </button>
                                <input type="file" id="inputArchivo" style="display: none;">
                            </div>
                            <div class="mx-5 mt-10">
                                <h3 class="font-bold text-lg">Imagenes Recortadas</h3>
                                <p class="text-md">La imagen proviene del dispositivo local</p>
                            </div>
                            <div class="container mx-auto flex justify-center mt-10 mb-6">
                                <img id="imagenRecortada" src="" alt="Imagen recortada" style="display: none;">
                            </div>
                        </div>
                        <div class="Modal-Imagenes">
                        </div>
                    </div>
                </div>
                <div id="Modal-recortar" class="Modal-recortar hidden mt-14">
                    <div class="cropper-container w-full h-80">
                        <img id="imagenParaRecortar" src="" alt="Imagen para recortar">
                    </div>
                    <div
                        class="flex justify-center bottom-0 botones-accion mt-24 bg-[#e4e4e3] py-[14px] px-5 gap-5 text-md">
                        <button onclick="cancelarRecorte()"
                            class="border-[black] border-[1px] px-4 py-2 rounded-lg block w-[40%] uppercase font-bold ">Regresar
                        </button>
                        <input type="file" id="inputArchivo" style="display: none;">
                        <button onclick="recortarImagen()"
                            class="bg-emerald-400 px-4 py-2 rounded-lg block w-full uppercase font-bold">Confirmar
                            Recorte <i class="fas fa-cut"></i>
                        </button>
                    </div>
                </div>
                <div class="loader" id="loader">
                    <div class="cargando">
                        <div class="pelotas"></div>
                        <div class="pelotas"></div>
                        <div class="pelotas"></div>
                        <span class="texto-cargando">Cargando...</span>
                    </div>
                </div>
                <div id="Modal-recortado-imagen" class="hidden items-center mt-20 h-auto flex-row justify-center">
                </div>
                <div class="modal-footer mx-4 mt-auto mb-5 text-lg font-bold">
                    <button class="block w-full py-3 bg-emerald-400 rounded-xl"
                        onclick="toggleModal()">CANCELAR</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        function toggleModal() {
            var modal = document.getElementById('modal');
            var modalContenido = document.getElementById('Modal-Body');
            var modalFooter = document.querySelector('.modal-footer');
            var modalRecortar = document.getElementById('Modal-recortar');
            var inputArchivo = document.getElementById('inputArchivo');
            var imagenParaRecortar = document.getElementById('imagenParaRecortar');
            var cropper = imagenParaRecortar.cropper;
            var divImagenRecortada = document.getElementById('Modal-recortado-imagen');

            if (modal.style.display === 'none') {
                modal.style.display = 'block';
                modalContenido.style.display = 'block';
                modalFooter.style.display = 'block';
                modalRecortar.style.display = 'none';
                inputArchivo.value = '';
                cropper.destroy();
                divImagenRecortada.innerHTML = '';

            } else {
                modal.style.display = 'none';
                modalContenido.style.display = 'block';
                modalFooter.style.display = 'block';
                modalRecortar.style.display = 'none';
                inputArchivo.value = '';
                cropper.destroy();
                divImagenRecortada.innerHTML = '';
            }
        }

        function abrirModalRecorte() {
            var modalContenido = document.getElementById('Modal-Body');
            var modalFooter = document.querySelector('.modal-footer');
            var modalRecortar = document.getElementById('Modal-recortar');
            var inputArchivo = document.getElementById('inputArchivo');
            var imagenParaRecortar = document.getElementById('imagenParaRecortar');
            var imagenRecortada = document.getElementById('imagenRecortada');

            inputArchivo.click();

            inputArchivo.addEventListener('change', function () {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function (e) {
                    imagenParaRecortar.src = e.target.result;
                    imagenRecortada.src = e.target.result;
                    modalContenido.style.display = 'none';
                    modalFooter.style.display = 'none';
                    modalRecortar.style.display = 'block';
                    inicializarCropper();
                };

                reader.readAsDataURL(file);
            });
        }

        function inicializarCropper() {
            var imagenParaRecortar = document.getElementById('imagenParaRecortar');
            var areaDeRecorte = document.getElementById('areaDeRecorte');

            var cropper = new Cropper(imagenParaRecortar, {
                aspectRatio: 1,
                viewMode: 1,
                crop: function (event) {
                    console.log(event.detail.x);
                    console.log(event.detail.y);
                    console.log(event.detail.width);
                    console.log(event.detail.height);
                }
            });
        }

        function recortarImagen() {
            var imagenParaRecortar = document.getElementById('imagenParaRecortar');
            var modalRecortar = document.getElementById('Modal-recortar');
            var modalRecortadoImagen = document.getElementById('Modal-recortado-imagen');
            var cropper = imagenParaRecortar.cropper;
            function recortarImagen() {
                var imagenParaRecortar = document.getElementById('imagenParaRecortar');
                var modalRecortar = document.getElementById('Modal-recortar');
                var modalRecortadoImagen = document.getElementById('Modal-recortado-imagen');
                var cropper = imagenParaRecortar.cropper;


            cropper.getCroppedCanvas().toBlob(function (blob) {
                var url = URL.createObjectURL(blob);
                var archivoRecortado = new File([blob], 'imagen_recortada.png', { type: 'image/png' });

                modalRecortar.style.display = 'none';
                modalRecortadoImagen.style.display = 'block';
                //Se comento el quitar fondo porque se acabaron los intentos con la api
                QuitarFondo(archivoRecortado);
                // detectarRostros(archivoRecortado);
            });
        }

        function cancelarRecorte() {
            var modalContenido = document.getElementById('Modal-Body');
            var modalFooter = document.querySelector('.modal-footer');
            var modalRecortar = document.getElementById('Modal-recortar');
            var inputArchivo = document.getElementById('inputArchivo');
            var imagenParaRecortar = document.getElementById('imagenParaRecortar');
            var cropper = imagenParaRecortar.cropper;
            cropper.destroy();
            inputArchivo.value = '';
            modalContenido.style.display = 'block';
            modalFooter.style.display = 'block';
            modalRecortar.style.display = 'none';
        }

        function QuitarFondo(archivo) {
            document.getElementById('loader').style.display = 'block';
            var url = "https://techhk.aoscdn.com/api/tasks/visual/segmentation";
            // Pasada API Key Prueba
            // var apiKey = "wxackhnzvcg57j2yy";
            // Nueva API Key Prueba
            var apiKey = "wx5raadukjhva8sq3";
            var formData = new FormData();
            formData.append("image_file", archivo);
            formData.append("sync", 1);
            function QuitarFondo(archivo) {
                document.getElementById('loader').style.display = 'block';
                
                // Crear un nuevo elemento div para que contenga los elementos del rostro
                var modalRecortadoImagen = document.getElementById('Modal-recortado-imagen');
                var divContenedorRostro = document.createElement("div");

                divContenedorRostro.classList.add('contenedor-rostro');

                var divTitulo = document.createElement("div");
                divTitulo.classList.add('text-center', 'py-[32px]' ,'font-bold', 'text-[20px]' ,'uppercase');
                // Crear un nuevo elemento h3
                var h3Elemento = document.createElement("h3");

                // Establecer el texto del h3
                h3Elemento.textContent = "Escoge tu imagen";
                
                divTitulo.appendChild(h3Elemento);

                modalRecortadoImagen.appendChild(divTitulo);
                modalRecortadoImagen.appendChild(divContenedorRostro);

                var url = "https://techhk.aoscdn.com/api/tasks/visual/segmentation";
                // Pasada API Key Prueba
                // var apiKey = "wxackhnzvcg57j2yy";
                // Nueva API Key Prueba
                var apiKey = "wx5raadukjh12312312";
                var formData = new FormData();
                formData.append("image_file", archivo);
                formData.append("sync", 1);

            fetch(url, {
                method: "POST",
                body: formData,
                headers: {
                    "X-API-Key": apiKey
                }
            })
                .then(response => response.json())
                .then(data => {
                    console.log(data); // Imprimir la respuesta JSON
                    var imageBlob = data.data.image;
                    console.log(data.data.image);
                    detectarRostros(imageBlob);
                })
                .catch(error => {
                    document.getElementById('loader').style.display = 'none';
                    console.error('Error al procesar la solicitud:', error);
                });
        }
        function detectarRostros(archivo) {
            document.getElementById('loader').style.display = 'block';

            var url = "https://api-us.faceplusplus.com/facepp/v3/detect";
            var apiKey = "9ngH8vQI0AjLUQu2fcVk1UuzUHWxMz2Z";
            var apiSecret = "3_b25nUZNIoxp-4ab_BWoTejb_9GvYeZ";

            var formData = new FormData();
            formData.append("api_key", apiKey);
            formData.append("api_secret", apiSecret);
            formData.append("image_url", archivo);
            formData.append("return_landmark", 2);
            formData.append("return_attributes", "headpose,blur");

            fetch(url, {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    document.getElementById('loader').style.display = 'none';

                    if (data.face_num > 0) {
                        console.log(data);
                        for (var j = 0; j < data.faces.length; j++) {
                            const face = data.faces[j];
                            const faceRectangle = face.face_rectangle;
                            const rostro = {
                                top: faceRectangle.top - 150,
                                left: faceRectangle.left - 30,
                                width: faceRectangle.width + 50,
                                height: faceRectangle.height + 150
                            };
                            console.log(rostro);
                            recortarImagenFinal(archivo, rostro);
                        }
                    } else {
                        console.log('No se detectaron rostros en la imagen.');
                    }
                })
                .catch(error => {
                    document.getElementById('loader').style.display = 'none';
                    console.error('Error al procesar la solicitud:', error);
                });
        }
        function recortarImagenFinal(archivo, rostro) {
            fetch(archivo)
                .then(response => response.blob())
                .then(blob => {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var imagenOriginal = new Image();
                        imagenOriginal.src = e.target.result;

                        imagenOriginal.onload = function () {
                            var lienzo = document.createElement("canvas");
                            lienzo.width = rostro.width;
                            lienzo.height = rostro.height;
                            var contexto = lienzo.getContext("2d");
                            contexto.drawImage(imagenOriginal, rostro.left, rostro.top, rostro.width, rostro.height, 0, 0, rostro.width, rostro.height);

                            var imagenRecortada = new Image();
                            imagenRecortada.src = lienzo.toDataURL();
                            imagenRecortada.classList.add('w-full', 'h-32')

                            var divRostro = document.createElement("div");
                            divRostro.classList.add('rostro', 'h-auto', 'm-auto', 'items-center', 'w-[65%]');
                            divRostro.appendChild(imagenRecortada);
                                var divRostro = document.createElement("div");
                                divRostro.classList.add('rostro', 'h-auto', 'm-auto', 'items-center', 'w-[65%]','hover:scale-105');
                                divRostro.appendChild(imagenRecortada);

                                var divImagenRecortada2 = document.querySelector('.contenedor-rostro');
                                divImagenRecortada2.classList.add('grid');
                                divImagenRecortada2.appendChild(divRostro);
                                divImagenRecortada2.classList.add('grid');
                            };
                        };
                        reader.readAsDataURL(blob);
                    })
                    .catch(error => console.error('Error al cargar el archivo:', error));
            }
            document.addEventListener("DOMContentLoaded", function (event) {
                var textoAnimado = document.getElementById("texto-animado");
                var texto = "imágenes";
                function animarTexto() {
                    texto = "imágenes";
                    textoAnimado.textContent = "";
                    for (var i = 0; i < texto.length; i++) {
                        setTimeout(function () {
                            textoAnimado.textContent += texto.charAt(0);
                            texto = texto.substring(1);
                            if (texto.length === 0) {
                                setTimeout(animarTexto, 1000);
                            }
                        }, 150 * i);
                    }
                }
                animarTexto();
            });



    </script>
</body>

</html>