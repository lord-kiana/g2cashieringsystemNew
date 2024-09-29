<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card border-0 mx-auto w-50">
            <div class="card-header bg-white border-0">
                <h1 class="display-4 fw-bold text-center text-danger">Register <i class="fa-solid fa-user-plus"></i></h1>
            </div>
            <div class="card-body">
                <form action="../actions/user-actions.php" method="post" class="w-75 mx-auto">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="first-name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first-name" class="form-control" required>
                        </div>
                        <div class="col-md-6">
                            <label for="last-name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last-name" class="form-control" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" name="username" id="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                    <button type="submit" name="register" class="btn btn-danger w-100">Register</button>
                </form>
                <div class="text-center mt-3">
    <a href="../index.php" class="btn btn-primary">Back to Login</a>
</div>

                
            </div>
        </div>
    </div>
</body>
</html>
