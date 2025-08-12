@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="content">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">{{ $title }}</h5>
            </div>

            <div class="card-body">

                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger border-0 alert-dismissible fade show">
                            {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endforeach
                @endif

                <form action="{{ $action }}" method="POST">
                    @method($method)
                    @csrf
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Name') }}:</label>
                        <div class="col-lg-9">
                            <input
                                type="text"
                                name="name"
                                class="form-control  @error('name') is-invalid @enderror"
                                placeholder="{{ __('Name') }}"
                                value="{{ old('name', $item->name ?? '') }}"
                            />
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('E-mail') }}:</label>
                        <div class="col-lg-9">
                            <input
                                type="email"
                                name="email"
                                class="form-control  @error('email') is-invalid @enderror"
                                placeholder="{{ __('E-mail') }}"
                                value="{{ old('email', $item->email ?? '') }}"
                            />
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Username') }}:</label>
                        <div class="col-lg-9">
                            <input
                                type="text"
                                name="username"
                                class="form-control  @error('username') is-invalid @enderror"
                                placeholder="{{ __('Username') }}"
                                value="{{ old('username', $item->username ?? '') }}"
                            />
                            @error('username')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Telegram') }}:</label>
                        <div class="col-lg-9">
                            <input
                                type="text"
                                name="telegram"
                                class="form-control  @error('telegram') is-invalid @enderror"
                                placeholder="{{ __('Telegram') }}"
                                value="{{ old('telegram', $item->telegram ?? '') }}"
                            />
                            @error('telegram')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Roles') }}:</label>
                        <div class="col-lg-9">
                            <select
                                multiple="multiple"
                                name="roles[]"
                                data-placeholder="{{ __('Select roles') }}"
                                class="form-control form-control-select2-icons"
                            >
                                @forelse($roles as $role)
                                    <option
                                        @selected(in_array($role->name, old('roles', isset($item) ? $item->getRoleNames()->toArray() : []))) value="{{ $role->name }}">{{ $role->name }}</option>
                                @empty
                                    <option value="">{{ __('Role not found') }}</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Status') }}:</label>
                        <div class="col-lg-9">
                            <select
                                name="status"
                                class="form-control form-control-select2 @error('status') is-invalid @enderror"
                            >
                                <option value="active" @selected(old('status', $item->status ?? '') === 'active')>{{ __('Active') }}</option>
                                <option value="inactive" @selected(old('status', $item->status ?? '') === 'inactive')>{{ __('Inactive') }}</option>
                            </select>
                            @error('status')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Password') }}:</label>
                        <div class="col-lg-9">
                            <input
                                type="password"
                                name="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="{{ __('Password') }}"
                            />
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-lg-3 col-form-label">{{ __('Password Confirmation') }}:</label>
                        <div class="col-lg-9">
                            <input
                                type="password"
                                name="password_confirmation"
                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                placeholder="{{ __('Password Confirmation') }}"
                            />
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="text-end">
                        <button type="button" class="btn btn-danger" onclick="history.back()"><i
                                class="ph-arrow-left me-2"></i> {{ __('Back') }} </button>
                        <button type="submit" class="btn btn-primary">{{ __('Submit') }} <i
                                class="ph-paper-plane-tilt ms-2"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
