@extends('adminlte::page')


@section('content_header')
	<h1>Nastavení faktur</h1>
@endsection

@section('content')

@if (session('success'))
     <div class="alert alert-success">
          {{ session('success') }}
     </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form role="form" action="{{ route('app.invoiceSettings.update') }}" method="POST">
  @method('patch')
  @csrf
    <!-- add logo and signature-->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="logo">Logo</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="logo" name="logo">
                    <label class="custom-file-label" for="logo">Vyber soubor</label>
                  </div>
                  <div class="input-group-append">
                    <button class="input-group-text" id="" name="upload">Nahraj</button>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="signature">Razítko / podpis </label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="signature" name="signature">
                        <label class="custom-file-label" for="signature">Najdi</label>
                      </div>
                      <div class="input-group-append">
                        <button class="input-group-text" id="" name="upload" value="Upload">Nahraj</button>
                      </div>
                    </div>
                  </div>
                </div>

    </div>

    <!-- primary informations of the invoice -->
    <div class="card card-success">
      <div class="card-header">
        <h3 class="card-title">Výchozí údaje na faktuře</h3>
      </div>
      <!-- /.card-header -->

      <!-- card body -->
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">

                        <!-- Jako běžný plátce tak nesmíte používat tato čísla jako konstantní symbol: 5, 6, 51, 1178, 2178, 3178 -->
                        <label for="konstatniS">Konstatní symbol</label>
                        <input type="number" class="form-control" id="konstatniS" placeholder="Konstatní symbol" name="constant_symbol">
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="zpusobPlatby">Způsob platby</label>
                            <select class="form-control" id="zpusobPlatby" placeholder="zpusobPlatby" name="payment_type">
                              <option name="bank">Bankovní převod</option>
                              <option name="cash">Hotovost</option>
                              <option name="postpaid">Dobírka</option>
                              <option name="prepaid">Záloha</option>
                            </select>
                      </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="splatnostF">Splatnost faktur (dnů)</label>
                        <input type="number" class="form-control" id="splatnostF" placeholder="14" name="due_date">
                      </div>
                </div>
            </div>



          {{-- <div class="form-group">
            <label>Text pod údaji dodavatele</label>
            <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
          </div>
          <div class="form-group">
            <label>Text nad položkami faktury</label>
            <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
          </div>
          <div class="form-group">
            <label>Text pod částkou za položky faktury</label>
            <textarea class="form-control" rows="3" placeholder="Enter ..."></textarea>
          </div> --}}


      </div>
        <div class="card-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </div>
    </div>
  </form>

@endsection
