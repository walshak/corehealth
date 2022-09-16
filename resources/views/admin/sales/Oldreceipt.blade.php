@extends('admin.layouts.receipt')

@section('main-content')

  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-offset-3 col-md-6 ">
        <table class="table table-sm table-responsive table-sm table-responsive table-bordered">
          <!-- <caption>Owner</caption> -->
          <tr>
              <td colspan="3" class="text-center"><h3>{!! $apps->site_name !!}</h3></td>
          </tr>
            <tr>
              <td colspan="3">
                <address>
                  Address:{!! $apps->contact_address !!}<br>
                  Phone: {!! $apps->contact_phones !!}
                </address>

              </td>
            </tr>
            <tr>
                <td>Customer :</td>
                <td> {!! $tran->customer_name !!} </td>
                <td> Date: {!! $tran->tr_date !!} </td>
            </tr>
            <tr >
                <td>Transaction #:</td>
                <td>{!! $tran->transaction_no !!}</td>
                <td>
                    Invoice Status:
                    @if($tran->mode_of_payment_id == 5)
                      <b style="color:Red">Credit Account</b>
                    @else
                        <b style="color:Green">Paid</b>
                    @endif
                </td>
            </tr>
            <tr>
              <td colspan="3">
                 Invoice Prepare by :  {{ Auth::user()->surname . ' ' . Auth::user()->firstname }} - {{ Auth::user()->designation }}
              </td>
            </tr>
        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">

          <thead class="thead-dark">
              <tr>
                  <th>#</th>
                  <th>Item Description</th>
                  <th>Price </th>
                  <th>Qty</th>
                  <th>Total </th>
              </tr>
          </thead>
          <tbody>
              <?php $si=1; ?>
              @foreach ($sale as $sales)
                <tr>
                  <td>{{  $si++ }}</td>
                  <td>{!!  $sales->product->product_name !!}</td>
                  <td>{{  '₦'. $sales->sale_price }}</th>
                  <td>{{  $sales->quantity_buy }}</td>
                  <td>{{  '₦'. number_format($sales->total_amount) }}</td>
                </tr>
                @if ($sales->promo_qt >0 )
                     <tr>
                    <td>#</td>
                    <td>{!!  $sales->product->product_name !!} Promo </td>
                    <td>{{  '₦'}}</th>
                    <td>{{  $sales->promo_qt }}</td>
                    <td>{{  '₦' }}</td>
                </tr>
                @endif
              @endforeach
                <tr>

                  <td colspan="2">Total</td>
                  <td></td>
                  <td></td>
                  <td>{!! '₦'. number_format($my_sums)!!}</td>
                </tr>
                <tr>

                  <td colspan="2">Amount in Words</td>
                  <td colspan="3">{!! convert_number_to_words($my_sums)!!} Naira Only</td>
                </tr>
          </tbody>

        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">
          @if($tran->customer_type_id == 2 || $tran->customer_type_id == 3)            
              <tr>
                <td>
                  @if($tran->deposit_b4  > 0)
                    {{'Deposit B4'}}
                  @else
                    {!!' Creadit B4'!!}
                  @endif
                </td>

                <td colspan="2">
                  @if($tran->current_deposit > 0)
                    {{ '₦'.$tran->deposit_b4 }} 
                  @else
                    {!! '₦'.$tran->credit_b4 !!}
                  @endif
                </td>
              </tr>  
              <tr>
                <td>
                  @if($tran->current_deposit > 0)
                    {{ 'Current Deposit' }}
                  @else
                    {!! 'Current Credit' !!}
                  @endif
                </td>

                <td colspan="2">
                  @if($tran->current_deposit > 0)
                  {{ '₦'.$tran->current_deposit }}
                  @else
                  {!! '₦'.$tran->current_credit !!}
                  @endif
                </td>
              </tr>      
          @endif

          <tr>
            <td>
              &nbsp;--------------------
            </td>
            <td>
              &nbsp;
            </td>
            <td align="center">
              &nbsp;--------------------
            </td>
          </tr>
          <tr>
            <td>
              Cashier's Signature
            </td>
            <td>
                 &nbsp;
            </td>
            <td align="center">
              Customer's Signature
            </td>
          </tr>
          <tr>

            <td class="noprint">
              <!-- @if( $rdate_ ==  $lastDay)
                @if (Auth::user()->is_admin == 2) -->
                    <a href="{{ route('sales.show',$tran->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit Invoice</a> | <a href="{{ route('home') }}" class="btn btn-info"><i class="fa fa-hand-o-left"></i> Back</a>
               <!--  @endif
              @else
                <a href="{{ route('home') }}" class="btn btn-info"><i class="fa fa-hand-o-left"></i> Back</a>
              @endif -->

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
