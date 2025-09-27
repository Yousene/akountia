@extends($layout)
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />

@stop
@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">Gestion des prospects</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('lead.index') }}">Liste des prospects</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Multi Column with Form Separator -->
        <div class="card mb-4">
            <h5 class="card-header"></h5>
            <form class="card-body" method="POST" action="{{ route('lead.update', ['lead' => $record->id]) }}">
                @csrf
                @method('Put')
                <div class="row g-3">
                    @can('lead.type.update')
                        <div class="col-md-6">
                            <label class="form-label" for="type">Type d'inscriptions</label>
                            <input type="text" name="type" id="type" class="form-control"
                                placeholder="Type d'inscriptions" value="{{ old('type', $record->type) }}" />
                            @error('type')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endcan @can('lead.name.update')
                        <div class="col-md-6">
                            <label class="form-label" for="name">Nom complet</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nom complet"
                                value="{{ old('name', $record->name) }}" />
                            @error('name')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endcan @can('lead.company.update')
                        <div class="col-md-6">
                            <label class="form-label" for="company">Entreprise</label>
                            <input type="text" name="company" id="company" class="form-control" placeholder="Entreprise"
                                value="{{ old('company', $record->company) }}" />
                            @error('company')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endcan @can('lead.email.update')
                        <div class="col-md-6">
                            <label class="form-label" for="email">email</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="email"
                                value="{{ old('email', $record->email) }}" />
                            @error('email')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endcan @can('lead.city.update')
                        <div class="col-md-6">
                            <label class="form-label" for="city">Ville</label>
                            <input type="text" name="city" id="city" class="form-control" placeholder="Ville"
                                value="{{ old('city', $record->city) }}" />
                            @error('city')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endcan @can('lead.course.update')
                        <div class="col-md-6">
                            <label class="form-label" for="course">Formation</label>
                            <input type="text" name="course" id="course" class="form-control" placeholder="Formation"
                                value="{{ old('course', $record->course) }}" />
                            @error('course')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endcan @can('lead.category.update')
                        <div class="col-md-6">
                            <label class="form-label" for="category">Categorie</label>
                            <input type="text" name="category" id="category" class="form-control" placeholder="Categorie"
                                value="{{ old('category', $record->category) }}" />
                            @error('category')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endcan @can('lead.phone.update')
                        <div class="col-md-6">
                            <label class="form-label" for="phone">Téléphone</label>
                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Téléphone"
                                value="{{ old('phone', $record->phone) }}" />
                            @error('phone')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endcan @can('lead.statut.update')
                        <div class="col-md-6">
                            <label class="form-label" for="statut">Statut</label>
                            <select name="statut" id="statut" class="select2 form-control" data-allow-clear="true">
                                @foreach ($statutRecords as $row)
                                    <option class="option" {{ $row->id == old('statut', $record->statut) ? 'selected' : '' }}
                                        value="{{ $row->id }}"> {{ $row->label }}</option>
                                @endforeach
                            </select>
                            @error('statut')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan

                    <!--updates_fields-->
                </div>
                <hr class="my-4 mx-n4" />
                <div class="pt-4 float-end">
                    <button type="submit" class="btn btn-primary me-sm-3 me-1">Enregistrer</button>
                </div>
                <div class="pt-4 float-start">
                    <button type="reset" class="btn btn-label-secondary">Vider</button>
                    <a href="{{ route('lead.index') }}" class="btn btn-label-secondary">Retour</a>
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
                noCalendar: true,
                time_24hr: true
            });
        });
    </script>
@stop
