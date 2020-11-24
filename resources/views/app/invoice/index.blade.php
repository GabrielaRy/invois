@extends('adminlte::page')

@section('content_header')
	<h1>Vystavené faktury</h1>
@endsection

@if (session('success'))
     <div class="alert alert-success">
          {{ session('success') }}
     </div>
@endif

@section('content')

<button type="button" class="btn btn-success"><a href=" {{ route('invoice.create')}}">Nová faktura</a></button>
<br>
<br>
  
@if($invoices->isEmpty()) 

<div>Seznam je prázdný. Přidejte první fakturu</div>
  
@else
  
<div class="row">
    <div class="col-12">
      <div class="card">
        
        <!-- /.card-header -->
        <div class="card-body table-responsive p-0">
          <table class="table table-hover text-nowrap">
            <thead>
              <tr>
                <th>Vystavena</th>
                <th>Číslo faktury</th>
                <th>Stav</th>
                <th>Zákazník</th>
                <th>Částka</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($invoices as $invoice)
        
                <tr>
                    <td>{{ $invoice->issue_date }}</td>
                    <td><a href="{{ route('invoice.show', $invoice->id) }}" >{{ $invoice->invoice_no }}</a></td>
                    <td></td>
                    <td>{{ $invoice->customer_name }}</td>
                    <td></td>
                    <td><a href="{{ route('invoice.edit', $invoice->id) }} "><i class="far fa-edit"></i></a></td>
                    <td>
                    <td>
                      <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST">
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
@endif
@endsection