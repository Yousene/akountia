@extends($layout)
@section('css')
<link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />

@stop
@section('content')
<div class="container-fluid flex-grow-1 container-p-y">
    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <div class="d-flex flex-column justify-content-center">
            <h4 class="py-3 mb-4">Gestion des companys</h4>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-style1">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin') }}">Accueil</a>
                    </li>
                    <li class="breadcrumb-item active">
                        <a href="{{ route('company.index') }}">Liste des companys</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Multi Column with Form Separator -->
    <div class="card mb-4">
        <h5 class="card-header"></h5>
        <form class="card-body" method="POST" action="{{ route('company.update', ['company' => $record->id]) }}">
            @csrf
            @method('Put')
            <div class="row g-3">
                    @can('company.name.update')
    <div class="col-md-4">
        <label class="form-label" for="name">Nom de l'Entreprise</label>
        <input type="text" name="name" id="name" class="form-control" placeholder="Nom de l'Entreprise" value="{{ old('name', $record->name) }}" />
        @error('name')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.short_name.update')
    <div class="col-md-4">
        <label class="form-label" for="short_name">Nom Court</label>
        <input type="text" name="short_name" id="short_name" class="form-control" placeholder="Nom Court" value="{{ old('short_name', $record->short_name) }}" />
        @error('short_name')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.type.update')
    <div class="col-md-4">
        <label class="form-label" for="type">Type de l'Entreprise</label>
        <input type="text" name="type" id="type" class="form-control" placeholder="Type de l'Entreprise" value="{{ old('type', $record->type) }}" />
        @error('type')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.registration_number.update')
    <div class="col-md-4">
        <label class="form-label" for="registration_number">Numéro d'Enregistrement</label>
        <input type="text" name="registration_number" id="registration_number" class="form-control" placeholder="Numéro d'Enregistrement" value="{{ old('registration_number', $record->registration_number) }}" />
        @error('registration_number')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.tax_id_number.update')
    <div class="col-md-4">
        <label class="form-label" for="tax_id_number">Numéro d'Identification Fiscale</label>
        <input type="text" name="tax_id_number" id="tax_id_number" class="form-control" placeholder="Numéro d'Identification Fiscale" value="{{ old('tax_id_number', $record->tax_id_number) }}" />
        @error('tax_id_number')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.vat_id_number.update')
    <div class="col-md-4">
        <label class="form-label" for="vat_id_number">Numéro d'Identification de la TVA</label>
        <input type="text" name="vat_id_number" id="vat_id_number" class="form-control" placeholder="Numéro d'Identification de la TVA" value="{{ old('vat_id_number', $record->vat_id_number) }}" />
        @error('vat_id_number')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.fiscal_year.update')
    <div class="col-md-4">
        <label class="form-label" for="fiscal_year">Exercice Fiscal</label>
        <input type="text" name="fiscal_year" id="fiscal_year" class="form-control" placeholder="Exercice Fiscal" value="{{ old('fiscal_year', $record->fiscal_year) }}" />
        @error('fiscal_year')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.incorporation_date.update')
    <div class="col-md-4">
        <label class="form-label" for="incorporation_date">Date d'Incorporation</label>
        <input type="text" class="form-control quicky-date" placeholder="YYYY-MM-DD" id="incorporation_date" name="incorporation_date" value="{{ old('incorporation_date', $record->incorporation_date) }}" />
        @error('incorporation_date')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.legal_structure.update')
    <div class="col-md-4">
        <label class="form-label" for="legal_structure">Structure Juridique</label>
        <input type="text" name="legal_structure" id="legal_structure" class="form-control" placeholder="Structure Juridique" value="{{ old('legal_structure', $record->legal_structure) }}" />
        @error('legal_structure')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.sector.update')
    <div class="col-md-4">
        <label class="form-label" for="sector">Secteur</label>
        <input type="text" name="sector" id="sector" class="form-control" placeholder="Secteur" value="{{ old('sector', $record->sector) }}" />
        @error('sector')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.industry.update')
    <div class="col-md-4">
        <label class="form-label" for="industry">Industrie</label>
        <input type="text" name="industry" id="industry" class="form-control" placeholder="Industrie" value="{{ old('industry', $record->industry) }}" />
        @error('industry')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.description.update')
    <div class="col-md-4">
        <label class="form-label" for="description">Description de l'Entreprise</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $record->description) }}</textarea>
        @error('description')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.active_status.update')
    <div class="col-md-4">
        <label class="form-label" for="active_status">Statut Actif</label>
        <input type="text" name="active_status" id="active_status" class="form-control" placeholder="Statut Actif" value="{{ old('active_status', $record->active_status) }}" />
        @error('active_status')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.ice_number.update')
    <div class="col-md-4">
        <label class="form-label" for="ice_number">Numéro ICE</label>
        <input type="text" name="ice_number" id="ice_number" class="form-control" placeholder="Numéro ICE" value="{{ old('ice_number', $record->ice_number) }}" />
        @error('ice_number')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.patente_number.update')
    <div class="col-md-4">
        <label class="form-label" for="patente_number">Numéro de Patente</label>
        <input type="text" name="patente_number" id="patente_number" class="form-control" placeholder="Numéro de Patente" value="{{ old('patente_number', $record->patente_number) }}" />
        @error('patente_number')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.cnss_number.update')
    <div class="col-md-4">
        <label class="form-label" for="cnss_number">Numéro CNSS</label>
        <input type="text" name="cnss_number" id="cnss_number" class="form-control" placeholder="Numéro CNSS" value="{{ old('cnss_number', $record->cnss_number) }}" />
        @error('cnss_number')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.legal_representative.update')
    <div class="col-md-4">
        <label class="form-label" for="legal_representative">Représentant Légal</label>
        <input type="text" name="legal_representative" id="legal_representative" class="form-control" placeholder="Représentant Légal" value="{{ old('legal_representative', $record->legal_representative) }}" />
        @error('legal_representative')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.representative_position.update')
    <div class="col-md-4">
        <label class="form-label" for="representative_position">Position du Représentant Légal</label>
        <input type="text" name="representative_position" id="representative_position" class="form-control" placeholder="Position du Représentant Légal" value="{{ old('representative_position', $record->representative_position) }}" />
        @error('representative_position')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.representative_phone.update')
    <div class="col-md-4">
        <label class="form-label" for="representative_phone">Téléphone du Représentant Légal</label>
        <input type="text" name="representative_phone" id="representative_phone" class="form-control" placeholder="Téléphone du Représentant Légal" value="{{ old('representative_phone', $record->representative_phone) }}" />
        @error('representative_phone')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.representative_email.update')
    <div class="col-md-4">
        <label class="form-label" for="representative_email">Email du Représentant Légal</label>
        <input type="text" name="representative_email" id="representative_email" class="form-control" placeholder="Email du Représentant Légal" value="{{ old('representative_email', $record->representative_email) }}" />
        @error('representative_email')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.email.update')
    <div class="col-md-4">
        <label class="form-label" for="email">Email de l'Entreprise</label>
        <input type="text" name="email" id="email" class="form-control" placeholder="Email de l'Entreprise" value="{{ old('email', $record->email) }}" />
        @error('email')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.phone_number.update')
    <div class="col-md-4">
        <label class="form-label" for="phone_number">Numéro de Téléphone</label>
        <input type="text" name="phone_number" id="phone_number" class="form-control" placeholder="Numéro de Téléphone" value="{{ old('phone_number', $record->phone_number) }}" />
        @error('phone_number')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.fax_number.update')
    <div class="col-md-4">
        <label class="form-label" for="fax_number">Numéro de Fax</label>
        <input type="text" name="fax_number" id="fax_number" class="form-control" placeholder="Numéro de Fax" value="{{ old('fax_number', $record->fax_number) }}" />
        @error('fax_number')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.physical_address.update')
    <div class="col-md-4">
        <label class="form-label" for="physical_address">Adresse Physique</label>
        <input type="text" name="physical_address" id="physical_address" class="form-control" placeholder="Adresse Physique" value="{{ old('physical_address', $record->physical_address) }}" />
        @error('physical_address')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.postal_address.update')
    <div class="col-md-4">
        <label class="form-label" for="postal_address">Adresse Postale</label>
        <input type="text" name="postal_address" id="postal_address" class="form-control" placeholder="Adresse Postale" value="{{ old('postal_address', $record->postal_address) }}" />
        @error('postal_address')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.city.update')
    <div class="col-md-4">
        <label class="form-label" for="city">Ville</label>
        <input type="text" name="city" id="city" class="form-control" placeholder="Ville" value="{{ old('city', $record->city) }}" />
        @error('city')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.region.update')
    <div class="col-md-4">
        <label class="form-label" for="region">Région</label>
        <input type="text" name="region" id="region" class="form-control" placeholder="Région" value="{{ old('region', $record->region) }}" />
        @error('region')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.postal_code.update')
    <div class="col-md-4">
        <label class="form-label" for="postal_code">Code Postal</label>
        <input type="text" name="postal_code" id="postal_code" class="form-control" placeholder="Code Postal" value="{{ old('postal_code', $record->postal_code) }}" />
        @error('postal_code')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.country.update')
    <div class="col-md-4">
        <label class="form-label" for="country">Pays</label>
        <input type="text" name="country" id="country" class="form-control" placeholder="Pays" value="{{ old('country', $record->country) }}" />
        @error('country')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.website.update')
    <div class="col-md-4">
        <label class="form-label" for="website">Site Web</label>
        <input type="text" name="website" id="website" class="form-control" placeholder="Site Web" value="{{ old('website', $record->website) }}" />
        @error('website')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan    @can('company.logo.update')
    <div class="col-md-4">
        <label class="form-label" for="logo">Logo</label>
        <input type="text" name="logo" id="logo" class="form-control" placeholder="Logo" value="{{ old('logo', $record->logo) }}" />
        @error('logo')
        <span class="helper-text text-danger">{{ $message }}</span>
        @enderror
    </div>
    @endcan
            </div>
            <hr class="my-4 mx-n4" />
            <div class="pt-4 float-end">
                <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
            </div>
            <div class="pt-4 float-start">
                <button type="reset" class="btn btn-label-secondary">Vider</button>
                <a href="{{ route('company.index') }}" class="btn btn-label-secondary">Retour</a>
            </div>
        </form>
    </div>
</div>
@stop
@section('js')
<script src="/assets/vendor/libs/select2/select2.js"></script>
<script src="/assets/js/forms-selects.js"></script>
<script src="/assets/vendor/libs/flatpickr/flatpickr.js"></script>

<script type="text/javascript">
    // Select all date inputs
    const flatpickrDates = document.querySelectorAll('.quicky-date');

    // Apply flatpickr to each date input
    flatpickrDates.forEach(function(flatpickrDate) {
        flatpickrDate.flatpickr({
            monthSelectorType: 'static'
        });
    });

    // Select all time inputs
    const flatpickrTimes = document.querySelectorAll('.quicky-time');

    // Apply flatpickr to each time input
    flatpickrTimes.forEach(function(flatpickrTime) {
        flatpickrTime.flatpickr({
            enableTime: true,
            noCalendar: true
        });
    });
</script>
@stop
