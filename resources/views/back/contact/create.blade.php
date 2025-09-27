@extends($layout)
@section('css')
    <link rel="stylesheet" href="/assets/vendor/libs/select2/select2.css" />
    <link rel="stylesheet" href="/assets/vendor/libs/flatpickr/flatpickr.css" />

@stop
@section('content')
    <div class="container-fluid flex-grow-1 container-p-y">
        <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
            <div class="d-flex flex-column justify-content-center">
                <h4 class="py-3 mb-4">Gestion des contacts</h4>
            </div>
            <div class="d-flex align-content-center flex-wrap gap-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style1">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin') }}">Accueil</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('contact.index') }}">Liste des contacts</a>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
        <!-- Multi Column with Form Separator -->
        <div class="card mb-4">
            <h5 class="card-header"></h5>
            <form class="card-body" method="POST" action="{{ route('contact.store') }}">
                @csrf
                <div class="row g-3">
                    @can('contact.name.create')
                        <div class="col-md-6">
                            <label class="form-label" for="name">Nom complet</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="Nom complet"
                                value="{{ old('name') }}" />
                            @error('name')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan
                    @can('contact.statut.create')
                        <div class="col-md-6">
                            <label class="form-label" for="statut">Statut</label>
                            <select name="statut" id="statut" class="select2 form-control" data-allow-clear="true">
                                @foreach ($statutRecords as $row)
                                    <option class="option" {{ $row->id == old('statut') ? 'selected' : '' }}
                                        value="{{ $row->id }}"> {{ $row->label }}</option>
                                @endforeach
                            </select>
                            @error('statut')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    @endcan
                    @can('contact.email.create')
                        <div class="col-md-12">
                            <label class="form-label" for="email">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email"
                                value="{{ old('email') }}" />
                            @error('email')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endcan @can('contact.subject.create')
                        <div class="col-md-12">
                            <label class="form-label" for="subject">Sujet</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Sujet"
                                value="{{ old('subject') }}" />
                            @error('subject')
                                <span class="helper-text text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        @endcan @can('contact.message.create')
                        <div class="col-md-12">
                            <label class="form-label" for="message">Message</label>
                            <textarea name="message" id="message" class="form-control" placeholder="Message" rows="5">{{ old('message') }}</textarea>
                            @error('message')
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
                    <a href="{{ route('contact.index') }}" class="btn btn-label-secondary">Retour</a>
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
