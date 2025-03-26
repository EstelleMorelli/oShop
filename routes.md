## DICO DES ROUTES :

| URL | HTTP Method | Controller | Method | Title | Content | Comment |
|--|--|--|--|--|--|--|
| `/` | `GET` | `MainController` | `home` | backOffice | 2 tableaux : Liste des catégories et LIste des produits | - |
| `/category/list` | `GET` | `CategoryController` | `list` | Categories List | Liste de toutes les catégories de la BDD | - |
| `/category/add` | `GET` | `CategoryController` | `add` | Ajouter une catégorie | Ajouter une catégorie à la BDD | - |
| `/category/[i:categoryId]/update` | `GET` | `CategoryController` | `update` | Modifier les données d'une catégorie | Modifier les données d'une catégorie dans la BDD ciblé par son ID| - |
| `/product/list` | `GET` | `ProductController` | `list` | Products List | Liste de tous les produits de la BDD | - |
| `/product/add` | `GET` | `ProductController` | `add` | Ajouter un produit | Ajouter un produit à la BDD | - |
| `/product/[i:productId]/update` | `GET` | `ProductController` | `update` | Modifier les données d'un produit | Modifier les données d'un produit dans la BDD ciblé par son ID | - |
| `/brand/list` | `GET` | `BrandController` | `list` | Categories List | Liste de toutes les catégories de la BDD | - |
| `/brand/add` | `GET` | `BrandController` | `add` | Ajouter une catégorie | Ajouter une catégorie à la BDD | - |
| `/brand/[i:brandId]/update` | `GET` | `BrandController` | `update` | Modifier les données d'une catégorie | Modifier les données d'une catégorie dans la BDD ciblé par son ID| - |
| `/type/list` | `GET` | `TypeController` | `list` | Categories List | Liste de toutes les catégories de la BDD | - |
| `/type/add` | `GET` | `TypeController` | `add` | Ajouter une catégorie | Ajouter une catégorie à la BDD | - |
| `/type/[i:typeId]/update` | `GET` | `TypeController` | `update` | Modifier les données d'une catégorie | Modifier les données d'une catégorie dans la BDD ciblé par son ID| - |