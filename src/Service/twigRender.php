<?php 

namespace App\Service;

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
        if (isset($_SESSION['id'])) {
            $this->twig->addGlobal('session', $_SESSION);
        }

        echo $this->twig->render($view.'.html.twig', $prams);
    }
}