# Page de contact

Nous allons maintenant ajouter un formulaire de contact à notre site.

Pour répertorier les demandes de contact, il faut voir chaque demande comme une ligne en base de donnée.
Comme demandé dans le cahier des charges, chaque demande de contact est composée des éléments suivants : 
* Nom
* Email
* Objet
* Message

### Création de l'entité Contact

* Utiliser la commande création d'entité `php bin/console make:entity`
* Indiquer comme nom de classe `Contact`
* Les types des propriétés sont les suivantes : 
    * Nom : `string`
    * Email : `string`
    * Objet : `string`
    * Message : `text`   
* **Ne pas oublier d'exécuter les commandes de migration pour mettre à jour la BDD**
    

### Création du CRUD
> Avant de créer le CRUD de l'entité `Contact`, pensez à supprimer les fichiers `templates/contact/index.html.twig` et `Controller/ContactController.php`

* Lancer la commande `php bin/console make:crud`
    * Indiquez la classe `Contact` comme objet concerné par le CRUD

### Administration de la liste des demandes

De la même manière dont vous avez intégré la liste des articles à l'espace d'administration (cf. TP_ex2), intégrez la liste des demandes de contact à l'espace d'administration.

Dans `templates/contact/index.html.twig`, remplacez la ligne `{% extends 'base.html.twig' %}` par `{% extends 'admin/layout.html.twig' %}`

Pour concerver la même arborsence des URLs de l'espace d'administration, il faut modifier `AdminController` pour intégrer la page de la liste des demandes de contact : 

Le code suivant présente une manière de donner une base d'URL à toutes les actions de AdminController :
 
```php
/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_index")
     */
    public function index()

```

Partant de là, vous pouvez couper-coller la fonction `index`  de `ContactController` dans `AdminController`, en préfixant la route avec le terme `/contact/`. 

**Penser à modifier le nom de l'action, par exemple `indexContact`, sinon il y aura un conflit avec l'action `index` déjà existante.**

> Remarque : Le CRUD va créer des nouveaux noms de route, par exemple la route `contact_new` qui permet d'accéder au formulaire de contact. 
> 
>L'absence de la route `contact` qui est utilisée par certains templates va déclencher un bug.
> 
>Pensez donc à modifier dans les templates les endroits où il y a l'utilisation du nom de route `contact` en les remplaçant par `contact_new`. 

Une fois ces modifications effectuées, en accédant à la page `/admin/contact`, vous devriez vous trouver dans l'espace d'administration, et voir le tableau des demandes de contact.

> N'oubliez pas d'ajouter un lien vers cette page dans la barre de navigation d'administration dans le fichier `admin/layout.html.twig`

```twig
{% block navbar_links %}
    <li><a class="nav-link active" href="{{ path('article_index')}}">Actualités</a></li>
    <li><a class="nav-link active" href="{{ path('contact_index')}}">Demandes de contact</a></li>
{% endblock %}
```

### Intégration du formulaire de contact au site

Maintenant que l'on peut consulter les demandes de contact, nous allons intégrer à l'espace public la page de demande de contact.

Pour cela suivez les étapes suivantes : 
* Modifier la ligne `{% extends 'base.html.twig' %}` de `contact/new.html.twig` pour hériter du template `public/layout.html.twig`
* Modifier l'URL de la page de demande de contact. Actuellement l'URL est `/contact/new`. Modifiez la fonction `new` de `ContactController` pour que l'URL devienne simplement `/contact`.

## Améliorer le design des formulaires 

Modifiez le fichier `config/packages/twig.yaml` en ajoutant la ligne `form_themes: ['bootstrap_4_layout.html.twig']` :

```yaml
twig:
    default_path: '%kernel.project_dir%/templates'
    form_themes: ['bootstrap_4_layout.html.twig']
```

