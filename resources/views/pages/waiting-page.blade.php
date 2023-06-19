<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

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
                </div>
            </div>
        </section>

    </main>

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="{{ asset('libraries/fakeLoader.js/demo/js/fakeLoader.min.js') }}"></script>
    <script>
        $.fakeLoader({
            timeToHide:2500,
            bgColor:"#34495e",
            spinner:"spinner3"
        })

        setTimeout(() => {
            $('#afterLoad').removeClass('d-none')

            var data = "BEGIN%3AVCARD%0AVERSION%3A3.0%0AN%3ADoe%3BJohn%0AFN%3AJohn%20Doe%0ATITLE%3A08002221111%0AORG%3AStackflowover%0AEMAIL%3BTYPE%3DINTERNET%3Ajohndoe%40gmail.com%0AEND%3AVCARD";
            window.open("data:text/x-vcard;urlencoded," + data);

            console.log(data)

        }, 3000);
     </script>
  </body>
</html>
