# Symfony-5-L3

## Projet
Un grand groupe de résidences service senior souhaite refondre son site web grand public, pour optimiser sa visiblité, son image, et augmenter le trafic sur leur site.

### Contexte
Le projet est développé en interne mais le groupe de possède pas de développeur expérimenté. 
Lors du confinement, la société a engagé deux stagiaires qui ont : 
* établi le cahier des charges
* développé un socle avec Symfony 5
* récupéré et intégré une charte graphique

Les développeurs étant stagiaires, le site n'a pas été terminé, et de nombreux bugs existent.

Dans ce cadre là, vous intervenez en tant que SSII pour reprendre l'existant, que le client souhaite garder, et vous devez intégrer les fonctionnalité listées par les stagiaires.

Avant de la mettre le site en production, le client souhaite passer une phase de recette pour s'assurer que le site est prêt et qu'il est conforme à la demande.

### Objectifs
Livrer une version du site grand public prête à être mise en ligne par le client.
Le livrable doit être exempt de bugs, comprendre le maximum de fonctionnalités, être estétiquement beau et adapté aux smartphones, tablettes, et écran de bureau.

### Cahier des charges

#### Fonctionnalités 

0. Navigation
1. Actualités
2. Offres
3. Contact
4. Authentification
5. Espace administration / Gestion des utilisateurs
6. Espace client / Compte client 
7. Espace communication / rédaction du contenu

##### Navigation 

> L'utilisateur doit être capable de naviguer dans le site à travers un menu principal.
>
> Les liens des menus sont automatiquement générés à partir des informations saises dans l'espace administration

> Certaines zones/informations du site doivent être accessibles depuis toutes les pages, telles que :
> * Bannière / Entête / Pied de page
> * Liens vers l'espace client
> * Pages/liste des offres
> * Résidences principales (Paris, Lyon, Bordeau, Marseille, Brest)
> * Dernières actualités
> * Liens vers la page des résidences
> * Lien de contact

##### Actualités

> Le rédacteur de contenu doit pouvoir créer des articles comprenants : 
> * Une bannière composée d'un titre, d'un sous titre, et d'une image 
> * Un corps de texte, avec la possibilité de formater le texte (italique, gras, souligné), d'ajouter des liens et des images
> * Une catégorie, un article peut avoir plusieurs catégories

> La liste des articles doit être accessible depuis la page d'accueil

> La liste des articles comprend : 
> * Une grille des catégories d'articles 
> * La liste des articles des plus récents aux plus anciens

> La page d'un article comprend :
> * La bannière de l'article
> * Le corps de l'article
> * Une grille horizontale d'autres articles de la même catégorie
> 

##### Offres

> La liste des offres est administrable depuis l'espace d'admin

> Une offre est composée des éléments suivants :
> * Titre
> * Image bannière
> * Texte d'introduction
> * Texte de l'offre
> * éléments Texte/Image (lot 2)
> * Prix
> * Plaquette PDF

> **Lot 2 : Demande de souscription à une offre**
>
> L'utilisateur peut souscrire à une offre, en saisissant les informations suivantes :
> * Nom / prénom
> * Téléphone
> * Mail 


##### Contact

> L'utilisateur peut envoyer une demande de contact via un formulaire qui comprend les champs obligatoires suivants : 

> * Nom
> * Email
> * Objet
> * Message
> * Bouton envoyer

> La liste des demandes de contact doit être disponible via l'espace communication

##### Authentification

> L'utilisateur doit pouvoir se connecter sur le site, via un nom d'utilisateur et un mot de passe.
>  
> Pour un profil du métier, la création du compte peut être faite en contactant l'administrateur 

> **Lot 2** 
>
> Un compte utilisateur ne peut être activé que manuellement par l'administrateur.
> 
> L'utilisateur peut consulter l'offre à laquelle il a souscrit 


##### Espace administration

###### Administration des paramètres

> * Email de contact
> * Titre du site (utilisé pour le nom des onglets)
> 

> L'administrateur peut mettre le site en mode maintenance

###### Gestion des utilisateurs

> L'administrateur peut consulter/éditer/bloquer/débloquer des comptes utilisateurs.


##### Espace communication 

###### Demandes de contact

> L'espace com' permet de consulter la liste des demandes de contact

###### Rédaction du contenu

> L'espace com' permet de consulter/créer/éditer/supprimer des articles et des catégories d'articles. 

##### Lot 2 : Espace client

Tout utilisateur peut créer un compte sur le site.

###### Compte client


* Nom Prénom (obligatoire)
* Civilité
* Date de naissance (qui donne l'age)
* Email (obligatoire)
* Téléphone 
* Adresse
    - Ville
    - Code Postal
    - Pays
* Numéro de sécu

Numéro client généré automatiquement


Les champs facultatifs à l'inscription doivent être obligatoirement saisis pour souscrire à une offre

Partie "Contact" (personne à contacter / médecin traitant / membres de la famille) 

###### Compte agent

Les agents doivent pouvoir consulter la liste des souscriptions aux offres, et changer le statut des offres. 
