@extends('adminlte::page')

@section('content_header')
	<h1>Seznam Zákazníků</h1>
@endsection



@section('content')

<button type="button" class="btn btn-success"><a href=" {{ route('customers.create')}}">Přidat zákazníka</a></button>
<br>
<br>

<div class="row">
    <div class="col-12">
      <div class="card">
        
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>Název zákazníka</th>
                <th>IČO</th>
                <th>DIČ</th>
                <th>Email</th>
                <th>Telefon</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($customers as $customer)
                <tr>
                    <td><a href="{{ route('customers.show', $customer->id) }}" >{{ $customer->name }}</a></td>
                    <td>{{ $customer->identification_number }}</td>
                    <td>{{ $customer->tax_identification_number }}</td>
                    <td>{{ $customer->contact_person_email }}</td>
                    <td>{{ $customer->contact_person_phone }}</td>
                    <td><a href="{{ route('customers.edit', $customer->id) }} "><i class="far fa-edit"></i></a></td>
                    <td>
                    <td>
                      <form action="{{ route('customers.destroy', $customer->id) }}" method="POST">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-outline-secondary">Delete</button>
                      </form>
                    
                    <td>
                  </tr>  
                @endforeach
              
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
@endsection