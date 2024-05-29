<div>
<p>l'immobilier qui a la description suivante va avoir une visiteur</p>
    <p>{{$immobil->description}}</p>
    <p>Et voici les informations qui concernent la visite de l'immobilier</p>
<ul>
    <li>nom du visiteur : {{ $visite->nom }}</li>
    <li>Date de visite : {{ $visite->dates }}</li>
    <li>Heure de visite : {{ $visite->heure }}</li>
    <li>Contact de visite : {{ $visite->email }}</li>
    <!-- Ajoutez d'autres détails de réservation selon vos besoins -->
    
</ul>
</div>
