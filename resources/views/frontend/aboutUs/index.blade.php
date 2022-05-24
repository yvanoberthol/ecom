@extends('frontend.layouts.app')

@section('content')
    <section class="gry-bg py-5">
        <div class="profile">
            <div class="container">
                <div class="row">
                    <div class="col-xxl-6 col-xl-6 col-lg-8 col-md-8 mx-auto">
                        <div class="card">
                            <div class="text-center pt-4">
                                <h1 class="h4 fw-600">
                                    {{ translate('Contact Us')}}
                                </h1>
                            </div>

                            <div class="px-4 py-3 py-lg-4">
                                <div class="">
                                    <form class="form-default" role="form" action="{{ route('contact-us.store') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                                                   value="{{ old('name') }}"
                                                   placeholder="{{  translate('Name') }}" name="name" id="name" autocomplete="off">
                                            @if ($errors->has('name'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                                   value="{{ old('email') }}" placeholder="{{  translate('Email') }}" name="email"
                                                   id="email" autocomplete="off">
                                            @if ($errors->has('email'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control{{ $errors->has('phoneNumber') ? ' is-invalid' : '' }}"
                                                   value="{{ old('phoneNumber') }}" placeholder="{{  translate('PhoneNumber') }}" name="phoneNumber"
                                                   id="phoneNumber" autocomplete="off">
                                            @if ($errors->has('phoneNumber'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('phoneNumber') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <textarea class="form-control{{ $errors->has('message') ? ' is-invalid' : '' }}"
                                                      placeholder="{{  translate('Message') }}" name="message" id="message"
                                                      autocomplete="off" rows="5">
                                                {{ old('message') }}
                                            </textarea>
                                            @if ($errors->has('message'))
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('message') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                        <div class="mb-5">
                                            <button type="submit" class="btn btn-primary btn-block fw-600">{{  translate('Envoyer') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if (get_setting('google_map') == 1)
                <div class="row">
                    <iframe src="{{ env('MAP_API_KEY') }}" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
                @endif
            </div>
        </div>
    </section>
@endsection
