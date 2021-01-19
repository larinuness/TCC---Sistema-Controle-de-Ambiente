<ul class="nav justify-content-center">
    <li class="nav-item <?php echo strlen(basename($_SERVER['REQUEST_URI'])) > 1 ? '' : 'active font-weight-bold'; ?>">
        <a class="nav-link" href="<?php
        if (strstr($_SERVER['REQUEST_URI'], 'painel')) {
            echo '/home';
        } else {
            echo '/home';
        }
        ?>" style="margin: 5px;">Início</a>
    </li>
    <li class="nav-item <?php echo strstr(basename($_SERVER['REQUEST_URI']), 'quemsomos') ? 'active font-weight-bold' : ''; ?>">
        <a class="nav-link" href="<?php
        if (strstr($_SERVER['REQUEST_URI'], 'painel')) {
            echo '/quemsomos';
        } else {
            echo 'quemsomos';
        }
        ?>" style="margin: 5px;">Quem somos</a>
    </li>
    <li class="nav-item <?php echo strstr(basename($_SERVER['REQUEST_URI']), 'contato') ? 'active font-weight-bold' : ''; ?>">
        <a class="nav-link" href="<?php
        if (strstr($_SERVER['REQUEST_URI'], 'painel')) {
            echo '/contato';
        } else {
            echo 'contato';
        }
        ?>" style="margin: 5px;">Contato</a>
    </li>
</ul>



