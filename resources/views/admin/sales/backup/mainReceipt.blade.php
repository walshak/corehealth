@extends('admin.layouts.receipt')

@section('title-content')
  {{ $app->site_name . ' - ' . $tran->customer_name  }}
@endsection

@section('main-content')

  <div id="supplyNote" class="row">
    <div class="col-md-3"></div>
    <div class="col-md-offset-3 col-md-6">
        <br>
        <table class="table table-sm table-responsive table-sm table-responsive table-bordered">
         <div id="site_name_font" class="supplynote">Supply Note...</div>
          <tr>
              <td colspan="3" class="text-center"><h3 id="site_name_font">{!! $apps->site_name !!}</h3></td>
          </tr>
            <tr>
              <td colspan="3">
                {{--  <address>  --}}
                  Address: {!! $apps->contact_address !!}<br>
                  Phone: {!! $apps->contact_phones !!}
                {{--  </address>  --}}

              </td>
            </tr>
            <tr>
                <td>Customer:</td>
                <td> {!! ucwords($tran->customer_name) !!} </td>
                <td> Date: {!! $tran->tr_date !!} </td>
            </tr>
            <tr>
                <td>Transaction #:</td>
                <td>{!! $tran->transaction_no !!}</td>
                <td>
                    Status: {!! getInvoiceStatus($tran->mode_of_payment_id) !!}

                </td>
            </tr>
            <tr>
                <td>Mode of Payment:</td>
                <td colspan="2">{!! typeOfPaymentOnReceipt($tran->mode_of_payment_id) !!}</td>
            </tr>
            <tr>
              <td>
                 Invoice Prepare by :
              </td>
              <td colspan="2">
                {{ Auth::user()->surname . ' ' . Auth::user()->firstname }} - {{ Auth::user()->designation }}
              </td>
            </tr>
        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">

            <thead class="thead-dark">
                {{--  <tr>
                    <th colspan="2" class="text-xs-center"><h2 >Supply Note</h2></th>
                </tr>  --}}
                <tr>
                    <th style="size: 50px">Qty</th>
                    <th style="size: 50px">Item Desc.</th>
                    {{-- <th>Unit Price </th> --}}
                    {{--  <th>Qty</th>  --}}
                    {{-- <th>Total </th> --}}
                </tr>
            </thead>
            <tbody>

                @foreach ($sale as $sales)
                    <tr>
                        <td>{{  $sales->quantity_buy }}</td>
                        <td>{!!  ucwords($sales->product->product_name) !!}</td>
                        {{-- <td>{{  '₦'. $sales->sale_price }}</th> --}}
                        {{-- <td>{{  '₦'. number_format($sales->total_amount) }}</td> --}}
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
                        {{-- <tr>

                            <td class="idTextExtHead" colspan="2"><b>Total Amount</b></td>
                            <td></td>
                            <td class="idTextExtHead"><b>{!! '₦'. number_format($my_sums)!!}</b></td>
                        </tr>
                        <tr>

                        <td colspan="2"><b>Amount in Words</b></td>
                        <td colspan="2">{!! convert_number_to_words($my_sums)!!} Naira Only</td>
                        </tr> --}}
            </tbody>

        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">
          @if($tran->customer_type_id == 2 || $tran->customer_type_id == 3)
              <tr>
                <td>
                  @if($customer->deposite_b4 > 0)
                    {{'Deposit Before'}}
                  @else
                    {!!' Credit Before'!!}
                  @endif
                </td>

                <td colspan="2">
                  @if($customer->deposit > 0)
                    {{ '₦'.$customer->deposite_b4 }}
                  @else
                    {!! '₦'.$customer->credit_b4 !!}
                  @endif
                </td>
              </tr>
              <tr>
                <td>
                  @if($customer->deposit > 0)
                    {{ 'Current Deposit' }}
                  @else
                    {!! 'Current Credit' !!}
                  @endif
                </td>

                <td colspan="2">
                  @if($customer->deposit > 0)
                  {{ '₦'.$customer->deposit }}
                  @else
                  {!! '₦'.$customer->creadit !!}
                  @endif
                </td>
              </tr>
          @endif

          <tr>
            <td>
              {!! QrCode::size(100)->generate(ucwords($tran->customer_name). ' - ' . $tran->transaction_no. ' - '.$tran->tr_date . ' ' . 'Paid' ); !!}
            </td>
            <td>
              &nbsp;
            </td>
            <td id="cashier" class="text-center">
                Product Manager Signature & Stamp.
            </td>
          </tr>
          <tr>
              <td colspan="3">
                This supply note cannot be used for sales, it is for supply <em><b>ONLY</b></em> signed management.
              </td>
          </tr>
        </table>
    </div>
    <div class="col-md-3"></div>
  </div>

  <div class="pagebreak"></div>

  <div id="customerNote" class="row">
    <div class="col-md-3"></div>
    <div class="col-md-offset-3 col-md-6">
        <br>
        <table class="table table-sm table-responsive table-sm table-responsive table-bordered">
            <div id="site_name_font" class="supplynote">Customer's Copy...</div>
          <tr>
              <td colspan="3" class="text-center"><h3 id="site_name_font">{!! $apps->site_name !!} </h3></td>
          </tr>
            <tr>
              <td colspan="3">
                {{--  <address>  --}}
                  Address: {!! $apps->contact_address !!}<br>
                  Phone: {!! $apps->contact_phones !!}
                {{--  </address>  --}}

              </td>
            </tr>
            <tr>
                <td>Customer:</td>
                <td> {!! $tran->customer_name !!} </td>
                <td> Date: {!! $tran->tr_date !!} </td>
            </tr>
            <tr>
                <td>Transaction #:</td>
                <td>{!! $tran->transaction_no !!}</td>
                <td>
                    Status: {!! getInvoiceStatus($tran->mode_of_payment_id) !!}

                </td>
            </tr>
            <tr>
                <td>Mode of Payment:</td>
                <td colspan="2">{!! typeOfPaymentOnReceipt($tran->mode_of_payment_id) !!}</td>
            </tr>
            <tr>
              <td>
                 Invoice Prepare by :
              </td>
              <td colspan="2">
                {{ Auth::user()->surname . ' ' . Auth::user()->firstname }} - {{ Auth::user()->designation }}
              </td>
            </tr>
        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">

            <thead class="thead-dark">
                <tr>
                    <th>Qty</th>
                    <th>Item Desc.</th>
                    <th>Unit Price </th>
                    {{--  <th>Qty</th>  --}}
                    <th>Total </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($sale as $sales)
                    <tr>
                        <td>{{  $sales->quantity_buy }}</td>
                        <td>{!!  ucwords($sales->product->product_name) !!}</td>
                        <td>{{  '₦'. $sales->sale_price }}</th>
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

                            <td class="idTextExtHead" colspan="2"><b>Total Amount</b></td>
                            <td></td>
                            <td class="idTextExtHead"><b>{!! '₦'. number_format($my_sums)!!}</b></td>
                        </tr>
                        <tr>

                        <td colspan="2"><b>Amount in Words</b></td>
                        <td colspan="2">{!! convert_number_to_words($my_sums)!!} Naira Only</td>
                        </tr>
            </tbody>

        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">
          @if($tran->customer_type_id == 2 || $tran->customer_type_id == 3)
              <tr>
                <td>
                  @if($customer->deposite_b4 > 0)
                    {{'Deposit Before'}}
                  @else
                    {!!' Credit Before'!!}
                  @endif
                </td>

                <td colspan="2">
                  @if($customer->deposit > 0)
                    {{ '₦'.$customer->deposite_b4 }}
                  @else
                    {!! '₦'.$customer->credit_b4 !!}
                  @endif
                </td>
              </tr>
              <tr>
                <td>
                  @if($customer->deposit > 0)
                    {{ 'Current Deposit' }}
                  @else
                    {!! 'Current Credit' !!}
                  @endif
                </td>

                <td colspan="2">
                  @if($customer->deposit > 0)
                  {{ '₦'.$customer->deposit }}
                  @else
                  {!! '₦'.$customer->creadit !!}
                  @endif
                </td>
              </tr>
          @endif

          <tr>
            <td class="border border-top-0 border-left-0 border-right-0" style="border: dotted;">

            </td>
            <td>
              &nbsp;
            </td>
            <td align="middle">
                {{--  {!! QrCode::size(100)->generate(ucwords($tran->customer_name). ' - ' . $tran->transaction_no. ' - '.$tran->tr_date . ' ' . 'Paid' ); !!}  --}}

            </td>
          </tr>
          <tr>
            <td id="cashier" align="middle">
              <div id="cashier">Cashiers Signature</div>
            </td>
            <td>
                 &nbsp;
            </td>
            <td>
                Customer Signature
            </td>

          </tr>

          </tr>
        </table>
    </div>
    <div class="col-md-3"></div>
  </div>

   <div class="pagebreak"></div>

  <div id="cashierNote" class="row">
    <div class="col-md-3"></div>
    <div class="col-md-offset-3 col-md-6">
        <br>
        <table class="table table-sm table-responsive table-sm table-responsive table-bordered">
           <div id="site_name_font" class="supplynote">Cashier's Copy...</div>
          <tr>
              <td colspan="3" class="text-center"><h3 id="site_name_font">{!! $apps->site_name !!} </h3></td>
          </tr>
            <tr>
              <td colspan="3">
                {{--  <address>  --}}
                  Address: {!! $apps->contact_address !!}<br>
                  Phone: {!! $apps->contact_phones !!}
                {{--  </address>  --}}

              </td>
            </tr>
            <tr>
                <td>Customer:</td>
                <td> {!! $tran->customer_name !!} </td>
                <td> Date: {!! $tran->tr_date !!} </td>
            </tr>
            <tr>
                <td>Transaction #:</td>
                <td>{!! $tran->transaction_no !!}</td>
                <td>
                    Status: {!! getInvoiceStatus($tran->mode_of_payment_id) !!}

                </td>
            </tr>
            <tr>
                <td>Mode of Payment:</td>
                <td colspan="2">{!! typeOfPaymentOnReceipt($tran->mode_of_payment_id) !!}</td>
            </tr>
            <tr>
              <td>
                 Invoice Prepare by :
              </td>
              <td colspan="2">
                {{ Auth::user()->surname . ' ' . Auth::user()->firstname }} - {{ Auth::user()->designation }}
              </td>
            </tr>
        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">

            <thead class="thead-dark">
                <tr>
                    <th>Qty</th>
                    <th>Item Desc.</th>
                    <th>Unit Price </th>
                    {{--  <th>Qty</th>  --}}
                    <th>Total </th>
                </tr>
            </thead>
            <tbody>

                @foreach ($sale as $sales)
                    <tr>
                        <td>{{  $sales->quantity_buy }}</td>
                        <td>{!!  ucwords($sales->product->product_name) !!}</td>
                        <td>{{  '₦'. $sales->sale_price }}</th>
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

                            <td class="idTextExtHead" colspan="2"><b>Total Amount</b></td>
                            <td></td>
                            <td class="idTextExtHead"><b>{!! '₦'. number_format($my_sums)!!}</b></td>
                        </tr>
                        <tr>

                        <td colspan="2"><b>Amount in Words</b></td>
                        <td colspan="2">{!! convert_number_to_words($my_sums)!!} Naira Only</td>
                        </tr>
            </tbody>

        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">
          @if($tran->customer_type_id == 2 || $tran->customer_type_id == 3)
              <tr>
                <td>
                  @if($customer->deposite_b4 > 0)
                    {{'Deposit Before'}}
                  @else
                    {!!' Credit Before'!!}
                  @endif
                </td>

                <td colspan="2">
                  @if($customer->deposit > 0)
                    {{ '₦'.$customer->deposite_b4 }}
                  @else
                    {!! '₦'.$customer->credit_b4 !!}
                  @endif
                </td>
              </tr>
              <tr>
                <td>
                  @if($customer->deposit > 0)
                    {{ 'Current Deposit' }}
                  @else
                    {!! 'Current Credit' !!}
                  @endif
                </td>

                <td colspan="2">
                  @if($customer->deposit > 0)
                  {{ '₦'.$customer->deposit }}
                  @else
                  {!! '₦'.$customer->creadit !!}
                  @endif
                </td>
              </tr>
          @endif

          <tr>
            <td class="border border-top-0 border-left-0 border-right-0" style="border: dotted;">

            </td>
            <td>
              &nbsp;
            </td>
            <td align="middle">
                {{--  {!! QrCode::size(100)->generate(ucwords($tran->customer_name). ' - ' . $tran->transaction_no. ' - '.$tran->tr_date . ' ' . 'Paid' ); !!}  --}}
            </td>
          </tr>
          <tr>
            <td id="cashier" align="middle">
              <div id="cashier" >Cashiers Signature</div>
            </td>
            <td>
                 &nbsp;
            </td>
            <td>
                Customer Signature
            </td>
          </tr>
          <tr>

            <td class="noprint">
              @if( $rdate_ ==  $lastDay)
                @if (Auth::user()->is_admin == 2)
                    <a href="{{ route('sales.show',$tran->id) }}" class="btn btn-info"><i class="fa fa-pencil"></i> Edit Invoice</a> | <a href="{{ route('home') }}" class="btn btn-info"><i class="fa fa-hand-o-left"></i> Back</a>
                @endif
              @else
                    <a href="{{ route('home') }}" class="btn btn-info"><i class="fa fa-hand-o-left"></i> Back</a>
              @endif

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
