#### NOTE IMPORTANTE : 

* **Contrairement aux TPs du lot 1 (TPs 1 à 5), les TPs du lot 2 vous pousseront à beaucoup plus d'autonomie et de réflexion personnelle.**

* Ces TPs ne contiendront donc pas les commandes Symfony déjà utilisées, car vous pouvez les retrouver dans les précédents TP ou **via des recherches Google**
* Seuls les nouvelles connaissances seront détaillées. 
* Le lot 2 a pour but **d'évaluer votre capacité à implémenter par vous-mêmes les fonctionnalités** du cahier des charges
* Les TPs contiendront tout de mêmes des indices des solutions possibles, mais sans vous donner la réponse. 

___

# Lot 2 - Espace Client

## Modifier l'entité `User`

Tel que présenté dans le cahier des charges, les utilisateurs doivent renseigner des informations suivantes pour s'inscrire : 
* **Nom**
* **Prénom**
* **Civilité**
* **Date de naissance** (qui donne l'age)
* **Email**
* _Téléphone_
* _Ville_
* _Code Postal_
* _Pays_
* _Numéro de sécu_


> Pour faire cela, utiliser la commande `php bin/console make:entity`.
> 
> Pour ne pas avoir de problèmes lors de la mise à jour de la BdD, faites en sorte que les nouvelles propriétés ajoutées puissent être null, ou videz la table `user`

## Modifier le formulaire d'inscription

* Ajouter au formulaire `RegistrationFormType` l'attribut `required => true` à tous les champs obligatoires (ceux indiqués en gras ci-dessus), exemple : 

```php 
    ->add('propriété', null, [
            'label' => "à vous de choisir le label qui convient - et indiquer à l'utilisateur si le champ est obligatoire ou facultatif"
            'required' => true
    ])
```


## Créer l'espace client
Maintenant que l'administration des utilisateurs est en place, vous pouvez facilement modifier le rôle des utilisateurs.

Pour mettre en place l'espace client, la procédure est la suivante : 

* Reprendre `UserController` et préfixer les routes par `mon-espace-client` : 

```php
/**
 * @Route("/mon-espace-client")
 */
class UserController extends AbstractController
```

* Créer un dossier `templates/espace-client` pour stocker les templates de l'espace utilisateur.
* Créer un nouveau template `layout.html.twig` dans ce dossier. Vous pouvez vous baser sur les autres fichiers `layout.html.twig` créés dans les précédents TP.
* Utiliser la fonction `index` de `UserController` comme page d'accueil de l'espace client.
> L'idée est d'intégrer le formulaire de l'utilisateur dans la page d'accueil de l'espace client
* Créer un nouveau formulaire pour l'entité `User` grâce à la commande `php bin/console make:form`. Vous pouvez nommer ce formulaire `UserType`.
  * Ce formulaire doit contenir les propriétés obligatoires et facultatives sauf :
    * l'email
    * Le mot de passe

* Ajouter le formulaire de l'utilisateur dans la page d'accueil de l'espace client (`UserController`)

```php
/**
 * @Route("", name="user_home", methods={"GET","POST"})
 */
public function index(UserRepository $userRepository, Request $request): Response
{
    // Récupérer l'utilisateur connecté
    $user = $this->getUser(); 

    // Créer un formulaire lié à ce utilisateur
    $form = $this->createForm(UserType::class, $user);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
        $this->getDoctrine()->getManager()->flush();

    }

    return $this->render('espace-client/index.html.twig', [
        'form' => $form->createView()
    ]);
}
```

## Créer l'espace agent 

De la même manière que vous avez créé l'espace client, vous pouvez créer un espace pour les agents

* Pour bien séparer ce qui concernera l'espace agent, créez un controller `AgentController`.
> Pour l'instant ce controller peut ne contenir qu'une fonction.
> Par la suite nous viendrons ajouter des fonctions pour administrer les souscriptions des clients

```php
/**
 * @Route("/mon-espace-agent")
 */
class AgentController extends AbstractController
```

* Créer un dossier `templates/espace-agent` pour stocker les templates de l'espace agent
* Créer un nouveau template `layout.html.twig` dans ce dossier. Vous pouvez vous baser sur les autres fichiers `layout.html.twig` créés dans les précédents TP.

### Sécuriser les espaces utilisateurs selon les rôles

Modifier le fichier `config/packages/security.yml` : 
```
    role_hierarchy:
        ROLE_ADMIN: ROLE_AGENT, ROLE_USER
        ROLE_AGENT: ROLE_USER
        
    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/mon-espace-agent, roles: ROLE_AGENT }
        - { path: ^/mon-espace-client, roles: ROLE_USER }
```

### Tests 

Faites les tests suivants pour vérifier que tout est sécurisé :
* Modifiez les utilisateurs de manière à avoir 1 administrateur, 1 agent, et 1 client
* Tentez de vous connecter à des espaces interdits, par exemple : se connecter à l'espace agent, avec un compte client / ou de vous connecter à l'espace admin avec un compte agent
