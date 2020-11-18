@extends('adminlte::page')

@section('content_header')
	<h1>{{ $customer->name }}</h1>
@endsection

@if (session('success'))
     <div class="alert alert-success">
          {{ session('success') }}
     </div>
@endif

@section('content')

<div>
    <h6>{{ $customer->street }}</h6>
    <h6>{{ $customer->postcode }} , {{ $customer->city }}</h6>
    <h6>{{ $customer->country }}</h6>
</div>

<hr>
<div>
    <h6>IČO: {{ $customer->identification_number }}<h6>
    <h6>DIČ: {{ $customer->tax_identification_number }}</h6>
</div>

<hr>
<div>
    <h6>Kontaktní osoba: {{ $customer->contact_person_name }}</h6>
    <h6>Email: {{ $customer->contact_person_email }}</h6>
    <h6>Telefon: {{ $customer->contact_person_phone }}</h6>
</div>

<hr>
    <button type="button" class="btn btn-secondary"><a href="{{ route('customers.edit', $customer->id) }}">Edit</a></button>

    <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
        @csrf
        @method('delete')
    <button type="submit" class="btn btn-secondary">Delete</button>
    </form>

@endsection