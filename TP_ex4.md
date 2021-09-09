
### Installation du profiler

`composer require --dev symfony/profiler-pack`

# Création de la page d'accueil

Pour mettre en place page d'accueil, inspirez-vous de ce qui a été fait dans l'exercice 3.

Quelques indications pour vous aider : 

### Création de l'entité et du CRUD

* Créer une entité `Homepage` avec comme propriétés :
    * `title` : type `string` - Titre principal de la page
    * `body` : type `text` - Texte sous le titre principal
    * `titleAbout` : type `string` - Titre de la section "À propos" 
    * `textAbout` : type `text` - Texte sous le titre "À propos"
* Créer le CRUD pour l'entité `Homepage`
    * Modifier les templates TWIG de manière à séparer les pages de l'espace public de celle de l'espace d'administration, comme déjà vu dans les exercices précédents.
 
### Modification des Controllers et des routes

> `HomepageController` va devenir le point d'entrée du site, mais une partie sera dans l'administration, pour la création et l'édition de la page, et l'autre sera la partie publique. 
> 
> Vous avez donc deux possibilités pour organiser les actions dans les controller :

* Solution 1 : Modifier les routes de `HomepageController` pour que certaines soient préfixées par `/admin` 
    * Penser à retirer la première annotation `@Route` au dessus de la classe `HomepageController`
* Solution 2 : Coupez-coller les actions `index`, `new`, `edit`, et `delete` dans `AdminController` 
    * Penser à renommer les actions pour qu'on sache qu'il s'agit de l'entité `Homepage`
        * `indexHomepage`, `newHomepage`, `editHomepage`, et `deleteHomepage`
    * Vérifier que tous les imports `use` soient bien en place dans `AdminController`

> Configuration de la page d'accueil du site

* Modifier le fichier `config/routes.yaml` : 
```yaml
index:
    path: /
    controller: App\Controller\HomepageController::show
```

> Il ne doit y avoir qu'une seule page d'accueil existante !
* Modifier l'action `show` de `HomepageController` :
    * Retourner systématiquement la première page d'accueil de la liste
    * Supprimer l'annotation de la route 
    * (TWIG) Remplacer la route `homepage_show` par `index`, et modifier retirer pour ces liens le paramètre `, {'id': homepage.id}`

```php
    
    public function show(HomepageRepository $homepageRepository): Response
    {
        return $this->render('homepage/show.html.twig', [
            'homepage' => $homepageRepository->findAll()[0],
        ]);
    }
```


### Design de la page d'accueil

* Reprendre les éléments graphiques existants pour la page d'accueil
    * Garder les images existantes, nous les remplacerons dans un futur TP
    * Remplacer les titres
    * Remplacer les textes

> Liens vers la page d'accueil
* Remplacer les liens `test_entity_index` par le nom de route `index` 

> Pour l'espace d'administration
* (TWIG) Afficher le lien "Create new" s'il n'existe aucune page d'accueil
* (TWIG) À l'inverse ne pas afficher le lien "Create new" s'il exsite déjà une page d'accueil

> Supprimer l'entité inutile `TestEntity`
* Supprimer les fichiers liés à `TestEntity`
    * Dossier `templates/test_entity`
    * Fichiers `TestEntityController.php` / `TestEntity.php` / `TestEntityType.php` / `TestEntityRepository.php`
    
