<!DOCTYPE html>
<html lang="en">
<head>
    <title>Test view</title>
    <style>
        @import url(https://fonts.googleapis.com/css?family=Roboto:300);

        .test-page {
            width: 360px;
            padding: 8% 0 0;
            margin: auto;
        }

        h1 {
            margin: 0 0 15px;
            padding: 0;
            font-size: 36px;
            font-weight: 300;
            color: #1a1a1a;
        }

        .center {
            text-align: center;
        }

        body {
            background: #ffffff;
            font-family: "Roboto", sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }
    </style>
</head>
<body>

<div class="test-page">

    <h1 class="center">Test page</h1>

    <p class="center">

        {{ $data }}

    </p>

</div>

</body>
</html>
