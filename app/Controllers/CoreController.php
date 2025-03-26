<?php

namespace App\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Type;

class CoreController
{
    protected $router;
    public function __construct($router, $match)
    {
        $this->router = $router;
        //global $match;
        $routeName = $match['name'];

        // On définit la liste des permissions pour les routes nécessitant une connexion utilisateur
        $acl = [
            // 'main-home' => [], => pas besoin, la route est libre d'accès
            // 'user-signin' => [], => pas besoin, la route est libre d'accès
            'main-home' => ['admin', 'catalog-manager'],
            'user-add' => ['admin'],
            'user-add-post' => ['admin'],
            'user-list' => ['admin'],
            'user-update' => ['admin'],
            'user-update-post' => ['admin'],
            'user-delete' => ['admin'],
            'category-add' => ['admin', 'catalog-manager'],
            'category-add-post' => ['admin', 'catalog-manager'],
            'category-list' => ['admin', 'catalog-manager'],
            'category-update' => ['admin', 'catalog-manager'],
            'category-update-post' => ['admin', 'catalog-manager'],
            'category-delete' => ['admin', 'catalog-manager'],
            'product-add' => ['admin', 'catalog-manager'],
            'product-add-post' => ['admin', 'catalog-manager'],
            'product-list' => ['admin', 'catalog-manager'],
            'product-update' => ['admin', 'catalog-manager'],
            'product-update-post' => ['admin', 'catalog-manager'],
            'product-delete' => ['admin', 'catalog-manager'],
            'brand-add' => ['admin', 'catalog-manager'],
            'brand-add-post' => ['admin', 'catalog-manager'],
            'brand-list' => ['admin', 'catalog-manager'],
            'brand-update' => ['admin', 'catalog-manager'],
            'brand-update-post' => ['admin', 'catalog-manager'],
            'brand-delete' => ['admin', 'catalog-manager'],
            'type-add' => ['admin', 'catalog-manager'],
            'type-add-post' => ['admin', 'catalog-manager'],
            'type-list' => ['admin', 'catalog-manager'],
            'type-update' => ['admin', 'catalog-manager'],
            'type-update-post' => ['admin', 'catalog-manager'],
            'type-delete' => ['admin', 'catalog-manager'],
            'home-selection-update' => ['admin', 'catalog-manager'],
            'home-selection-update-post' => ['admin', 'catalog-manager'],
        ];

        // Si la route actuelle est dans la liste des ACL
        if (array_key_exists($routeName, $acl)) {
            // Alors on récupère le tableau des roles autorisés
            $authorizedRoles = $acl[$routeName];

            // Puis on utilie la méthode checkAuthorization($roles) pour vérifier les permissions
            $this->checkAuthorization($authorizedRoles);
        }

        $csrfTokenToCheckInPost = [
            'user-add-post',
            'user-update-post',
            'user-delete',
            'category-add-post',
            'category-update-post',
            'category-delete',
            'product-add-post',
            'product-update-post',
            'product-delete',
            'brand-add-post',
            'brand-update-post',
            'brand-delete',
            'type-add-post',
            'type-update-post',
            'type-delete',
            'home-selection-update-post',
        ];

        $csrfTokenToCheckInGet = [
            'user-add',
            'user-update',
            'user-list',
            'category-add',
            'category-update',
            'category-list',
            'product-add',
            'product-update',
            'product-list',
            'brand-add',
            'brand-update',
            'brand-list',
            'type-add',
            'type-update',
            'type-list',
            'home-selection-update',
        ];
        // Si la route correspond à une requête GET nécessitant un token CSRF
        // (par exemple pour sécuriser un formulaire avant sa soumission)
        if (in_array($routeName, $csrfTokenToCheckInGet)) {
            // Génère un token CSRF unique et le stocke dans la session
            // Ce token sera inclus dans le formulaire pour être vérifié lors de la soumission
            $_SESSION['token'] = bin2hex(random_bytes(32));
        }
        // Si la route correspond à une requête POST nécessitant une vérification du token CSRF
        elseif (in_array($routeName, $csrfTokenToCheckInPost)) {
            // Récupère le token CSRF envoyé via le formulaire soumis (méthode POST)
            $token = filter_input(INPUT_POST, 'token', FILTER_SANITIZE_SPECIAL_CHARS);
            // Initialisation du token à une chaîne vide si le token est absent dans POST
            $token =  "";
            // Vérifie si le token est présent dans les données POST
            if (isset($_POST['token'])) {
                $token = $_POST['token'];
            // Si non, vérifie si le token est passé dans l'URL via GET 
            } elseif (isset($_GET['token'])) {
                $token = $_GET['token'];
            }
            // Récupère le token CSRF stocké dans la session pour comparaison
            $sessionToken = isset($_SESSION['token']) ? $_SESSION['token'] : '';
            // Vérifie si le token soumis ne correspond pas au token stocké dans la session
            // ou si le token est vide (ce qui indiquerait une soumission non sécurisée)
            if ($token !== $sessionToken || empty($token)) {
                // Si le token ne correspond pas ou est absent, renvoie un code d'erreur 403 (Accès interdit)
                http_response_code(403);
                exit("Erreur 403"); // Arrête l'exécution du script pour empêcher toute action non autorisée
            } else {
                // Si le token est valide, on le retire de la session pour éviter sa réutilisation
                unset($_SESSION['token']);
            }
        }
    }
    /**
     * Méthode permettant d'afficher du code HTML en se basant sur les views
     *
     * @param string $viewName4 Nom du fichier de vue
     * @param array $viewData Tableau des données à transmettre aux vues
     * @return void
     */
    protected function show(string $viewName, $viewData = [])
    {
        $router = $this->router;
        // Comme $viewData est déclarée comme paramètre de la méthode show()
        // les vues y ont accès
        // ici une valeur dont on a besoin sur TOUTES les vues
        // donc on la définit dans show()
        $viewData['currentPage'] = $viewName;

        // définir l'url absolue pour nos assets
        $viewData['assetsBaseUri'] = $_SERVER['BASE_URI'] . 'assets/';
        // définir l'url absolue pour la racine du site
        // /!\ != racine projet, ici on parle du répertoire public/
        $viewData['baseUri'] = $_SERVER['BASE_URI'];

        // On veut désormais accéder aux données de $viewData, mais sans accéder au tableau
        // La fonction extract permet de créer une variable pour chaque élément du tableau passé en argument
        extract($viewData);

        // => la variable $currentPage existe désormais, et sa valeur est $viewName
        // => la variable $assetsBaseUri existe désormais, et sa valeur est $_SERVER['BASE_URI'] . '/assets/'
        // => la variable $baseUri existe désormais, et sa valeur est $_SERVER['BASE_URI']
        // => il en va de même pour chaque élément du tableau

        // $viewData est disponible dans chaque fichier de vue



        require_once __DIR__ . '/../views/layout/header.tpl.php';
        require_once __DIR__ . '/../views/' . $viewName . '.tpl.php';
        require_once __DIR__ . '/../views/layout/footer.tpl.php';
    }

    protected function checkAuthorization($roles = [])
    {
        // Si le user est connecté
        if (isset($_SESSION['userId'])) {
            // Alors on récupère l'utilisateur connecté
            $currentUser = $_SESSION['userObject'];
            // Puis on récupère son role
            $currentUserRole = $currentUser->getRole();
            // si le role fait partie des roles autorisées (fournis en paramètres)
            if (in_array($currentUserRole, $roles)) {
                // Alors on retourne vrai
                return true;
            }
            // Sinon le user connecté n'a pas la permission d'accéder à la page
            else {
                // => on envoie le header "403 Forbidden"
                http_response_code(403);
                // Enfin on arrête le script pour que la page demandée ne s'affiche pas
                exit("Erreur 403");
            }
        }
        // Sinon, l'internaute n'est pas connecté à un compte
        else {
            // Alors on le redirige vers la page de connexion
            $loginPageUrl = $this->router->generate('user-login');
            header('Location: ' . $loginPageUrl);
            exit();
        }
    }
}
