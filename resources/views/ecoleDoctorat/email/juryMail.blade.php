@component('mail::message')

<h2>Theme de Recherche :</h2>
{{ $user['theme_recherche'] }}

<br>veuillez noter cet etudiant :

@component('mail::button', ['url' => $user['url']])
Noter
@endcomponent

Thanks,<br>
Te-sea 2022
@endcomponent
