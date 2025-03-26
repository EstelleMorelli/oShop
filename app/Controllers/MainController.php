<?php

namespace App\Controllers;


use App\Models\Category;
use App\Models\Product;

class MainController extends CoreController
{
    /**
     * Méthode s'occupant de la page d'accueil
     *
     * @return void
     */
    public function home()
    {
        $categoryHomeList = Category::findHomeList();
        $productHomeList = Product::findHomeList();
        $this->show('main/home', ['csrfToken'=> $_SESSION['token'], 'productHomeList' => $productHomeList, 'categoryHomeList' => $categoryHomeList]);
    }
}
