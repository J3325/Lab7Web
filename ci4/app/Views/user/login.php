<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="<?= base_url('/login.css'); ?>">
</head>
<body>
  <div id="login-wrapper">
    <h1>Sign In</h1>

    <?php if (session()->getFlashdata('flash_msg')): ?>
      <div class="alert alert-danger">
        <?= session()->getFlashdata('flash_msg') ?>
      </div>
    <?php endif; ?>

    <form action="" method="post">
      <!-- Email Field -->
      <div class="mb-3">
        <label for="InputForEmail" class="form-label">Email Address</label>
        <input 
          type="email" 
          name="email" 
          class="form-control" 
          id="InputForEmail" 
          placeholder="Enter your email"
          value="<?= set_value('email') ?>" 
          required
        >
      </div>

      <!-- Password Field -->
      <div class="mb-3">
        <label for="InputForPassword" class="form-label">Password</label>
        <input 
          type="password" 
          name="password" 
          class="form-control" 
          id="InputForPassword" 
          placeholder="Enter your password"
          required
        >
      </div>

      <!-- Submit Button -->
      <button type="submit" class="btn btn-primary">Login</button>
    </form>
  </div>
</body>
</html>
