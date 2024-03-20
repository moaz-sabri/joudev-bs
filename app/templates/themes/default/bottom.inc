<?php

use App\Extends\Translation\Loader\LanguageLoader;
use App\Bootstrap\Web;
?>

<footer class="py-3 my-4 border-top">
  <div class="container">
    <div class="d-flex flex-wrap justify-content-center justify-content-md-between align-items-center">
      <p class="col-md-4 mb-0 text-body-secondary">© 2024 Company, Inc</p>

      <a href="/" class="col-md-4 d-none d-md-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <span>BRAND</span>
      </a>

      <ul class="nav col-md-4 justify-content-end">
        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
        <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
        <li class="nav-item">
          <div class="dropdown bd-mode-toggle">
            <div class="p-0 dropdown">
              <button class="nav-link px-2 text-body-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="bd-theme" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                <?= $this->label->get('language') ?>
              </button>
              <ul class="dropdown-menu">
                <?php
                foreach (LanguageLoader::$availableLanguages as $key => $path) :
                  // Split the string by '/'
                  $parts = explode('/', $path);
                  $languageCode = $parts[count($parts) - 2];
                ?>
                  <li>
                    <a class='dropdown-item' href='/switch/language/<?= $languageCode; ?>?location=<?= $this->currentURL ?>'>
                      <?= $this->label->get($languageCode, $languageCode) ?>
                    </a>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</footer>