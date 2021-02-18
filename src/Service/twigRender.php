<?php 

namespace App\Service;

use Twig\Extra\String\StringExtension;

class TwigRender
{
    private $twig;

    /**
     * Affiche le vue demander.
     *
     * @param string $view  lien de la vue
     * @param array  $prams données envoyer dans la vue
     */
    public function render($view, $prams = [])
    {
        $loader = new \Twig\Loader\FilesystemLoader('public/view');
        $this->twig = new \Twig\Environment($loader, [
            'cache' => false, // __DIR__ . /tmp',
            'debug' => true,
        ]);
        $this->twig->addExtension(new \Twig\Extension\DebugExtension());
        if (isset($_SESSION['user'])) {
            $this->twig->addGlobal('session', $_SESSION);
            $this->twig->addExtension(new StringExtension());
        }

        echo $this->twig->render($view.'.html.twig', $prams);
    }
}