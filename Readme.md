# AdminLogPurge

## Description

**AdminLogPurge** est un module Thelia permettant de supprimer facilement les anciens logs d'administration depuis le back-office ou en ligne de commande. Ce module est utile pour alléger la base de données et améliorer les performances de votre boutique.

---

## Installation

1. **Téléchargez** ou clonez ce dépôt dans le dossier `local/modules/` de votre installation Thelia.
2. **Activez** le module depuis le back-office de Thelia (`Configuration > Modules`).
3. Le module est prêt à être utilisé.

---

## Utilisation

### Depuis le back-office

1. Rendez-vous dans le menu `Modules > Suppression des logs Admin`.
2. Choisissez la date à partir de laquelle vous souhaitez supprimer les logs.
3. Cliquez sur le bouton **OK** pour lancer la suppression.
4. Un message de confirmation s'affichera avec le nombre de logs supprimés.

### Depuis la ligne de commande

Vous pouvez également lancer la purge via la console Thelia :

```bash
php Thelia adminLog:purge --day=30
```
