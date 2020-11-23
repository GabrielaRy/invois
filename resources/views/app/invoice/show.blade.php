@extends('adminlte::page')

@section('content')

    <!-- Content Wrapper. Contains page content -->

    <!-- Main content -->
    <section class="invoice">
      <div>
        Číslo faktury : {{ $invoice->invoice_no }}
      </div>
      <!-- info row -->
      <div class="row invoice-info">
        <div class="col-sm-6 invoice-col">
          Dodavatel
          <address>
            <strong>{{ $invoice->contractor_name }}</strong><br>
            {{ $invoice->contractor_street }} <br>
            {{ $invoice->contractor_postcode }} {{ $invoice->contractor_city}} <br>
            {{ $invoice->contractor_country}}<br>
          </address>
            IČO {{ $invoice->contractor_identification_number }}<br>
            DIČ {{ $invoice->contractor_tax_identification_number }}
          
        </div>
        <!-- /.col -->
        <div class="col-sm-6 invoice-col">
          Odběratel
          <address>
          <strong>{{ $invoice->customer_name }}</strong><br>
          {{ $invoice->customer_street }}<br>
          {{ $invoice->customer_postcode }} {{ $invoice->customer_city}}<br>
          {{ $invoice->customer_country }}<br>
          </address>
          IČO {{ $invoice->customer_identification_number }}<br>
          DIČ {{ $invoice->customer_tax_identification_number }}
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    <hr>
    <div class="row invoice-info">
    <div class="col-sm-6 invoice-col">
        Variabilní symbol: {{ $invoice->variable_symbol }} <br>
        Konstantní symbol: {{ $invoice->constant_symbol }} <br>
        Specifický symbol: {{ $invoice->specific_symbol }} <br>
        Způsob platby: {{ $invoice->payment_type }}
    </div>

    <div class="col-sm-6 invoice-col">
        Datum vystavení: {{ $invoice->issue_date }}<br>
        Datum daň. plnění: {{ $invoice->issue_date }}<br>
        Datum splatnosti: {{ $invoice->due_date }}
    </div>
    </div>
    <br>
    
       <!-- Table row -->
       <div class="row">
        <div class="col-12 table-responsive">
          <table class="table table-striped">
            <thead>
            <tr>
              <th>Název položky</th>
              <th>Množství MJ</th>
              <th>Cena bez DPH/MJ</th>
              <th>Sazba DPH</th>
              <th>Celkem bez DPH</th>
            </tr>
            </thead>
            <tbody>
              @foreach ($invoice->items as $item)
            <tr>
              <td>{{ $item->name }}</td>
              <td>{{ $item->amount }}</td>
              <td>{{ $item->price }}</td>
              <td>21%</td>
              <td></td>
            </tr>
            @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        
        <!-- /.col -->
        <div class="col-6">
         

          <div class="table-responsive">
            <table class="table">
              <tr>
                <th style="width:50%">Celkem bez DPH:</th>
                <td>$250.30</td>
              </tr>
              <tr>
                <th>Sazba DPH (21%)</th>
                <td>$10.34</td>
              </tr>
              <tr>
                <th>Základ daně:</th>
                <td>$5.80</td>
              </tr>
              <tr>
                <th>DPH:</th>
                <td>$265.24</td>
              </tr>
              <tr>
                <th>Celkem k úhradě:</th>
                <td>$265.24</td>
              </tr>
            </table>
          </div>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>

@endsection