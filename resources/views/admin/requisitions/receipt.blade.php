@extends('admin.layouts.receipt')

@section('title-content')
{{ $app->site_name . ' - ' . $reqRequest[0]->requisition->customer->fullname  }}
@endsection

@section('main-content')

<div id="clientNote" class="row">
  <div class="col-md-3"></div>
  <div class="col-md-offset-3 col-md-6">
    <br>

    <table class="table table-sm table-responsive table-sm table-responsive table-bordered">
      <div id="site_name_font" class="supplynote">Client's Copy...</div>
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
                    To Department Ordering Store
                  </h4>
                  <h6 class="text-center">University of Jos - Nigeria</h6>
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
          <strong>Department Code:</strong> {!! $reqRequest[0]->requisition->customer->code !!}
        </td>
        <td class="text-center">
          <h5><strong>
              STORE REQUISITION
            </strong>
          </h5>
        </td>
        <td>
          <strong>SIV No: {!!$reqRequest[0]->requisition->transaction_no !!}</strong>
        </td>

      </tr>
      <tr>
        <td colspan="2">
          Please issue the undermentioned article to <b><em>{!! $reqRequest[0]->requisition->customer->fullname
              !!}</em></b>
        </td>
        <td>
          {!! $reqRequest[0]->requisition->request_date !!}
        </td>
      </tr>
    </table>
    <?php $si = 1; $ss = 1;  ?>
    <table class="table table-sm table-responsive table-sm table-responsive table-striped">

      <thead class="thead-dark">
        <tr>
          <th width="5%">#</th>
          <th>Item Desc.</th>
          <th>Unit Price </th>
          <th width="5%">Qty</th>
          <th>Total </th>
        </tr>
      </thead>
      <tbody>

        @foreach ($reqRequest as $reqReq[0])
        <tr>
          <td width="5%">{{  $si++ }}</td>
          <td>{!! ucwords($reqReq[0]->product->product_name) !!}</td>
          <td>{{  '???'. $reqReq[0]->price }}</th>
          <td width="5%">{{  $reqReq[0]->quantity }}</td>
          <td>{{  '???'. number_format($reqReq[0]->total_amount) }}</td>
        </tr>
        @endforeach
        <tr>

          <td class="idTextExtHead" colspan="2"><b>Total Amount</b></td>
          <td></td>
          <td></td>
          <td class="idTextExtHead"><b>{!! '???'. number_format($reqReq[0]->requisition->total_amount)!!}</b></td>
        </tr>
        <tr>

          <td colspan="2"><b>Amount in Words</b></td>
          <td colspan="3">{!! convert_number_to_words($reqReq[0]->requisition->total_amount)!!} Naira Only</td>
        </tr>
      </tbody>

    </table>

    <table class="table table-sm table-responsive table-sm table-responsive">
      <tr>
        <td rowspan="2">
          <ol>
            <li>Ledger Card Posting</li>
            <li>For Account (Ledger Control)</li>
            <li>For Department</li>
            <li>For Stores</li>
          </ol>
        </td>
        <td>Received By:</td>
        <td>Date: </td>
      </tr>
      <tr>
        {{-- <td>
        </td> --}}
        <td>Issued By:</td>
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
          <div id="cashier">Head of Department</div>
        </td>
        <td></td>
        <td style="border-top: 2px dotted black;">
          Chief Purchasing & Supplies Officer
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

<div class="pagebreak"></div>

<div id="storeNote" class="row">
  <div class="col-md-3"></div>
  <div class="col-md-offset-3 col-md-6">
    <br>

    <table class="table table-sm table-responsive table-sm table-responsive table-bordered">
      <div id="site_name_font" class="supplynote">Store's Copy...</div>
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
                    To Department Ordering Store
                  </h4>
                  <h6 class="text-center">University of Jos - Nigeria</h6>
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
          <strong>Department Code:</strong> {!! $reqRequest[0]->requisition->customer->code !!}
        </td>
        <td class="text-center">
          <h5><strong>
              STORE REQUISITION
            </strong>
          </h5>
        </td>
        <td>
          <strong>SIV No: {!!$reqRequest[0]->requisition->transaction_no !!}</strong>
        </td>

      </tr>
      <tr>
        <td colspan="2">
          Please issue the undermentioned article to <b><em>{!! $reqRequest[0]->requisition->customer->fullname
              !!}</em></b>
        </td>
        <td>
          {!! $reqRequest[0]->requisition->request_date !!}
        </td>
      </tr>
    </table>
    <?php $si = 1; $ss = 1;  ?>
    <table class="table table-sm table-responsive table-sm table-responsive table-striped">

      <thead class="thead-dark">
        <tr>
          <th width="5%">#</th>
          <th>Item Desc.</th>
          <th>Unit Price </th>
          <th width="5%">Qty</th>
          <th>Total </th>
        </tr>
      </thead>
      <tbody>

        @foreach ($reqRequest as $reqReq[0])
        <tr>
          <td width="5%">{{  $si++ }}</td>
          <td>{!! ucwords($reqReq[0]->product->product_name) !!}</td>
          <td>{{  '???'. $reqReq[0]->price }}</th>
          <td width="5%">{{  $reqReq[0]->quantity }}</td>
          <td>{{  '???'. number_format($reqReq[0]->total_amount) }}</td>
        </tr>
        @endforeach
        <tr>

          <td class="idTextExtHead" colspan="2"><b>Total Amount</b></td>
          <td></td>
          <td></td>
          <td class="idTextExtHead"><b>{!! '???'. number_format($reqReq[0]->requisition->total_amount)!!}</b></td>
        </tr>
        <tr>

          <td colspan="2"><b>Amount in Words</b></td>
          <td colspan="3">{!! convert_number_to_words($reqReq[0]->requisition->total_amount)!!} Naira Only</td>
        </tr>
      </tbody>

    </table>

    <table class="table table-sm table-responsive table-sm table-responsive">
      <tr>
        <td rowspan="2">
          <ol>
            <li>Ledger Card Posting</li>
            <li>For Account (Ledger Control)</li>
            <li>For Department</li>
            <li>For Stores</li>
          </ol>
        </td>
        <td>Received By:</td>
        <td>Date: </td>
      </tr>
      <tr>
        {{-- <td>
        </td> --}}
        <td>Issued By:</td>
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
          <div id="cashier">Head of Department</div>
        </td>
        <td></td>
        <td style="border-top: 2px dotted black;">
          Chief Purchasing & Supplies Officer
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

