  <section class='hero'>
    <div class='hero-content flex-col'>
      <?php require 'app/views/posts/_form.html.php'; ?>
      <ul class="list bg-base-100 rounded-box shadow-md w-lg mt-4">
        <li class="p-4 pb-2 text-xs opacity-60 tracking-wide">Příspěvky</li>
        <?php
        if (count($posts) == 0) {
          echo "<li class='list-row'>
              <div class='text-xs uppercase font-semibold opacity-60'>
                Nenalezeny žádné příspěvky.
              </div>
            </li>";
        } else {
          foreach ($posts as $post) {
            echo "<li class='list-row'>
                    <div></div>
                    <div>
                      <div>" . $post->get_name() . "</div>
                      <div class='text-xs uppercase font-semibold opacity-60'>" . $post->get_author() . "</div>
                    </div>
                    <p class='list-col-wrap text-xs'>" . $post->get_body() . "</p>
                    <form action='/posts/destroy' method='POST'>
                      <input type='hidden' name='id' value='" . $post->get_id() . "' />
                      <button class='btn btn-error' type='submit'>Smazat</button>
                    </form>
                  </li>";
          }
        }
        ?>
      </ul>
    </div>
  </section>
