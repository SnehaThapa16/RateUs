<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - RateUs</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Sign Up</h2>
    <form id="signupForm">
        <input type="hidden" name="action" value="register">  <!-- Action for register -->
        
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="contact">Contact:</label>
        <input type="text" id="contact" name="contact" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <button type="submit">Sign Up</button>
    </form>

    <p id="message"></p>

    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            event.preventDefault();
            
            // Get form data
            const formData = new FormData(this);

            // Send data to the backend
            fetch('public/index.php', {  // Update with actual API path
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                // Handle response
                if (data.status === 'success') {
                    document.getElementById('message').textContent = 'Sign Up Successful!';
                } else {
                    document.getElementById('message').textContent = 'Sign Up Failed: ' + data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('message').textContent = 'An error occurred during signup.';
            });
        });
    </script>
</body>
</html>
