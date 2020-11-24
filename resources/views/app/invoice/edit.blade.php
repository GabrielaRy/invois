@extends('adminlte::page')

@section('content_header')
	<h1>Upravit fakturu</h1>
@endsection

@if (session('success'))
     <div class="alert alert-success">
          {{ session('success') }}
     </div>
@endif

@section('content')

<form action="{{ route('invoice.update', $invoice->id) }}" method="POST">
    @csrf
    @method('patch')

    <!-- Main content -->
    <section class="invoice">
        <!-- vyresi cislo faktury -->
        <div class="form-group col-md-6">
         <label for="bank_account_number">Číslo faktury</label>
        <input type="text" class="form-control" id="invoice_no" name="invoiceNo" value="{{ $invoice->invoice_no }}">
       </div>
         <!-- info row -->
         <div class="row invoice-info">
           <div class="col-sm-6 invoice-col">
             Dodavatel
             <address>
                 <label for="contractor_name"></label>
                 <input type="text" class="form-control" id="contractor_name" name="contractorName" value= "{{ $invoice->contractor_name }}"></strong>
                 <label for="contractor_street"></label>
                 <input type="text" class="form-control" id="contractor_street" name="contractorStreet" value= "{{ $invoice->contractor_street }}">
                 <label for="contractor_city"></label>
                 <input type="text" class="form-control" id="contractor_city" name="contractorCity" value= "{{ $invoice->contractor_city }}">
                 <label for="contractor_postcode"></label>
                 <input type="text" class="form-control" id="contractor_postcode" name="contractorPostcode" value= "{{ $invoice->contractor_postcode }}">
                 <label for="contractor_country"></label>
                 <input type="text" class="form-control" id="contractor_country" name="contractorCountry" value= "{{ $invoice->contractor_country }}">
             </address>
 
             <label for="contractor_identification_number">IČO: </label>
             <input type="text" class="form-control" id="contractor_identification_number" name="contractorIdentificationNumber" value= "{{ $invoice->contractor_identification_number }}">
             <label for="contractor_city">DIČ: </label>
             <input type="text" class="form-control" id="contractor_tax_identification_number" name="contractorTaxIdentificationNumber" value= "{{ $invoice->contractor_tax_identification_number }}">
             
           </div>
           <!-- /.col -->
           <div class="col-sm-6 invoice-col">
             Odběratel
             <address>
                 <div class="form-group col-md-12" >
                  <label>Zákazník</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" value= "{{ $invoice->customer_name }}">
                  </div>
           </div>
           <!-- /.col -->
         </div>
         <!-- /.row -->
       <hr>
       <div class="row invoice-info">
       <div class="col-sm-6 invoice-col">
         <label for="contractor_city">Variabilní symbol: </label>
        <input type="text" class="form-control" id="variable_symbol" name="variableSymbol" value="{{ $invoice->variable_symbol }}">
         <label for="contractor_city">Konstantní symbol: </label>
         <input type="text" class="form-control" id="constant_symbol" name="constantSymbol" value="{{ $invoice->constant_symbol }}">
         <label for="contractor_city">Specifický symbol: </label>
         <input type="text" class="form-control" id="specific_symbol" name="specificSymbol" value="{{ $invoice->specific_symbol }}">
           <div class="form-group col-md-12" >
             <label>Způsob platby</label>
             <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true" name="paymentType">
               <option value="bankovní převod">Bankovní převod</option>
               <option value="hotovost">Hotovost</option>
               <option value="dobirka">Dobírka</option>
             </select>
           </div>
           <div class="row invoice-info">
           <div class="col-sm-6 invoice-col">
               <label for="bank_account_number">Číslo účtu</label>
               <input type="text" class="form-control" id="bank_account_number" name="bankAccountNumber" value="{{ $invoice->bank_account_number }}">
               <label for="bank_account_iban">IBAN</label>
               <input type="text" class="form-control" id="bank_account_iban" name="bankAccountIban" value="{{ $invoice->bank_account_iban }}">
               <label for="bank_account_swift">SWIFT</label>
               <input type="text" class="form-control" id="bank_account_swift" name="bankAccountSwift" placeholder="volitelné" value="{{ $invoice->bank_account_swift }}">
           </div>
         </div>     
       </div>
   
       <div class="col-sm-6 invoice-col">
         <label for="contractor_city">Datum vystavení: </label>
         <input type="date" class="form-control" id="issue_date" name="issueDate" value="{{ $invoice->issue_date }}">
         <label for="contractor_city">Datum splatnosti: </label>
         <input type="date" class="form-control" id="due_date" name="dueDate" value="{{ $invoice->due_date}}">
         <label for="contractor_city">Zdanitelné plnění: </label>
         <input type="date" class="form-control" id="" name="">
         <label>Faktura zaplacena (volitelné)</label>
         <input type="date" class="form-control" name="isPaid" value="{{ $invoice->is_paid }}">
  
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
                 <th>Množství</th>
                 <th>MJ</th>
                 <th>Cena bez DPH / MJ</th>
                 <th>DPH (%)</th>
               </tr>
               </thead>
               <tbody>
                @foreach ($savedItems as $item)
                   <tr>
                     <td><input type="text" name="items[{{$item->id}}][name]" value="{{ $saveItem->name }}"></td>
                     <td><input type="text" name="items[{{$item->id}}][amount]" value="{{ $saveItem->amount }}"></td>
                     <td><input type="text" name="items[{{$item->id}}][unit]" value="{{ $saveItem->unit }}"></td>
                     <td><input type="text" name="items[{{$item->id}}][price]" value="{{ $saveItem->price }}"></td>
                     <td>21%</td>
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
 
         <div class="form-row">
           <div class="form-group col-md-12">
               <label for="note">Poznámka</label>
               <input type="text" class="form-control" id="note" name="note" value="{{ $invoice->note }}">
           </div>
       </div>
   
       <div class="card-footer">
        <button type="submit" class="btn btn-primary">Uložit změny</button>
       </div>
   
      </section>
       <!-- /.content -->
       <div class="clearfix"></div>
</form>
@endsection