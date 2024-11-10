<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard with Logout Confirmation</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Overlay for background */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10;
            display: none; /* Hidden by default */
        }

        /* Container for logout dialog */
        .logout-container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 300px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Title and message styling */
        .logout-container h3 {
            margin-bottom: 10px;
            color: #333;
        }
        .logout-container p {
            margin-bottom: 20px;
            color: #666;
        }

        /* Button styling */
        .logout-container .btn {
            padding: 10px 20px;
            border-radius: 5px;
            margin: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn-cancel {
            background-color: #ccc;
            border: none;
            color: #333;
        }
        .btn-logout {
            background-color: #d9534f;
            border: none;
            color: white;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Trigger Button -->
    <button onclick="showLogoutContainer()" class="btn btn-primary">Logout</button>

    <h1>Dashboard</h1>
    <p>Welcome to your dashboard!</p>
</div>

<!-- Overlay for Logout Confirmation -->
<div class="overlay" id="logoutOverlay">
    <div class="logout-container">
        <h3>Confirm Logout</h3>
        <p>Are you sure you want to log out?</p>
        <button class="btn btn-cancel" onclick="hideLogoutContainer()">Cancel</button>
        <form action="/logout" method="POST" style="display:inline;">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <button type="submit" class="btn btn-logout">Logout</button>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script>
    // JavaScript to show and hide the overlay
    function showLogoutContainer() {
        document.getElementById('logoutOverlay').style.display = 'flex';
    }

    function hideLogoutContainer() {
        document.getElementById('logoutOverlay').style.display = 'none';
    }
</script>

</body>
</html>
