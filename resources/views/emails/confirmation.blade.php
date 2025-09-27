@component('mail::message')
# Validation de votre compte.

<p>
    Bonjour {{ $details['name'] }}.
</p>

<p>
    Nous vous souhaitons la bienvenue dans notre réseau GO TAWSIL.
</p>
<p>
    Votre inscription vous permet d accéder à votre espace et de suivre ainsi vos expéditions.
</p>
<p>
    Pour activer votre compte ,veuillez cliquer sur le lien ci-dessous :
</p>

@component('mail::button', ['url' => $details['url'] ])
Lien de Confirmation
@endcomponent


<p>
    Cordialement,
</p>
<p>
    Service client GO TAWSIL
</p>
@endcomponent
