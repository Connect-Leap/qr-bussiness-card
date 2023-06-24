<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=League+Gothic&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('libraries/fakeLoader.js/dist/fakeLoader.min.css') }}">

    <title>Wait for a moment...</title>
    <style>
        body { font-family: 'League Gothic', sans-serif; background-color: #08428C; }
    </style>
</head>

<body>
    <main>
        <section id="loader">
            <div class="fakeLoader"></div>
        </section>

        <section id="afterLoad" class="d-none">
            <div class="row justify-content-center align-items-center" style="height: 95vh">
                <div class="col-12">
                    <div class="text-center">
                        <img src="{{ asset('img/logos/connect-leap-logo.png') }}" class="img-fluid" width="120" alt="">
                    </div>
                    <div class="text-center my-3">
                        <h1 class="text-uppercase text-white">connect leap</h1>
                    </div>
                    <div class="text-center mb-3">
                        <h3 class="text-uppercase text-white">imprting contact ...</h3>
                    </div>
                    <div class="text-center mb-3">
                        <p class="text-uppercase text-xl text-white">please click <a href="{{ $destination }}" class="text-white fw-bold" download>download</a> if there is no download</p>
                    </div>
                    <div class="text-center">
                        <p class="text-uppercase text-white text-lg">you can check the contact at your phone by home > contacts > search contact</p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="{{ asset('libraries/fakeLoader.js/demo/js/fakeLoader.min.js') }}"></script>

    @include('layouts.app.check-mobile')

    <script>
        $.fakeLoader({
            timeToHide: 2500,
            bgColor: "#34495e",
            spinner: "spinner3"
        })

        setTimeout(() => {
            $('#afterLoad').removeClass('d-none')

            // console.log(data)

            fetch("{{ $destination }}")
                .then(function(response) {
                    return response.text()
                })
                .then(function(text) {
                    window.open("data:text/x-vcard;urlencoded," + text);
                });
        }, 3000);
    </script>
</body>

</html>
