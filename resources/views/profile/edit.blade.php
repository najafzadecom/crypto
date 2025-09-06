@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Profil Məlumatları') }}</div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <div class="row mb-4">
                            <h5>Şəxsi məlumatlar</h5>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="birth_date">{{ __('Doğum tarixi') }}</label>
                                    <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                    @error('birth_date')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="birth_place">{{ __('Doğulduğu yer') }}</label>
                                    <input id="birth_place" type="text" class="form-control @error('birth_place') is-invalid @enderror" name="birth_place" value="{{ old('birth_place', $user->birth_place) }}" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                    @error('birth_place')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="birth_country_id">{{ __('Doğulduğu ölkə') }}</label>
                                    <select id="birth_country_id" class="form-control @error('birth_country_id') is-invalid @enderror" name="birth_country_id" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                        <option value="">{{ __('Seçin') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('birth_country_id', $user->birth_country_id) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('birth_country_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="birth_region_id">{{ __('Doğulduğu şəhər/rayon') }}</label>
                                    <select id="birth_region_id" class="form-control @error('birth_region_id') is-invalid @enderror" name="birth_region_id" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                        <option value="">{{ __('Seçin') }}</option>
                                        @foreach($birthRegions as $region)
                                            <option value="{{ $region->id }}" {{ old('birth_region_id', $user->birth_region_id) == $region->id ? 'selected' : '' }}>
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('birth_region_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <h5>Yaşayış yeri</h5>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="residence_country_id">{{ __('Yaşadığı ölkə') }}</label>
                                    <select id="residence_country_id" class="form-control @error('residence_country_id') is-invalid @enderror" name="residence_country_id" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                        <option value="">{{ __('Seçin') }}</option>
                                        @foreach($countries as $country)
                                            <option value="{{ $country->id }}" {{ old('residence_country_id', $user->residence_country_id) == $country->id ? 'selected' : '' }}>
                                                {{ $country->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('residence_country_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="residence_region_id">{{ __('Yaşadığı şəhər/rayon') }}</label>
                                    <select id="residence_region_id" class="form-control @error('residence_region_id') is-invalid @enderror" name="residence_region_id" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                        <option value="">{{ __('Seçin') }}</option>
                                        @foreach($residenceRegions as $region)
                                            <option value="{{ $region->id }}" {{ old('residence_region_id', $user->residence_region_id) == $region->id ? 'selected' : '' }}>
                                                {{ $region->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('residence_region_id')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="residence_address">{{ __('Ünvan') }}</label>
                                    <input id="residence_address" type="text" class="form-control @error('residence_address') is-invalid @enderror" name="residence_address" value="{{ old('residence_address', $user->residence_address) }}" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                    @error('residence_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <h5>İş və təhsil</h5>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="education">{{ __('Təhsil') }}</label>
                                    <input id="education" type="text" class="form-control @error('education') is-invalid @enderror" name="education" value="{{ old('education', $user->education) }}" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                    @error('education')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="job">{{ __('İş yeri') }}</label>
                                    <input id="job" type="text" class="form-control @error('job') is-invalid @enderror" name="job" value="{{ old('job', $user->job) }}" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                    @error('job')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="position">{{ __('Vəzifə') }}</label>
                                    <input id="position" type="text" class="form-control @error('position') is-invalid @enderror" name="position" value="{{ old('position', $user->position) }}" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                    @error('position')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <h5>Sosial hesablar və cüzdan</h5>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="telegram">{{ __('Telegram hesabı') }}</label>
                                    <input id="telegram" type="text" class="form-control @error('telegram') is-invalid @enderror" name="telegram" value="{{ old('telegram', $user->telegram) }}" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                    @error('telegram')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="twitter">{{ __('X (Twitter) hesabı') }}</label>
                                    <input id="twitter" type="text" class="form-control @error('twitter') is-invalid @enderror" name="twitter" value="{{ old('twitter', $user->twitter) }}" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>
                                    @error('twitter')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="wallet_address">{{ __('BEP20 Blockchain cüzdan adresi') }}</label>
                                    <input id="wallet_address" type="text" class="form-control @error('wallet_address') is-invalid @enderror" name="wallet_address" value="{{ old('wallet_address', $user->wallet_address) }}" {{ $user->isProfileBlocked() || $user->wallet_address ? 'disabled' : '' }} placeholder="0x...">
                                    <small class="form-text text-muted">
                                        {{ __('Metamask, Trust Wallet kimi isti cüzdan adresi. Birja adresi deyil.') }}
                                        @if($user->wallet_address)
                                            <br>{{ __('Cüzdan ünvanını dəyişmək üçün dəstək xidməti ilə əlaqə saxlayın.') }}
                                        @endif
                                    </small>
                                    @error('wallet_address')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <h5>Haqqında</h5>
                            
                            <div class="col-md-12">
                                <div class="form-group mb-3">
                                    <label for="bio">{{ __('Özünüz haqqında qısa məlumat') }}</label>
                                    <textarea id="bio" class="form-control @error('bio') is-invalid @enderror" name="bio" rows="5" {{ $user->isProfileBlocked() ? 'disabled' : '' }}>{{ old('bio', $user->bio) }}</textarea>
                                    @error('bio')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        @if($user->isProfileBlocked())
                            <div class="alert alert-warning" role="alert">
                                {{ __('Profiliniz') }} {{ $user->profile_blocked_until->format('d.m.Y H:i') }} {{ __('tarixinə qədər bloklanıb. Profil məlumatlarınızı yeniləmək üçün gözləyin.') }}
                            </div>
                        @else
                            <div class="row mb-0">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Məlumatları Yenilə') }}
                                    </button>
                                </div>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Birth country change handler
        $('#birth_country_id').change(function() {
            var countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: '{{ route("profile.regions") }}',
                    type: 'GET',
                    data: { country_id: countryId },
                    success: function(data) {
                        $('#birth_region_id').empty();
                        $('#birth_region_id').append('<option value="">{{ __("Seçin") }}</option>');
                        $.each(data, function(key, value) {
                            $('#birth_region_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#birth_region_id').empty();
                $('#birth_region_id').append('<option value="">{{ __("Seçin") }}</option>');
            }
        });

        // Residence country change handler
        $('#residence_country_id').change(function() {
            var countryId = $(this).val();
            if (countryId) {
                $.ajax({
                    url: '{{ route("profile.regions") }}',
                    type: 'GET',
                    data: { country_id: countryId },
                    success: function(data) {
                        $('#residence_region_id').empty();
                        $('#residence_region_id').append('<option value="">{{ __("Seçin") }}</option>');
                        $.each(data, function(key, value) {
                            $('#residence_region_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    }
                });
            } else {
                $('#residence_region_id').empty();
                $('#residence_region_id').append('<option value="">{{ __("Seçin") }}</option>');
            }
        });
    });
</script>
@endsection
