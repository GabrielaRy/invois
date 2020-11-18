@extends('adminlte::page')

@section('content_header')
	<h1>Fakturační údaje</h1>
@endsection

@section('content')

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ action('UserController@update')}}" method="POST">
    @csrf
    @method('patch')

    <h5>Identifikace</h5>
    <div class="form-row">
        <div class="form-group col-md-4">
          <label for="identification_number	">IČO</label>
          <input type="text" class="form-control" id="identificationNumber" name="identificationNumber" value="{{ $user->identification_number }}">
        </div>
        <div class="form-group col-md-4">
            <label for="tax_identification_number">DIČ</label>
            <input type="text" class="form-control" id="taxIdentificationNumber" name="taxIdentificationNumber" value="{{ $user->tax_identification_number }}">
          </div>
        </div>
        <div class="form-row">
          <button type="button" class="btn btn-secondary">Načíst data</button>
        </div>
    
    <h5>Název<h5>
    <div class="form-row">
        <div class="form-group col-md-8">
            <label for="company_name">Obchodní název</label>
            <input type="text" class="form-control" id="companyName" name="companyName" value="{{ $user->company_name }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="street">Ulice</label>
            <input type="text" class="form-control" id="street" name="street" value="{{ $user->street }}">
        </div>
        <div class="form-group col-md-4">
            <label for="inputAddress2">Město</label>
            <input type="text" class="form-control" id="city" name="city" value="{{ $user->city }}">
        </div>
        <div class="form-group col-md-2">
            <label for="postcode">PSČ</label>
            <input type="text" class="form-control" id="postcode" name="postcode" value="{{ $user->city }}">
          </div>
    </div>
    <div class="form-row">
      <div class="form-group col-md-4">
        <label for="country">Země</label>
        <input type="text" class="form-control" id="country" name="country" value="{{ $user->country }}">
      </div>
    </div>
    
    <h5>Kontaktní osoba<h5>
    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="contact_person_name">Jméno</label>
            <input type="text" class="form-control" id="contactPersonName" name="contactPersonName" value="{{ $user->contact_person_name }}">
        </div>
        <div class="form-group col-md-4">
            <label for="contact_person_phone">Telefon</label>
            <input type="text" class="form-control" id="contactPersonPhone" name="contactPersonPhone" value="{{ $user->contact_person_phone }}">
        </div>
        <div class="form-group col-md-4">
            <label for="contact_person_email">Email</label>
            <input type="email" class="form-control" id="contactPersonEmail" name="contactPersonEmail" value="{{ $user->contact_person_email }}">
        </div>
        <div class="form-group col-md-4">
            <label for="contact_person_email">WWW</label>
            <input type="text" class="form-control" id="contactPersonWebsite" name="contactPersonWebsite" value="{{ $user->contact_person_website }}">
        </div>
    </div>

    <button type="submit" class="btn btn-secondary">Uložit fakturační údaje</button>
  </form>

@endsection