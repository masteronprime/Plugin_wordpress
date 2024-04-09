<?php
/*
Plugin Name: Custom Button Alert 2
Plugin URI: https://tu-sitio-web.com
Description: Añade un botón que muestra una alerta al ser clickeado y un modal con un botón que muestra un div al ser clickeado.
Version: 1.0
Author: Ray Marcelo
Author URI: https://tu-sitio-web.com
License: GPL2
*/

// Agregar estilos CSS
function custom_button_alert_styles()
{
    ?>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .Modal {
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
            box-shadow: 0 4px 1px -1px rgba(0, 0, 0, .2), 0 1px 1px rgba(0, 0, 0, .14), 0 1px 3px rgba(0, 0, 0, .12);
        }

        @import url('//fonts.googleapis.com/css2?family=Montserrat:ital,wght@1,800&display=swap');

        .loader {
            margin-top: 100px;
            place-content: center;
            display: none;
            background-color: #FFF;
            color: #00b8de;
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
            background-color: #00b8de;
            animation: salto .5s alternate infinite;
            border-radius: 50%
        }

        .pelotas:nth-child(2) {
            animation-delay: .18s;
        }

        .pelotas:nth-child(3) {
            animation-delay: .37s;
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
            display: flex !important;
        }
    </style>

    <?php
}
add_action('wp_head', 'custom_button_alert_styles');

// Agregar un shortcode para insertar el botón y los modales en el contenido
function custom_button_shortcode()
{
    ob_start(); // Iniciar el buffer de salida
    ?>
    <button onclick="toggleModal()" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Mostrar Div</button>

    <div id="modal" class="w-full h-full z-[999999] justify-center" style="display: none;">
        <div class="w-full h-full" style="background: rgba(0, 0, 0, .65); animation: mask .2s linear;">
            <div class="md:m-auto w-full h-full absolute inset-0 bg-white overflow-hidden shadow-lg rounded-lg animate-bubbles z-[999999]"
                style="width: 500px; height: 600px; z-index: 99999;">
                <div class="Modal">
                    <div class="Modal-Contenido">
                        <div class="Modal-Header">
                            <div class="Header-icono-Cerrar" onclick="toggleModal()"><svg viewBox="0 0 30 30"
                                    style="width: 30px; height: 30px;">
                                    <path
                                        d="M15,12.8786797 L21.9393398,5.93933983 C22.5251263,5.35355339 23.4748737,5.35355339 24.0606602,5.93933983 C24.6464466,6.52512627 24.6464466,7.47487373 24.0606602,8.06066017 L17.1213203,15 L24.0606602,21.9393398 C24.6464466,22.5251263 24.6464466,23.4748737 24.0606602,24.0606602 C23.4748737,24.6464466 22.5251263,24.6464466 21.9393398,24.0606602 L15,17.1213203 L8.06066017,24.0606602 C7.47487373,24.6464466 6.52512627,24.6464466 5.93933983,24.0606602 C5.35355339,23.4748737 5.35355339,22.5251263 5.93933983,21.9393398 L12.8786797,15 L5.93933983,8.06066017 C5.35355339,7.47487373 5.35355339,6.52512627 5.93933983,5.93933983 C6.52512627,5.35355339 7.47487373,5.35355339 8.06066017,5.93933983 L15,12.8786797 Z">
                                    </path>
                                </svg></div>
                            <div class="Header-Titulo"><span class="Texto-Titulo font-bold">Elige tus imágenes </span>
                            </div>
                        </div>
                        <div id="Modal-Body" class="Modal-Body block">
                            <div class="Modal-Body-Botones">
                                <div class="container mx-auto flex justify-between mt-10 items-center">
                                    <svg class="h-8 w-8 text-black ml-10 hover:scale-110" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <button type="button" id="btnSubirArchivo"
                                        class="text-black w-64 h-10 rounded-xl m-auto hover:scale-110"
                                        onclick="abrirModalRecorte()">
                                        Presione aquí para subir archivos
                                    </button>
                                    <input type="file" id="inputArchivo" style="display: none;">
                                </div>
                                <div class="container mx-auto flex justify-center mt-10 mb-6">
                                    <img id="imagenRecortada" src="" alt="Imagen recortada" style="display: none;">
                                </div>
                            </div>
                            <div class="Modal-Imagenes">
                            </div>
                        </div>
                    </div>
                    <div id="Modal-recortar" class="Modal-recortar hidden">
                        <div class="cropper-container w-full h-60">
                            <img id="imagenParaRecortar" src="" alt="Imagen para recortar">
                        </div>
                        <div class="flex justify-center items-end bottom-0 botones-accion">
                            <button onclick="recortarImagen()">Recortar</button>
                            <button onclick="cancelarRecorte()">Cancelar</button>
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

                </div>
            </div>
        </div>
    </div>

    <?php
    return ob_get_clean(); // Devolver y limpiar el buffer de salida
}
add_shortcode('custom_button', 'custom_button_shortcode');

