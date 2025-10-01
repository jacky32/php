<section class='hero'>
  <div class='hero-content'>
    <form action="/registration" method="POST">
      <?php
      if (isset($errors) && count($errors) > 0) {
        echo "<div class='error'>";
        foreach ($errors as $error) {
          echo $error . "<br>";
        }
        echo "</div>";
      }
      ?>
      <fieldset class="fieldset bg-base-200 border-base-300 rounded-box w-xs border p-4">
        <legend class="fieldset-legend">Registrace</legend>

        <label class='floating-label my-1'>
          <span>Jméno</span>
          <input
            required
            type='text'
            name='username'
            placeholder='Jméno'
            class='input input-md' />
        </label>

        <label class='floating-label my-1'>
          <span>Email</span>
          <input
            required
            type='email'
            name='email'
            placeholder='Email'
            class='input input-md' />
        </label>

        <label class='floating-label my-1'>
          <span>Heslo</span>
          <input
            required
            type='password'
            name='password'
            placeholder='Heslo'
            class='input input-md' />
        </label>

        <button class="btn btn-primary mt-4">Registrovat</button>

        <a href="/login" class="btn btn-neutral mt-2">Zpět na přihlášení</a>
      </fieldset>
    </form>
  </div>
</section>
