#### NOTE IMPORTANTE : 

* **Contrairement aux TPs du lot 1 (TPs 1 à 5), les TPs du lot 2 vous pousseront à beaucoup plus d'autonomie et de réflexion personnelle.**

* Ces TPs ne contiendront donc pas les commandes Symfony déjà utilisées, car vous pouvez les retrouver dans les précédents TP ou **via des recherches Google**
* Seuls les nouvelles connaissances seront détaillées. 
* Le lot 2 a pour but **d'évaluer votre capacité à implémenter par vous-mêmes les fonctionnalités** du cahier des charges
* Les TPs contiendront tout de mêmes des indices des solutions possibles, mais sans vous donner la réponse. 

___

# Lot 2 - Souscription à une offre

La souscription aux offres a été présentée dans la 3ème présentation de Symfony, et des concepts avancés.

## Création des entités et des relations

Vous trouverez ci-dessous un rappel des entités à créer et des relations à mettre en place.

Vous pouvez créer les entités dans l'ordre que vous voulez, l'important est de toute façon de **créer les entités avant de créer les relations**. 

### Créer l'entité `Offer`

L'entité `Offer` doit avoir les propriétés suivantes :
* titre : `string`
* texte d'introduction : `text`
* texte de l'offre : `text`
* prix : `float`

### Créer l'entité `Souscription`

L'entité `Souscription` doit avoir la propriété suivante : 
* état : `string` 
> Vous pouvez choisir un autre type comme propriété, par exemple `integer`
> 
> Le type `boolean` est déconseillé, car ça empêcherait à l'avenir de rajouter des nouveaux états

### Ajout des relations
> Comme décrit dans le support de cours, il faut ajouter des nouvelles relations entre ces nouvelles entités
* Ajouter une relation `OneToMany` de l'entité `User` vers `Souscription`
* Ajouter une relation `ManyToOne` de l'entité `Souscription` vers `Offer`

> Vous n'êtes pas forcément obligé de créer les relations dans _ce sens_. 
> _La relation `OneToMany` peut être remplacée par la relation `ManyToOne` en inversant les entités._

> Lors de l'exécution de la commande `make:entity`, **lisez bien ce que la console vous demande** :
> 
> Il est primordial de :
> * **pouvoir accéder à l'utilisateur lié à une souscription**
> * **pouvoir accéder à l'offre liée à une souscription**

## Souscrire à une offre

#### Liste des souscriptions d'un utilisateur

Pour le moment vous n'avez pas encore créé de souscription, mais nous allons tout de même préparer le page de l'espace client qui viendra lister les souscription à des offres.

Pour cela il vous faudra (dans `UserController` de préférence) :
* Créer une nouvelle route, exemple `@Route("/mes-souscriptions", name="user_souscriptions")` associée à une fonction
* Récupérer l'utilisateur connecté `$user = $this->getUser();`
* Récupérer les souscriptions de l'utilisateur : `$user->getSouscriptions();`
* Retourner un template TWIG avec les souscriptions en paramètre.

#### CRUD de l'entité `Offer`

Avant de mettre en place la souscription à une offre, vous aurez besoin de :
* Créer un CRUD de l'entité `Offer`
* Ajouter une liste des offres dans l'espace d'administration
    * Réutiliser la fonction `index` de `OfferController`
    * Réutiliser le template `templates/offer/index.html.twig` généré par le CRUD
    
* Modifier les templates qu'il faut pour séparer la partie administration et publique.

#### Construction de l'entité `Souscription`
____
**_Explication préalable : Vous pouvez remarquer qu'une souscription ne peut pas exister sans un utilisateur et une offre._**
___

Il faut donc ajouter la fonction `public function __construct()` dans l'entité `Souscription`.

_Cette fonction est native à n'importe quel objet PHP._  Elle permet d'initialiser les valeurs de l'objet **uniquement à sa création**. Voir la [documentation PHP](https://www.php.net/manual/fr/language.oop5.decon.php) 

Cette fonction doit 
 * prendre 2 arguments, `$user` ( de type `User`), et `$offer` (de type `Offer`).
 * initialiser le statut par défaut ("en attente")
___


### Modifier l'entité `User`

Tel que présenté dans le cahier des charges, les utilisateurs doivent renseigner des informations suivantes pour souscrire à une offre, en plus des informations obligatoires, ajoutée dans le TP n°7 : 
* _Téléphone_
* _Ville_
* _Code postal_
* _Pays_
* _Numéro de sécurité sociale_

> Pour faire cela, utiliser la commande `php bin/console make:entity`.
> 
> Pour ne pas avoir de problèmes lors de la mise à jour de la BdD, faites en sorte que les nouvelles propriétés ajoutées puissent être null, ou sinon videz la table `user`

