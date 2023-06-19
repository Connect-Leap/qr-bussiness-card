<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('libraries/fakeLoader.js/dist/fakeLoader.min.css') }}">

    <title>Wait for a moment...</title>
</head>

<body>
    <main>

        <section id="loader">
            <div class="fakeLoader"></div>
        </section>

        <section id="afterLoad" class="d-none">
            <div class="row justify-content-center align-items-center" style="height: 95vh">
                <div class="col-12">
                    <h5 class="text-center">Open using Recomended System Contact </h5>
                    <div class="text-center mt-4">
                        <a href="{{ $destination }}" class="btn btn-primary">Download Contact File Here</a>
                    </div>
                    <div class="text-center">
                        <sup class="text-danger text-xs">Click button above if Popup not showed up</sup>
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

            let shareData = {
                title: "Connect Leap",
                text: "Safely Connect",
                url: "{{ $destination }}",
            };

            // feature detecting navigator.canShare() also implies
            // the same for the navigator.share()
            if (!navigator.canShare) {
                alert(`Your browser doesn't support the Web Share API.`);
            }

            if (navigator.canShare({ files })) {
                try {
                await navigator.share(shareData);
                    alert("Shared!")
                } catch (error) {
                    alert(`Error: ${error.message}`)
                }
            } else {
                alert(`Your system doesn't support sharing these files.`)
            }
        }, 3000);
    </script>
</body>

</html>
