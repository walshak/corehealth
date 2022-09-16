@extends('admin.layouts.receipt')

@section('main-content')

  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-offset-3 col-md-6 ">
        <table class="table table-sm table-responsive table-sm table-responsive table-bordered">
          <!-- <caption>Owner</caption> -->
          <tr><td colspan="3"><h3>{!! $invoice->supplier->company_name !!}</h3></td></tr>
            <tr>
              <td colspan="3">
                <address>
                  Address:{!! $invoice->supplier->address !!}<br>
                  Phone: {!! $invoice->supplier->phone !!}
                </address>

              </td>
            </tr>
            <tr>
                <td>Total Amount</td>
                <td> {!! $invoice->total_amount !!} </td>
                <td> Date: {!! $invoice->created_at !!} </td>
            </tr>
            <tr >
                <td>Invoice #:</td>
                <td>{!! $invoice->invoice_no !!}</td>
                <td>
                    Invoice Status:<b style="color:Green">Supplied</b>
                </td>
            </tr>
            <tr>
              <td colspan="3">
                 Invoice Prepare by :  {{ $user->surname . ' ' . $user->firstname }}
              </td>
            </tr>
        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">

          <thead class="thead-dark">
              <tr>
                  <th>#</th>
                  <th>Item Description</th>
                  <th>Qty</th>
                  <th>Total </th>
              </tr>
          </thead>
          <tbody>
              <?php $si=1; ?>
              @foreach ($other_lists as $other_list)
                <tr>
                  <td>{{  $si++ }}</td>
                  <td>{!!  $other_list->product->product_name !!}</td>

                  <td>{{  $other_list->order_quantity }}</td>
                  <td>{{  '₦'. number_format($other_list->total_amount) }}</td>
                </tr>
              @endforeach

          </tbody>

        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">


            <td class="noprint">


            </td>
            <td class="noprint">
              <button class="btn btn-success" onClick="window.print();" > <i class="fa fa-print"></i> PRINT</button>
            </td>
             <td class="noprint" align="center">
            <a href="{{ route('sales.index') }}" class="btn btn-warning"><i class="fa fa-hand-o-left"></i> New Sale</a>
            </td>
          </tr>
        </table>
    </div>
    <div class="col-md-3"></div>
  </div>



@endsection

@section('scripts')

@endsection
