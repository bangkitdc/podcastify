<link rel="stylesheet" href="<?= CSS_DIR ?>auth/login.css">

<div id="template">
  <div class="login-wrapper">
    <h1>Log in to Podcastify</h1>
    <form action="POST" class="login-form">
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username" id="username">
        <div id="username-alert" class="alert-hide">
          <img src="<?= ICONS_DIR ?>warning.svg" alt="Warning No Username" width="14px">
          <p>Please fill out your username first!</p>
        </div>
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" placeholder="Password" id="password" autocomplete="on">
        <div id="password-alert" class="alert-hide">
          <img src="<?= ICONS_DIR ?>warning.svg" alt="Warning No Password" width="14px">
          <p>Please fill out your password first!</p>
        </div>
      </div>
      <div class="form-button">
        <button type="submit" class="btn-submit">Log in</button>
      </div>
    </form>
    <hr />
    <div class="form-hyperlink">
      <span>Don't have an account? </span><a href="/register">Sign up for Podcastify</a>
    </div>
  </div>
</div>

<script src="<?= JS_DIR ?>auth/login.js"></script>