<div class="pagebreak"></div>

<div id="duplicateNote" class="row">
  <div class="col-md-3"></div>
  <div class="col-md-offset-3 col-md-6">
    <br>

    <table class="table table-sm table-responsive table-sm table-responsive table-bordered">
      <div id="site_name_font" class="supplynote">Duplicate Store Copy...</div>
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
                    To Department Ordering Store
                  </h4>
                  <h6 class="text-center">University of Jos - Nigeria</h6>
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
          <strong>Department Code:</strong> {!! $reqRequest[0]->requisition->customer->code !!}
        </td>
        <td class="text-center">
          <h5><strong>
              STORE REQUISITION
            </strong>
          </h5>
        </td>
        <td>
          <strong>SIV No: {!!$reqRequest[0]->requisition->transaction_no !!}</strong>
        </td>

      </tr>
      <tr>
        <td colspan="2">
          Please issue the undermentioned article to <b><em>{!! $reqRequest[0]->requisition->customer->fullname
              !!}</em></b>
        </td>
        <td>
          {!! $reqRequest[0]->requisition->request_date !!}
        </td>
      </tr>
    </table>
    <?php $si = 1; $ss = 1;  ?>
    <table class="table table-sm table-responsive table-sm table-responsive table-striped">

      <thead class="thead-dark">
        <tr>
          <th width="5%">#</th>
          <th>Item Desc.</th>
          <th>Unit Price </th>
          <th width="5%">Qty</th>
          <th>Total </th>
        </tr>
      </thead>
      <tbody>

        @foreach ($reqRequest as $reqReq[0])
        <tr>
          <td width="5%">{{  $si++ }}</td>
          <td>{!! ucwords($reqReq[0]->product->product_name) !!}</td>
          <td>{{  '???'. $reqReq[0]->price }}</th>
          <td width="5%">{{  $reqReq[0]->quantity }}</td>
          <td>{{  '???'. number_format($reqReq[0]->total_amount) }}</td>
        </tr>
        @endforeach
        <tr>

          <td class="idTextExtHead" colspan="2"><b>Total Amount</b></td>
          <td></td>
          <td></td>
          <td class="idTextExtHead"><b>{!! '???'. number_format($reqReq[0]->requisition->total_amount)!!}</b></td>
        </tr>
        <tr>

          <td colspan="2"><b>Amount in Words</b></td>
          <td colspan="3">{!! convert_number_to_words($reqReq[0]->requisition->total_amount)!!} Naira Only</td>
        </tr>
      </tbody>

    </table>

    <table class="table table-sm table-responsive table-sm table-responsive">
      <tr>
        <td rowspan="2">
          <ol>
            <li>Ledger Card Posting</li>
            <li>For Account (Ledger Control)</li>
            <li>For Department</li>
            <li>For Stores</li>
          </ol>
        </td>
        <td>Received By:</td>
        <td>Date: </td>
      </tr>
      <tr>
        {{-- <td>
        </td> --}}
        <td>Issued By:</td>
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
          <div id="cashier">Head of Department</div>
        </td>
        <td></td>
        <td style="border-top: 2px dotted black;">
          Chief Purchasing & Supplies Officer
        </td>
      </tr>

      </tr>
      <tr>

        <td class="noprint">

          {{-- <a href="{{ route('sales.show',$tran->id) }}" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> Edit
      Invoice</a> |  --}}
      <a href="{{ route('home') }}" class="btn btn-sm btn-info"><i class="fa fa-hand-o-left"></i>
        Back</a>

      </td>
      <td class="noprint">
        <button class="btn btn-sm btn-success" onClick="window.print();"> <i class="fa fa-print"></i> PRINT</button>
      </td>
      <td class="noprint" align="center">
        <a href="{{ route('requisitions.index') }}" class="btn btn-sm btn-dark"><i class="fa fa-plus"></i> New Request</a>
      </td>
      </tr>
    </table>
  </div>
  <div class="col-md-3"></div>
</div>

@endsection

@section('scripts')

@endsection