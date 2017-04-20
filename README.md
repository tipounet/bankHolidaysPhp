# bankHolidaysPhp
Utilitaires permettant d'obtenir les jours fériés Français fixe et flottant pour une année donnée.

Les jours fériés flottant sont calculés à partir du jour de pâque. 
Le jour de pâque est caculé pour le calendrier gregorien. 
Deux méthodes permettent d'effectuer ce calcule de manière différentes, la méthode getEsterDay utilise la fonction php native easter_date (https://secure.php.net/manual/fr/function.easter-date.php)

une méthode utilitaire permet de savoir si un jour donnée est un jour férié. 

Test avec Junit et atoum (à faire). 
