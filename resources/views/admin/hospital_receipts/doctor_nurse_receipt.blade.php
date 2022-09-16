@extends('admin.layouts.receipt')

@section('title-content')
{{ $apps->site_name . ' - ' . $tran->customer_name  }}
@endsection

@section('main-content')

<div id="clientNote" class="row">
  <div class="col-md-3"></div>
  <div class="col-md-offset-3 col-md-6">
    <br>

    <table class="table table-sm table-responsive table-sm table-responsive table-bordered">
      <div id="site_name_font" class="supplynote">Patient's Copy...</div>
      <tr>
        <td colspan="3">
          <table class="table table-sm table-responsive table-sm table-responsive table-striped">
            <thead>
              <tr>
                <td>
                  <img src="{{ asset('img/unijosLogo.jpg') }}" class="img-thumbnail" alt=" CSMS" width="80px"
                    height="90px">
                </td>
                <td colspan="2">
                  <h4 class="text-center">
                    To {{ $tran->customer_name}}
                  </h4>
                  <h6 class="text-center">Hospital </h6>
                </td>
                <td class="text-center">

                </td>
              </tr>
            </thead>
          </table>
        </td>
      </tr>
      <tr>

        <td>
          <strong>File No:</strong> {!! $file !!}
        </td>
        <td class="text-center">
          <h5><strong>
              Deposite To Account
            </strong>
          </h5>
        </td>
        <td>
          <strong>Transaction No: {!!$tran->transaction_no !!}</strong>
        </td>

      </tr>
      <tr>
        <td colspan="2">
          Please issue the undermentioned article to <b><em>{!! $tran->customer_name !!}</em></b>
        </td>
        <td>
          {!! $tran->tr_date !!}
        </td>
      </tr>
    </table>
    <?php $si = 1; $ss = 1;  ?>
    <table class="table table-sm table-responsive table-sm table-responsive table-striped">

      <thead class="thead-dark">
        <tr>
          <th width="5%">#</th>
          <th>Item .</th>
          <th>Services Description</th>
          <th>Amount</th>
        </tr>
      </thead>
      <tbody>

     
        <tr>
          <td width="5%">1</td>
          <td>{!! ucwords($tran->transaction_type) !!}</td>
          <td>{!! $pc->service_description !!}</td>
          <td>{{  '₦'. $tran->total_amount}}</th>
        </tr>
       
        <tr>

          <td class="idTextExtHead" colspan="2"><b>Total Amount</b></td>
          <td></td>
          <td></td>
          <td class="idTextExtHead"><b>{!! '₦'. number_format($tran->total_amount)!!}</b></td>
        </tr>
        <tr>

          <td colspan="2"><b>Amount in Words </b> </td>
          <td colspan="3">{!! convert_number_to_words($tran->total_amount)!!} Naira Only</td>
        </tr>
      </tbody>

    </table>

    <table class="table table-sm table-responsive table-sm table-responsive">
      <tr>
      
        <td>Received By:</td>
        <td>Date: </td>
      </tr>
      <tr>
        {{-- <td>
        </td> --}}
        <td>Paid By:</td>
        <td>Date: </td>
      </tr>
      <tr>
        <td>
        </td>
        <td></td>
        <td></td>
      </tr>

      <tr>
        <td style="border-top: 2px dotted black;">
          <div id="cashier">Cashier</div>
        </td>
        <td></td>
        <td style="border-top: 2px dotted black;">
          Patient
        </td>
      </tr>

      </tr>
      {{-- <tr>

        <td class="noprint">

          <a href="{{ route('sales.show',$tran->id) }}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Edit
      Invoice</a> | <a href="{{ route('home') }}" class="btn btn-sm btn-info"><i class="fa fa-hand-o-left"></i>
        Back</a>

      </td>
      <td class="noprint">
        <button class="btn btn-sm btn-success" onClick="window.print();"> <i class="fa fa-print"></i> PRINT</button>
      </td>
      <td class="noprint" align="center">
        <a href="{{ route('sales.index') }}" class="btn btn-sm btn-warning"><i class="fa fa-hand-o-left"></i> New
          Sale</a>
      </td>
      </tr> --}}
    </table>
  </div>
  <div class="col-md-3"></div>
</div>




@endsection

@section('scripts')

@endsection