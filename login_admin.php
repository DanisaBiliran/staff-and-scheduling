<?php
require_once __DIR__ . "/classes/authentication.class.php";
session_start();

if (isset($_SESSION["user_id"])) {
  header("Location: ./index.php");
  exit();
}

$error = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $auth = new Authentication();
  $error = $auth->signIn($_POST); // Capture the error message
}

?>

<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.19/dist/full.min.css" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
  <title>MVCH</title>
</head>

<body class="bg-base-200">
  <main class="container mx-auto h-screen w-full flex justify-center items-center">
    <div class="max-w-sm w-full border bg-base-100 rounded-lg flex flex-col items-center p-6">
      <div class="flex flex-col items-center mb-4">
        <i data-lucide="log-in" class="h-8 w-8 text-primary"></i>
        <h1 class="text-xl font-bold">Welcome!</h1>
        <p class="text-gray-400">Sign in to your account</p>
      </div>
      <form method="POST" class="flex flex-col gap-4 items-center w-full">
        <?php if (!empty($error)): ?>
          <div class="alert alert-error shadow-lg w-full">
            <div>
              <i data-lucide="alert-circle" class="h-5 w-5"></i>
              <span><?php echo htmlspecialchars($error); ?></span>
            </div>
          </div>
        <?php endif; ?>
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Username</span>
          </div>
          <input type="text" name="username" placeholder="Type username" class="input input-bordered w-full" />
        </label>
        <label class="form-control w-full">
          <div class="label">
            <span class="label-text">Password</span>
          </div>
          <input type="password" name="password" placeholder="********" class="input input-bordered w-full" />
        </label>
        <button class="btn btn-primary w-full">Sign In</button>
      </form>
    </div>
  </main>

  <script>
    lucide.createIcons();
  </script>
</body>

</html>
