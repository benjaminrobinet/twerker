<?php

namespace bfforever\view;

abstract class AbstractView {

    static protected $style_sheets = [];
    static protected $app_title = "Twitter";
    protected $data = null;

    public function __construct($data){
        $this->data = $data;
    }

    static public function addStyleSheet($path_to_css_files){
        self::$style_sheets[] = $path_to_css_files;
    }
    
    static public function setAppTitle($title){
        self::$app_title = $title;
    }

    /* Méthode renderBody 
     * 
     * Retourne le contenu HTML de la 
     * balise body autrement dit le contenu du document. 
     *
     * Elle prend un sélecteur en paramètre dont la 
     * valeur indique quelle vue il faut générer.
     * 
     * Note cette méthode est a définir dans les classes concrètes des vues, 
     * elle est appelée depuis la méthode render ci-dessous.
     * 
     * Paramètre : 
     * 
     * $selector (String) : une chaîne qui permet de savoir quelle vue générer
     * 
     * Retourne : 
     *
     * - (String) : le contenu HTML complet entre les balises <body> </body> 
     *
     */
    
    abstract protected function renderBody($selector=null);
    
    public function render($selector){
        /* le titre du document */
        $title = self::$app_title;

        /* les feuilles de style */
        $prefix = (new \bfforever\utils\HttpRequest())->prefix;
        $styles = '';

        foreach ( self::$style_sheets as $file )
            $styles .= '<link rel="stylesheet" href="'.$prefix . '' . $file.'"> ';

        /* on appele la methode renderBody de la sous classe */
        $body = $this->renderBody($selector);

        $html = <<<EOT
<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>${title}</title>
        ${styles}
    </head>

    <body>
        
       ${body}

    </body>
</html>
EOT;

        echo $html;
    }
    
}
