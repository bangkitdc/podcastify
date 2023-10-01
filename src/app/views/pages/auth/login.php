<link rel="stylesheet" href="<?= CSS_DIR ?>auth/login.css">

<div id="template">
  <div class="login-wrapper">
    <h1>Log in to Podcastify</h1>
    <form action="" class="form-wrapper">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username" id="username" required>
        <!-- <p id="username-alert" class="alert-hide">Please fill out your username first!</p> -->
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" id="password" autocomplete="on" required>
        <!-- <p id="password-alert" class="alert-hide">Please fill out your password first!</p> -->
      </div>
      <div class="form-button">
        <!-- <p id="login-alert" class="alert-hide">Wrong username/password!</p> -->
        <button type="submit" class="btn-submit">Log in</button>
      </div>
    </form>
  </div>
</div>