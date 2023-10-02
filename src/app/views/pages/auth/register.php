<link rel="stylesheet" href="<?= CSS_DIR ?>auth/auth.css">

<div id="template">
  <div class="register-wrapper">
    <h1>Sign up to Podcastify</h1>
    <form action="POST" class="register-form">
      <?php
        require_once VIEWS_DIR . "/components/shares/inputs/text.php";
        echoInputText("email");

        echoInputText("username");

        echoInputText("first-name");

        echoInputText("last-name");

        echoInputText("password", true, true);

        echoInputText("confirm-password", true);

        echoJsFile();
      ?>
      <div class="form-button">
        <button type="submit" class="btn-submit">Sign up</button>
      </div>
    </form>
    <hr />
    <div class="form-hyperlink">
      <span>Have an account? </span><a href="/login">Log in</a>.
    </div>
  </div>
</div>

<script src="<?= JS_DIR ?>auth/register.js"></script>