Cette astuce vient de la [documentation officielle de Symfony](https://symfony.com/doc/current/form/bootstrap4.html) 

#### Amélioration du formulaire de contact

Améliorons le formulaire de contact en modifiant le fichier `Form/ContactType.php`.

* Préciser le type de champ `EmailType` pour la propriété `email`
* Ajouter le bouton de soumission de formulaire `->add('Envoyer', SubmitType::class)`
    * Retirer la ligne `<button class="btn">{{ button_label|default('Save') }}</button>` du template TWIG du formulaire `contact/_form.html.twig`
* Vous pouvez redéfinir les labels et le texte d'aide à l'intérieur (`placeholder`) des champs.
    * Pensez à faire la même chose pour les autres champs, **ça vous évitera des points en moins sur la note de TP**

```php
    // ....
    $builder
        ->add('name', null, [
            'label' => "Nom",
            'attr' => [
                'placeholder' => 'Saisissez votre nom'
            ]
        ])
        ->add('email', EmailType::class)
        ->add('subject')
        ->add('message')
        ->add('Envoyer', SubmitType::class)
    ;
```

Si votre IDE ne fait pas les imports automatiquement, pensez à ajouter les lignes suivantes : 

```php
//...
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
//...

class ContactType extends AbstractType
```

Pour embellir la page de demande de contact :
* Reprendre le HTML du titre de la page qui liste les articles
* Supprimer le lien qui permet d'accéder à la liste des demandes `<a href="{{ path('contact_index') }}">back to list</a>`  

```twig
<div class="section layout_padding padding_top_0">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="full">
                    <div class="heading_main text_align_center">
                        <h2><span class="theme_color"></span>Contactez-nous</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                {{ include('contact/_form.html.twig') }}
            </div>
        </div>
    </div>
</div>
```

##### Confirmation de soumission de formulaire

Actuellement, si vous soumettez le formulaire de contact, vous allez être redirigé vers l'espace d'administration.

Nous allons donc modifier ce qui se passe après l'enregistrement de la demande.

Modifions le fichier `ContactController` : 
* Ajouter un message de confirmation après l'enregistrement d'une demande : 
```php

    public function new(Request $request): Response
    {
        //...
        $entityManager->flush();
        $this->addFlash('success', 'Écrivez le message de confirmation ici');
        //...
    }
```
* Modifier la route de redirection : 
```php
    $this->addFlash('success', 'Écrivez le message de confirmation ici');
    return $this->redirectToRoute('test_entity_index');
```
* Pour afficher les "flash messages", ajoutez les lignes suivantes dans le template `public/layout.html.twig` **au dessus du block `body`**  : 
```twig
{% for message in app.flashes('success') %}
    <div class="alert alert-success">
        {{ message }}
    </div>
{% endfor %}
``` 

**>> Testez la soumission du formulaire <<**

## Points supplémentaires à prendre sur la note de TP

### Ajouter une propriété de date de création de la demande
Pour avoir un meilleur suivi des demandes de contact, ajoutez une propriété `created` de type `date` à l'entité `Contact`.

> Ré-utiliser la commande `php bin/console make:entity` pour gagner du temps

Une fois la propriété ajoutée, modifier `ContactController` pour initialiser la date de création de la demande :
> Il ne faut pas ajouter cette propriété dans le formulaire, nous allons initialiser la date automatiquement
* Modifier l'action `new` : 
```php
    //...
    if ($form->isSubmitted() && $form->isValid()) {
        $entityManager = $this->getDoctrine()->getManager();
        
        // Initialiser la date au jour même
        $contact->setCreated(new \DateTime());

        $entityManager->persist($contact);
    //...
```
* Ajouter au tableau de la liste des demandes de contact, la nouvelle propriété 
```twig
    <td>{{ contact.created|date('d/m/Y') }}</td>
```
* Supprimer les colonnes `Id` et `actions` du tableau
* Modifier le titre de la page, `Contact Index` ne veut rien dire pour l'administrateur.
* Supprimer le lien "Create new"
