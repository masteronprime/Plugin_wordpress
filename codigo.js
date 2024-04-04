document.addEventListener("DOMContentLoaded", function() {
    var btnSubirArchivo = document.getElementById("btnSubirArchivo");
    var inputArchivo = document.getElementById("inputArchivo");
    var imagenRecortada = document.getElementById("imagenRecortada");

    btnSubirArchivo.addEventListener("click", function() {
        inputArchivo.click();
    });

    inputArchivo.addEventListener("change", function() {
        var archivos = inputArchivo.files;

        if (archivos.length > 0) {
            var archivo = archivos[0];
            var reader = new FileReader();

            reader.onload = function(e) {
                QuitarFondo(archivo);
            }

            reader.readAsDataURL(archivo);
        }
    });

    function QuitarFondo(archivo) {
        var url = "https://api.remove.bg/v1.0/removebg";
        var apiKey = "Pu5NCGaWCby7ArsUYhdE4a2r";

        var formData = new FormData();
        formData.append("image_file", archivo);

        fetch(url, {
            method: "POST",
            body: formData,
            headers: {
                "X-API-Key": apiKey
            }
        })
        .then(response => response.blob())
        .then(blob => {
            console.log(blob)
            var imagenSinFondo = new File([blob], "sin_fondo.png");
            detectarRostros(imagenSinFondo);
        })
        .catch(error => console.error('Error al procesar la solicitud:', error));
    }

    function detectarRostros(archivo) {
        var url = "https://api-us.faceplusplus.com/facepp/v3/detect";
        var apiKey = "9ngH8vQI0AjLUQu2fcVk1UuzUHWxMz2Z"; 
        var apiSecret = "3_b25nUZNIoxp-4ab_BWoTejb_9GvYeZ";

        var formData = new FormData();
        formData.append("api_key", apiKey);
        formData.append("api_secret", apiSecret);
        formData.append("image_file", archivo);
        formData.append("return_landmark", 2);
        formData.append("return_attributes", "headpose,blur");

        fetch(url, {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.face_num > 0) {
                console.log(data)
                const faceRectangle = data.faces[0].face_rectangle;
                const top = faceRectangle.top-30;
                const left = faceRectangle.left-10;
                const width = faceRectangle.width+20;
                const height = faceRectangle.height+30;
                console.log(top)
                console.log(left)
                console.log(width)
                console.log(height)
                recortarImagen(archivo, top, left, width, height);
            } else {
                console.log('No se detectaron rostros en la imagen.');
            }
        })
        .catch(error => console.error('Error al procesar la solicitud:', error));
    }

    function recortarImagen(archivo, top, left, width, height) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var imagenOriginal = new Image();
            imagenOriginal.src = e.target.result;

            imagenOriginal.onload = function() {
                var lienzo = document.createElement("canvas");
                lienzo.width = width;
                lienzo.height = height;
                var contexto = lienzo.getContext("2d");

                contexto.drawImage(imagenOriginal, left, top, width, height, 0, 0, width, height);

                imagenRecortada.src = lienzo.toDataURL();
                imagenRecortada.style.display = "block";
            };
        };

        reader.readAsDataURL(archivo);
    }

});