// Agregar scripts JavaScript
function custom_button_alert_script()
{
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

    <script>
        function toggleModal() {
            var modal = document.getElementById('modal');
            var modalContenido = document.getElementById('Modal-Body');
            var modalRecortar = document.getElementById('Modal-recortar');
            var inputArchivo = document.getElementById('inputArchivo');
            var imagenParaRecortar = document.getElementById('imagenParaRecortar');
            var cropper = imagenParaRecortar.cropper;
            var divImagenRecortada = document.getElementById('Modal-recortado-imagen');

            if (modal.style.display === 'none') {
                modal.style.display = 'block';
                modalContenido.style.display = 'block';
                modalRecortar.style.display = 'none';
                inputArchivo.value = '';
                cropper.destroy();
                divImagenRecortada.innerHTML = '';

            } else {
                modal.style.display = 'none';
                modalContenido.style.display = 'block';
                modalRecortar.style.display = 'none';
                inputArchivo.value = '';
                cropper.destroy();
                divImagenRecortada.innerHTML = '';
            }
        }

        function abrirModalRecorte() {
            var modalContenido = document.getElementById('Modal-Body');
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

            cropper.getCroppedCanvas().toBlob(function (blob) {
                var url = URL.createObjectURL(blob);
                var archivoRecortado = new File([blob], 'imagen_recortada.png', { type: 'image/png' });

                modalRecortar.style.display = 'none';
                modalRecortadoImagen.style.display = 'block'
                QuitarFondo(archivoRecortado);
            });
        }

        function cancelarRecorte() {
            var modalContenido = document.getElementById('Modal-Body');
            var modalRecortar = document.getElementById('Modal-recortar');
            var inputArchivo = document.getElementById('inputArchivo');
            var imagenParaRecortar = document.getElementById('imagenParaRecortar');
            var cropper = imagenParaRecortar.cropper;
            cropper.destroy();
            inputArchivo.value = '';
            modalContenido.style.display = 'block';
            modalRecortar.style.display = 'none';
        }

        function QuitarFondo(archivo) {
            document.getElementById('loader').style.display = 'block';
            var url = "https://techhk.aoscdn.com/api/tasks/visual/segmentation";
            var apiKey = "wxackhnzvcg57j2yy";

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
                            imagenRecortada.classList.add('w-32', 'h-36')

                            var divRostro = document.createElement("div");
                            divRostro.classList.add('rostro', 'h-auto', 'm-auto', 'items-center', 'w-36');
                            divRostro.appendChild(imagenRecortada);

                            var divImagenRecortada = document.getElementById('Modal-recortado-imagen');
                            divImagenRecortada.classList.add('flex');
                            divImagenRecortada.appendChild(divRostro);
                            divImagenRecortada.classList.add('flex');
                        };
                    };
                    reader.readAsDataURL(blob);
                })
                .catch(error => console.error('Error al cargar el archivo:', error));
        }


    </script>
    <?php
}
add_action('wp_footer', 'custom_button_alert_script');