#### Modifier le formulaire d'inscription

* Ajouter au formulaire `UserType` l'attribut `required => false` à tous les champs nécessaires à la souscription à une offre, exemple : 
```php 
    ->add('propriété', null, [
            'required' => false
    ])
```

> Sur ce point vous êtes tout à fait libre de créer un nouveau formulaire, rien que pour ces champs. Mais il vous faudra par la suite penser à rediriger l'utilisateur vers ce nouveau formulaire lors du processus de souscription.

___
#### Points bonus

Les propriétés _Téléphone_ _Code postal_ et _Numéro de sécurité sociale_ répondent à certaines contraintes.

* Le n° de téléphone doit contenir **10 chiffres**
> Regex N° téléphone : `^(?:(?:\+|00)33|0)\s*[1-9](?:[\s.-]*\d{2}){4}$`
* Le code postal en contient **4 ou 5**
> Regex code postal : `^(([0-8][0-9])|(9[0-5]))[0-9]{3}$`
* Le numéro de sécurité sociale répond 
> Regex numéro de sécurité sociale (ou N° INSEE) : `^[12][0-9]{2}[0-1][0-9](2[AB]|[0-9]{2})[0-9]{3}[0-9]{3}[0-9]{2}$`

Symfony permet de mettre en place des contraintes sur la valeur des champs pour les entités : Voir la [documentation](https://symfony.com/doc/current/reference/constraints/Regex.html#basic-usage)
> Privilégiez l'usage des annotations PHP 
___

### Nouvelle route pour souscrire à une offre

Dans la page publique qui affiche une offre (ou directement dans la liste des offres), ajouter un lien "Souscrire".

Ce lien doit appeler **une nouvelle route** qui prendra en paramètre l'`id` de l'offre en question.

> Vous pouvez vous inspirer de la fonction `show` de `OfferController`. 

La nouvelle fonction (par exemple `subscribeToOffer`) liée à la nouvelle route (par exemple `subscribe_to_offer`) que vous allez créer dans `OfferController`, doit contrôler les points suivants : 
* Est-ce que l'utilisateur est connecté ? 
    * Si l'utilisateur est connecté (`$this->getUser()` retourne un objet de type `User`)
        * Est-ce que l'utilisateur a rempli les informations obligatoires pour souscrire à une offre ?
            * Si oui
                * Est-ce que l'utilisateur a déjà souscrit à cette offre ?
                    * Si oui
                        * Ajouter un message flash pour indiquer à l'utilisateur qu'il ne peut pas souscrire deux fois à la même offre
                        * Rediriger vers la page de l'espace utilisateur qui liste les souscriptions  
                    * Sinon
                        * Créer une nouvelle souscription à partir de l'offre et de l'utilisateur
                        * Ajouter à l'utilisateur cette souscription
                        * Ajouter à l'offre cette souscription
                        * Sauvegarder en BDD l'utilisateur, la souscription et l'offre
            * Sinon
                * Ajouter un message flash pour indiquer à l'utilisateur qu'il doit saisir les informations obligatoires
                * Rediriger vers la page de l'espace utilisateur pour modifier les informations obligatoires
    * Sinon
        * Ajouter un message flash (`$this->addFlash`) pour indiquer à l'utilisateur qu'il doit être connecté pour souscrire à une offre
        * Rediriger vers la page de connexion

> Vous remarquerez que la liste ci-dessus ressemble fortement à une succession de condtions, et donc à un algorithme.
>
> Ces conditions peuvent évidemment être écrites différement.
>
> L'objectif principal ici, est que le processus de souscription à une offre soit respecté, à savoir :
>   * un utilisateur doit être connecté pour souscrire à une offre
>   * un utilisateur doit avoir rempli les champs obligatoires pour souscrire à une offre
>   * un utilisateur ne peut pas souscrire plus d'une fois à la même offre

## Gestion des souscriptions

Dans le TP 7 vous avez mis en place l'espace agent.
L'objectif ce cette section est de pouvoir modifier le statut des souscriptions depuis l'espace agent.

Il vous faudra :
* Créer un CRUD de l'entité `Souscription`
* Adapter les templates pour qu'ils s'intègrent à l'espace agent
* Adapter le formulaire `Souscription` pour pouvoir modifier le staut de la souscription
    * **On ne doit pas pouvoir modifier ni l'utilisateur, ni l'offre d'une souscription.**

## Visualisation des offres et de leurs souscriptions

Pour des questions marketing, le client souhaite avoir un moyen simple de consulter les offres qui sont les plus souscrites.

Ajoutez donc à la liste des offres de l'espace d'administration, le nombre de souscriptions pour chaque offre.
>Astuce TWIG pour récupérer la longueur d'une tableau : `tableau|length`
