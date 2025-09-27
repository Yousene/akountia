@extends('layouts/front')
@section('content')


</div>
<!-- start the main page -->

<main class="maincontainer">

    <div class="container sousContainer" style="max-width: 60% !important">
        <div class="iconContainer">
            <img src="/assets/front/register.jpg" alt="">
        </div>
        <h2>INSCRIPTION - COMMENCEZ AVEC GO TAWSILL</h2>
        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="row">

                <!--<div class="row typeclient">
                    <h2 class="d-grid gap-2 "
                        style="padding: -10px!important;font-weight:bold;text-align:left!important;margin-bottom:20px!important;">
                        <span style="background-color: #1991ce;" class="badge right">Type client</span>
                    </h2>

                    <div class="col col-lg-6 col-sm-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_client" id="pm"
                                {{(old('type_client') == '2') ? '' : 'checked'}} value="1">
                            <label class="form-check-label" for="pm">
                                Contre paiement (Cash Delivery)
                            </label>
                        </div>
                    </div>
                    <div class="col col-lg-6 col-sm-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="type_client" id="cp"
                                {{(old('type_client') == '2') ? 'checked' : ''}} value="2">
                            <label class="form-check-label" for="cp">
                                Colis déjà payer
                            </label>
                        </div>
                    </div>
                </div>-->

                <div class="row vousEtes">
                    <h2 class="d-grid gap-2 "
                        style="font-weight:bold;text-align:left!important;margin-bottom:20px!important;"> <span
                            class="badge right" style="background-color: #1991ce;">Vous êtes</span></h2>

                    {{-- <label for="" style="font-weight:bold">Vous êtes</label> --}}
                    <div class="col col-lg-6 col-sm-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="categorie" id="Professionnel" value="1"
                                checked>
                            <label class="form-check-label" for="Professionnel">
                                Professionnel / Société
                            </label>
                        </div>
                    </div>
                    <div class="col col-lg-6 col-sm-12 mt-3">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="categorie" id="Personne" value="2">
                            <label class="form-check-label" for="Personne">
                                Personne physique
                            </label>
                        </div>
                    </div>

                </div>

                <div class="row mainform">
                    <h2 class="d-grid gap-2 "
                        style="font-weight:bold;text-align:left!important;margin-bottom:20px!important;"> <span
                            style="background-color: #1991ce;" class="badge right">Information personnelle</span></h2>

                    {{-- <label for="" style="font-weight:bold">Information personnelle</label> --}}
                    <div id="raisonsociale" class="col col-lg-6 col-sm-12 mt-3"
                        {{ ( '2' === old('categorie') ) ? 'style=display:none' :  '' }}>
                        <label class="form-label">Raison sociale</label>
                        <input type="text" class="form-control" placeholder="" name="raisonsociale"
                            value="{{old('raisonsociale')}}">
                        @error('raisonsociale')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div id="nom" class="col col-lg-6 col-sm-12 mt-3"
                        {{ ( '1' === old('categorie', '1') ) ? 'style=display:none' :  'style=display:block' }}>
                        <label class="form-label">Nom et Prénom </label>
                        <input type="text" class="form-control" placeholder="" name="name" value="{{old('name')}}">
                        @error('name')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col col-lg-6 col-sm-12  mt-3">
                        <label class="form-label">E-mail</label>
                        <input type="text" value="{{old('email')}}" class="form-control" autocomplete="off"
                            onfocus="this.removeAttribute('readonly');" readonly placeholder="Un e-mail valide"
                            name="email">
                        @error('email')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col col-sm-12 mt-3">
                        <label class="form-label">Adresse</label>
                        <input type="text" class="form-control" placeholder="" name="adresse"
                            value="{{old('adresse')}}">

                        @error('adresse')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col col-lg-6 col-sm-12 mt-3">
                        <label class="form-label">Ville</label>
                        <select name="ville" class="form-control">
                            <option></option>
                            @foreach ($villes as $record)
                            @if($record->id != 1)
                            <option value="{{ $record->id }}" {{( $record->id == old('ville') ) ? 'selected' : '' }}>
                                {{ $record->libelle }}
                            </option>
                            @endif
                            @endforeach
                        </select>

                        @error('ville')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col col-lg-6 col-sm-12 mt-3">
                        <!--<label class="form-label">Zone</label>

                        <select name="zone" class="form-control">
                        </select>-->
                    </div>
                    <div class="col col-lg-6 col-sm-12 mt-3">
                        <label class="form-label">Téléphone 1</label>
                        <input type="text" class="form-control" placeholder="0xxxxxxxxx" name="telephone"
                            value="{{old('telephone')}}">
                        @error('telephone')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col col-lg-6 col-sm-12 mt-3">
                        <label class="form-label">Téléphone 2</label>
                        <input type="text" class="form-control" placeholder="0xxxxxxxxx" name="telephone2"
                            value="{{old('telephone2')}}">
                    </div>

                    <div class="col col-lg-6 col-sm-12 mt-3" id="rc"
                        {{ ( '2' === old('categorie') ) ? 'style=display:none' :  'style=display:block' }}>
                        <label class="form-label">RC</label>
                        <input type="text" class="form-control" placeholder="6 Caractères" maxlength="6" name="rc"
                            value="{{old('rc')}}">
                        @error('rc')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col col-lg-6 col-sm-12 mt-3" id="ice"
                        {{ ( '2' === old('categorie') ) ? 'style=display:none' :  'style=display:block' }}>
                        <label class="form-label">ICE</label>
                        <input type="text" class="form-control" placeholder="15 Chiffres " maxlength="15" name="ice"
                            value="{{old('ice')}}">
                        @error('ice')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col col-lg-6 col-sm-12 mt-3" id="cin"
                        {{ ( '1' === old('categorie', '1') ) ? 'style=display:none' :  'style=display:block' }}>
                        <label class="form-label">CIN</label>
                        <input type="text" class="form-control" placeholder="CIN" name="cin" value="{{old('cin')}}">
                        @error('cin')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col col-sm-12 mt-3">
                        <label class="form-label">RIB</label>
                        <input type="text" class="form-control" placeholder="24 Chiffres" maxlength="24" name="rib"
                            value="{{old('rib')}}">

                        @error('rib')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="col col-lg-6 col-sm-12 mt-3">
                        <label class="form-label">Mot de passe</label>
                        <input type="password" class="form-control"
                            placeholder="Au moins 6 caractères (chiffres et Lettres)" name="password"
                            autocomplete="off">
                        @error('password')
                        <span class="help-block" style="color: #dd4b39;">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="col col-lg-6 col-sm-12 mt-3 mb-3">
                        <label class="form-label">Confirmation mot de passe</label>
                        <input type="password" class="form-control" placeholder="Confirmation mot de passe"
                            name="password_confirmation">
                    </div>
                    <div class="form-check mt-3" onclick="activateButton()">
                        <input class="form-check-input" type="checkbox" id="conditions">
                        <label class="form-check-label" for="conditions">
                            J'ai lu et j'accepte les <a target="_blank" href='/conditions-utilisation'>conditions
                                d'utilisation</a>.
                        </label>
                    </div>
                    <div class="form-check mt-3" onclick="activateButton()">
                        <input class="form-check-input" type="checkbox" id="certifie">
                        <label class="form-check-label" for="certifie">
                            Je certifie sur l'honneur que les informations communiquées ci-dessus sont exactes.
                        </label>
                    </div>
                    <div class="col col-lg-6 col-sm-12 mt-3 ">
                        <button type="submit" id="submit" disabled class="btn btn-primary">S'inscrire</button>
                    </div>
                </div>

            </div>
        </form>
    </div>
</main>
@stop

@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('input:radio[name=categorie]').change(function() {

        if ($(this).val() === '1') {
            $('#raisonsociale').css('display', 'block')
            $('#nom').css('display', 'none')
            $('#cin').css('display', 'block')
            $('#rc').css('display', 'block')
            $('#ice').css('display', 'block')
        } else {
            $('#raisonsociale').css('display', 'none')
            $('#rc').css('display', 'none')
            $('#ice').css('display', 'none')
            $('#nom').css('display', 'block')
            $('#cin').css('display', 'block')
        }
    });


});

function activateButton() {
    if ($('#certifie').prop('checked') && $('#conditions').prop('checked')) {
        $('#submit').removeAttr('disabled')
    } else {
        $('#submit').attr('disabled', 'disabled');
    }
}
</script>
@stop