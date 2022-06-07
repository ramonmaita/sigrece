<div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-primary card-outline" style="height: 400px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">

                            <!-- Mensaje de error -->

                            <span name="errorMsg"></span>

                            <!-- Cargar Frame de TV y cargar el video de la webcam -->
                            <div id="video_wrap">
                                <div id="video_overlays">
                                    {{-- <img src="{{ asset('img/carnet/base.png') }}"></img> --}}
                                    {{-- <img src="https://www.raulprietofernandez.net/images/blog/218/tv.png"></img> --}}
                                </div>
                                <video id="video_frame" playsinline autoplay></video>
                            </div>
                        </div>
                        <div class="col-md-6">

                            <div class="button_controller" style="width: 130px; heigth:180px">
                                <!-- Botón para capturar -->
                                <button class="btn btn-primary" id="snap_frame"><i class="fa fa-camera"
                                        aria-hidden="true"></i>
                                    Capturar Imagen</button>
                                <br /><br />
                                <!-- Imagen de la Webcam -->
                                <canvas id="canvas_frame" class="hiddena"></canvas>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <!-- Capturamos la imagen a través de la API web y lo mostramos en el canvas -->
            <div class="card card-primary card-outline" style="height: 400px;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 h-44" style="height: 300px">
                            <button class="basic-result btn btn-primary"> <i class="fas fa-cut"></i> Recortar Imagen</button>
                            @if ($imagen)
                                {{-- <img src="{{ $url }}" alt=""> --}}
                                <div id="demo-basic"></div>
                            @endif
                            {{-- <div id="a"></div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @push('css')
        <link rel="stylesheet" href="{{ asset('css/croppie.css') }}">
        <style>
            #video_wrap {
                position: absolute;
                width: 420px;

            }

            #video_overlays {
                position: absolute;
            }

            #video_overlays img {
                width: 624px;
                height: 964px;
            }

            #video_frame {
                /* width: 720px; */
                /* width: 140px;
                    height: 180px; */
            }

            #canvas_frame {
                width: 624px;
                height: 964px;
                float: right;
            }

            .button_controller {
                float: right;
                /* border: 1px solid gray; */
                padding: 10px;
            }

        </style>
    @endpush
    @push('js')
        <script src="{{ asset('js/croppie.js') }}"></script>
        <script>
            function demoBasic(img) {
                var $w = $('.basic-width'),
                    $h = $('.basic-height'),
                    basic = $('#demo-basic').croppie({
                        viewport: {
                            width: 500,
                            height: 500
                        },
                        boundary: {
                            width: 600,
                            height: 600
                        },
						enableResize: true,
                    });
                basic.croppie('bind', {
                    url: img,
                    points: [77, 469, 280, 739]
                });

                $('.basic-result').on('click', function() {
                    var w = parseInt($w.val(), 100),
                        h = parseInt($h.val(), 100),
                        s
                    size = 'viewport';
                    if (w || h) {
                        size = {
                            width: w,
                            height: h
                        };
                    }
                    basic.croppie('result', {
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
            window.livewire.on('crop', (imagen) => {
                demoBasic(imagen);
            });
            window.livewire.on('ocultar_fotos', () => {
                $('#demo-basic').hide();
            });
            //
        </script>


        <script>
            'use strict'; // Para hacer que el código sea mas seguro.

            // Definimos las constantes que vamos a utilizar
            const videoFrame = document.getElementById('video_frame');
            const canvasFrame = document.getElementById('canvas_frame');
            const snapFrame = document.getElementById("snap_frame");
            const errorMsgElement = document.querySelector('span#errorMsg');

            // Definimos tamaño del video y si queremos audio o no
            const constraints = {
                audio: false,
                video: true
                // video: {
                //     width: 720,
                //     height: 405
                // }
            };

            // Comprobamos acceso a la Webcam
            async function init() {
                try {
                    const stream = await navigator.mediaDevices.getUserMedia(constraints);
                    handleSuccess(stream);
                } catch (e) {
                    errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
                }
            }

            // En caso de que el acceso sea correcto, cargamos la webcam
            async function handleSuccess(stream) {
                window.stream = stream;
                videoFrame.srcObject = stream;
            }

            // Iniciamos JS
            init();

            // Hacemos captura de pantalla al hacer click

            // var context = canvasFrame.getContext('2d');
            var context = canvasFrame.getContext('2d');
            snapFrame.addEventListener("click", function() {
                context.drawImage(videoFrame, 0, 0, 320, 140);
                Livewire.emit('storePhoto', canvasFrame.toDataURL());
            });
        </script>
    @endpush
</div>
