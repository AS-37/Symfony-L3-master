
# Exercice 1 

## Créer l'espace actualités

### Création des articles

L'entité Article existe déjà dans le dossier `src/Entity`

* Propriétés existantes :
    * Titre
    * Contenu texte de l'article
    * Date de création (`created`)
* Utiliser la commande `php bin/console make:entity` pour modifier l'article et lui ajouter une propriété `subtitle` 

### Création des catégories d'articles

* Créer l'entité Category : `php bin/console make:entity`
    * Propriétés : 
        * Nom
* Créer le Crud de la Category : `php bin/console make:crud`
* Crud signifie : Create/Read/Update/Delete
    * La commande vous demande le nom de l'entité pour laquelle vous souhaitez créer un crud
* Cette commande va vous créer : 
    * Controller / Routes
    * Formulaire
* Modifier l'entité Article pour faire une liaison avec l'entité Category
    * Lancer la commande `php bin/console make:entity`
        * Indiquer le nom de l'entité à modifier (`Article`)
        * Choisir le type de propriété `relation`
            * _Dans le cahier des charges il est indiqué "un article peut avoir plusieurs catégories"_
            * La relation à choisir est donc __ManyToMany__
            * Indiquez ensuite à quelle entité est lié l'article : `Category`
            * Validez
                        
* Mettre à jour la base de données : 
    * Créer les fichiers de migration : ` php bin/console make:migration`
    * Lancer la mise à jour de la BDD : ` php bin/console doctrine:migrations:migrate`
         


