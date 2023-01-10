<div>
    <div wire:loading style="width: 100%">
        <div class="callout callout-info">
            <h5>
                Procesando informarción por favor espere...
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-12">
            <div wire:ignore>
                <select name="listaDeDispositivos" id="listaDeDispositivos"></select>
                <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Activar Camara"
                    id="boton-c"><i class="fa fa-play"></i></button>
                <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Tomar Foto"
                    id="boton"><i class="fa fa-camera"></i></button>
                <button type="button" class="btn btn-primary" data-toggle="tooltip" title="Apagar Camara"
                    id="boton-a"><i class="fa fa-stop"></i></button>
                {{-- <button class="btn btn-primary" id="boton"><i class="fa fa-camera"
							aria-hidden="true"></i>
						Capturar Imagen</button> --}}
                <p id="estado"></p>
            </div>
            <br>
            <video muted="muted" id="video"></video>
            <canvas id="canvas" style="display: none;"></canvas>
            {{-- </div>
            </div> --}}
        </div>
        <div class="col-md-8 col-sm-12">

            <div class="row">

                <div class="col-md-6 col-sm-12">
                    <!-- Capturamos la imagen a través de la API web y lo mostramos en el canvas -->
                    {{-- <div class="card card-primary card-outline">
                        <div class="card-body"> --}}
                    <div class="row">
                        @if ($imagen)
                            <div class="col-md-12 h-44">
                                <button onclick="activeCrop('{{ $imagen }}')"
                                    class="btn btn-warning act-crop btn-block" data-img="{{ $imagen }}"> <i
                                        class="fas fa-cut"></i> Recortar Imagen</button>
                                <br>
                                <img src="{{ $imagen }}" alt="" width="100%">


                            </div>
                            {{-- <div class="col-md-6 h-44">

                                    </div> --}}
                        @endif
                    </div>

                    {{-- </div>
                    </div> --}}
                </div>

                <div class="col-md-6 col-sm-12">
                    <!-- Capturamos la imagen a través de la API web y lo mostramos en el canvas -->
                    {{-- <div class="card card-primary card-outline">
                        <div class="card-body"> --}}

                    <div class="row">
                        <div class="col-md-12 h-44">
                            <div id="btn-recorte"></div>
                            <br>
                            <div id="prueba-recorte"></div>
                        </div>
                    </div>
                    {{-- </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            @if ($imagen_recortada)
                <img src="{{ $imagen_recortada }}" alt="" width="150px" height="200px" style="position:absolute;margin-left: 30%;margin-top: 45%;">
            @endif
            <img src="{{ asset('img/carnet/base.png') }}" alt="" style="position:relative" width="100%">
        </div>
    </div>



    @push('css')
        <link rel="stylesheet" href="{{ asset('css/croppie.css') }}">
    @endpush
    @push('js')
        <script src="{{ asset('js/croppie.js') }}"></script>
        <script>
            function vidOff() {
                video.pause();
                video.src = "";
                localstream.getTracks()[0].stop();
                console.log("Video off");
            }
            $(document).on('click', '#boton-c', function(event) {
                event.preventDefault();
                /* Act on the event */
                camara();
            });

            $(document).on('click', '#boton-a', function(event) {
                event.preventDefault();
                /* Act on the event */
                vidOff();
            });
        </script>
        <script>
            function activeCrop(image) {
                var $w = 150,
                    $h = 300,
                    p = $('#prueba-recorte').croppie({
                        viewport: {
                            width: 250,
                            height: 300
                        },
                        boundary: {
                            width: 300,
                            height: 300
                        },
                        enableResize: false,
                        autoCrop: true,
                    });

                p.croppie('bind', {
                    url: image,
                    // points: [1, 1, 1, 1]
                    // points: [77, 469, 280, 739]
                });

                $('#btn-recorte').html(
                    '<button class="recortar btn-block btn btn-primary"> <i class="fas fa-save"></i> Guardar Imagen</button>'
                    )
                $('.recortar').on('click', function() {
                    var w = parseInt($w, 600),
                        h = parseInt($h, 600),
                        s
                    size = 'viewport';
                    if (w || h) {
                        size = {
                            width: w,
                            height: h
                        };
                    }
                    p.croppie('result', {
                        type: 'canvas',
                        size: size,
                        resultSize: {
                            width: 500,
                            height: 500
                        }
                    }).then(function(resp) {
                        // popupResult({
                        // 	src: resp
                        // });

                        $('#a').html('<img src="' + resp + '">')
                        Livewire.emit('guardarFoto', resp);

                    });
                });
            }

            function recortar() {
                var w = parseInt($w, 100),
                    h = parseInt($h, 100),
                    s
                size = 'viewport';
                if (w || h) {
                    size = {
                        width: w,
                        height: h
                    };
                }
                p.croppie('result', {
                    type: 'canvas',
                    size: size,
                    resultSize: {
                        width: 250,
                        height: 250
                    }
                }).then(function(resp) {
                    // popupResult({
                    // 	src: resp
                    // });

                    $('#a').html('<img src="' + resp + '">')
                    Livewire.emit('guardarFoto', resp);

                });
            };

            window.livewire.on('crop', (imagen) => {
                demoBasic(imagen);
            });
            window.livewire.on('ocultar_fotos', () => {
                $('#demo-basic').hide();
                $("#estado").html('');
            });
            //
        </script>

        <script>
            function camara() {
                const tieneSoporteUserMedia = () =>
                    !!(navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator
                        .webkitGetUserMedia || navigator.msGetUserMedia)
                const _getUserMedia = (...arguments) =>
                    (navigator.getUserMedia || (navigator.mozGetUserMedia || navigator.mediaDevices.getUserMedia) || navigator
                        .webkitGetUserMedia || navigator.msGetUserMedia).apply(navigator, arguments);

                // Declaramos elementos del DOM
                const $video = document.querySelector("#video"),
                    $canvas = document.querySelector("#canvas"),
                    $estado = document.querySelector("#estado"),
                    $boton = document.querySelector("#boton"),
                    $listaDeDispositivos = document.querySelector("#listaDeDispositivos")

                const limpiarSelect = () => {
                    for (let x = $listaDeDispositivos.options.length - 1; x >= 0; x--)
                        $listaDeDispositivos.remove(x);
                };
                const obtenerDispositivos = () => navigator
                    .mediaDevices
                    .enumerateDevices();

                // La función que es llamada después de que ya se dieron los permisos
                // Lo que hace es llenar el select con los dispositivos obtenidos
                const llenarSelectConDispositivosDisponibles = () => {

                    limpiarSelect();
                    obtenerDispositivos()
                        .then(dispositivos => {
                            const dispositivosDeVideo = [];
                            dispositivos.forEach(dispositivo => {
                                const tipo = dispositivo.kind;
                                if (tipo === "videoinput") {
                                    dispositivosDeVideo.push(dispositivo);
                                }
                            });

                            // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                            if (dispositivosDeVideo.length > 0) {
                                // Llenar el select
                                dispositivosDeVideo.forEach(dispositivo => {
                                    const option = document.createElement('option');
                                    option.value = dispositivo.deviceId;
                                    option.text = dispositivo.label;
                                    $listaDeDispositivos.appendChild(option);
                                });
                            }
                        });
                }

                (function() {
                    // Comenzamos viendo si tiene soporte, si no, nos detenemos
                    if (!tieneSoporteUserMedia()) {
                        alert("Lo siento. Su navegador no soporta esta característica");
                        $estado.innerHTML = "Parece que tu navegador no soporta esta característica. Intenta actualizarlo.";
                        return;
                    }
                    //Aquí guardaremos el stream globalmente
                    let stream;


                    // Comenzamos pidiendo los dispositivos
                    obtenerDispositivos()
                        .then(dispositivos => {
                            // Vamos a filtrarlos y guardar aquí los de vídeo
                            const dispositivosDeVideo = [];

                            // Recorrer y filtrar
                            dispositivos.forEach(function(dispositivo) {
                                const tipo = dispositivo.kind;
                                if (tipo === "videoinput") {
                                    dispositivosDeVideo.push(dispositivo);
                                }
                            });

                            // Vemos si encontramos algún dispositivo, y en caso de que si, entonces llamamos a la función
                            // y le pasamos el id de dispositivo
                            if (dispositivosDeVideo.length > 0) {
                                // Mostrar stream con el ID del primer dispositivo, luego el usuario puede cambiar
                                mostrarStream(dispositivosDeVideo[0].deviceId);
                            }
                        });



                    const mostrarStream = idDeDispositivo => {
                        _getUserMedia({
                                video: {
                                    // Justo aquí indicamos cuál dispositivo usar
                                    deviceId: idDeDispositivo,
                                }
                            },
                            (streamObtenido) => {
                                // Aquí ya tenemos permisos, ahora sí llenamos el select,
                                // pues si no, no nos daría el nombre de los dispositivos
                                llenarSelectConDispositivosDisponibles();

                                // Escuchar cuando seleccionen otra opción y entonces llamar a esta función
                                $listaDeDispositivos.onchange = () => {
                                    // Detener el stream
                                    if (stream) {
                                        stream.getTracks().forEach(function(track) {
                                            track.stop();
                                        });
                                    }
                                    // Mostrar el nuevo stream con el dispositivo seleccionado
                                    mostrarStream($listaDeDispositivos.value);
                                }

                                // Simple asignación
                                stream = streamObtenido;

                                // Mandamos el stream de la cámara al elemento de vídeo
                                localstream = stream;
                                $video.srcObject = stream;
                                $video.play();

                                //Escuchar el click del botón para tomar la foto
                                //Escuchar el click del botón para tomar la foto
                                $boton.addEventListener("click", function() {
                                    //Pausar reproducción
                                    $video.pause();
                                    estadoVideo = true;
                                    //Obtener contexto del canvas y dibujar sobre él
                                    let contexto = $canvas.getContext("2d");
                                    $canvas.width = $video.videoWidth;
                                    $canvas.height = $video.videoHeight;
                                    contexto.drawImage($video, 0, 0, $canvas.width, $canvas.height);

                                    let foto = $canvas.toDataURL(); //Esta es la foto, en base 64

                                    Livewire.emit('storePhoto', foto);

                                    //Reanudar reproducción
                                    $video.play();
                                });
                            }, (error) => {
                                console.log("Permiso denegado o error: ", error);
                                $estado.innerHTML = "No se puede acceder a la cámara, o no dio permiso.";
                            });
                    }
                })();
            }
        </script>
    @endpush
</div>
