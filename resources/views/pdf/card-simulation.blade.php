<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .row {
            display: table;
        }
        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>
    <x-card-view :user="$user" :qr="$qr" />
</body>
</html>
