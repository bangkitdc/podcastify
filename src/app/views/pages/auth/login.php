<link rel="stylesheet" href="<?= CSS_DIR ?>auth/auth.css">

<div id="template">
  <div class="login-wrapper">
    <h1>Log in to Podcastify</h1>
    <form action="POST" class="login-form">
      <?php
        require_once VIEWS_DIR . "/components/shares/inputs/text.php";
        echoInputText("username");

        echoInputText("password", true, true);

        echoJsFile();
      ?>
      <div class="form-button">
        <button type="submit" class="btn-submit">Log in</button>
      </div>
    </form>
    <hr />
    <div class="form-hyperlink">
      <span>Don't have an account? </span><a href="/register">Sign up for Podcastify</a>.
    </div>
  </div>
</div>

<script type="module" src="<?= JS_DIR ?>auth/login.js"></script>