<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Background Job Dashboard</title>

    <!-- Add Bootstrap CSS CDN link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEJ+Mqe9h4CX1V_Mw+I5i9AB9h1gbJzvnrCg7t9dxQ9Ombb0s9v9w9FJXJoi9" crossorigin="anonymous">

    <!-- Custom CSS -->
    <style>
        body {
            background-image: url('https://your-image-url.com/path-to-image.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            color: #fff;
        }

        .container {
            margin-top: 50px;
            background-color: rgba(0, 0, 0, 0.7);  /* Adding transparency for readability */
            padding: 20px;
            border-radius: 10px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .btn {
            margin: 5px;
        }

        .alert-custom {
            font-size: 1.2rem;
        }

        .table-striped tbody tr:nth-child(odd) {
            background-color: #f2f2f2;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
        }

        footer {
            background-color: #343a40;
            color: white;
            padding: 10px 0;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        .logo {
            width: 120px;  /* Adjust size of logo */
        }
    </style>
</head>
<body>
    <div id="app">
        <header class="text-center my-4">
            <!-- Logo -->
            <img src="{{ asset('images/your-logo.png') }}" alt="Logo" class="logo">
        </header>

        @yield('content')

        <!-- Footer -->
        <footer>
            <p>&copy; 2024 Your Company Name | All Rights Reserved</p>
        </footer>
    </div>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
