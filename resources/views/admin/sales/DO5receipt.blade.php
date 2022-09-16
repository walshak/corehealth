@extends('admin.layouts.receipt')

@section('title-content')
  {{ $app->site_name . ' - ' . $tran->customer_name  }}
@endsection

@section('main-content')

    <div id="supplyNote" class="row">
        <div class="col-md-3"></div>
        <div class="col-md-offset-3 col-md-6">
            <br>
            {{--  <table id="printHeader" class="table table-sm table-responsive table-sm table-responsive table-bordered">  --}}
            <table id="printHeader" class="border">
                <div id="site_name_font" class="supplynote">Supply Note</div>
                <tr>
                    <td colspan="3" class="text-center">
                        <h3>{!! $apps->site_name !!}</h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Address: {!! $apps->contact_address !!}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Phone: {!! $apps->contact_phones !!}
                    </td>
                </tr>
                <tr class="rowHeight">
                    <td>Customer:</td>
                    <td colspan="2"> {!! ucwords($tran->customer_name) !!} </td>
                </tr>
                <tr>
                    <td>Transaction #:</td>
                    <td>{!! $tran->transaction_no !!}</td>
                    <td>
                        Status: {!! getInvoiceStatus($tran->mode_of_payment_id) !!}

                    </td>
                </tr>
                <tr>
                    <td colspan="2">Payment Mode: {!! typeOfPaymentOnReceipt($tran->mode_of_payment_id) !!}</td>
                    <td>Date: {!! dateSplit($tran->tr_date) !!}</td>
                </tr>
                <tr>
                    <td>
                        Invoice Prepare by :
                    </td>
                    <td colspan="2">
                    {{ Auth::user()->surname . ' ' . Auth::user()->firstname }} - {{ Auth::user()->designation }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
                            <thead>
                                <tr>
                                    {{--  <th width="10%">Qty</th>
                                    <th colspan="2">Item Desc.</th>  --}}
                                    <th width="5%">Qty</th>
                                    <th width="10%">Item Desc.</th>
                                    <th width="10%">Supplier.</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($sale as $sales)
                                    <tr>
                                        <td>{{  $sales->quantity_buy }}</td>
                                        <td>{!!  ucwords($sales->product->product_name) !!}</td>
                                        <td>{!!  ucwords(userfullname($sales->product->user_id)) !!}</td>
                                    </tr>
                                    @if ($sales->promo_qt > 0 )
                                        <tr>
                                            <td>{{ $sales->promo_qt }}</td>
                                            <td>{!!  ucwords($sales->product->product_name) !!} Promo </td>
                                            <td>{!!  ucwords(userfullname($sales->product->user_id)) !!}</td>

                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
                            <tr>
                                <td>
                                    {!! QrCode::size(70)->generate(ucwords($tran->customer_name). ' - ' . $tran->transaction_no. ' - '.$tran->tr_date . ' ' . 'Paid' ); !!}
                                </td>
                                <td>
                                    &nbsp;
                                </td>
                                <td id="cashier" class="text-center">
                                    Product Manager Signature & Stamp.
                                </td>
                            </tr>
                            {{--  <tr>
                                <td colspan="3">
                                    This supply note cannot be used for sales, it is for supply <em><b>ONLY</b></em> signed management.
                                </td>
                            </tr>  --}}
                        </table>
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
            <table id="printHeader" class="border">
                <div id="site_name_font" class="supplynote">Customers Copy</div>
                <tr>
                    <td colspan="3" class="text-center">
                        <h3>{!! $apps->site_name !!}</h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Address: {!! $apps->contact_address !!}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Phone: {!! $apps->contact_phones !!}
                    </td>
                </tr>
                <tr>
                    <td>Customer:</td>
                    <td colspan="2"> {!! $tran->customer_name !!} </td>
                </tr>
                <tr>
                    <td>Transaction #:</td>
                    <td>{!! $tran->transaction_no !!}</td>
                    <td>
                        Status: {!! getInvoiceStatus($tran->mode_of_payment_id) !!}

                    </td>
                </tr>
                <tr>
                    <td colspan="2">Payment Mode: {!! typeOfPaymentOnReceipt($tran->mode_of_payment_id) !!}</td>
                    <td>Date: {!! dateSplit($tran->tr_date) !!}</td>
                </tr>
                <tr>
                    <td>
                        Invoice Prepare by :
                    </td>
                    <td colspan="2">
                        {{ Auth::user()->surname . ' ' . Auth::user()->firstname }} - {{ Auth::user()->designation }}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>

                            <thead class="thead-dark">
                                <tr>
                                    <th width="10%">Qty</th>
                                    <th>Item Desc.</th>
                                    <th>Unit Price </th>
                                    {{--  <th>Qty</th>  --}}
                                    <th>Total </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($sale as $sales)
                                    <tr>
                                        <td width="5%">{{  $sales->quantity_buy }}</td>
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
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
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
                                <td class="border border-top-0 border-left-0 border-right-0" style="border: black 1px dotted;">

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
                    </td>
                </tr>
            </table>




        </div>
        <div class="col-md-3"></div>
    </div>

    <div class="pagebreak"></div>

    <div id="cashierNote" class="row">
        <div class="col-md-3"></div>
        <div class="col-md-offset-3 col-md-6">
            <table id="printHeader" class="border">
            <div id="site_name_font" class="supplynote">Cashiers Copy</div>
            <tr>
                    <td colspan="3" class="text-center">
                        <h3>{!! $apps->site_name !!}</h3>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Address: {!! $apps->contact_address !!}
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        Phone: {!! $apps->contact_phones !!}
                    </td>
                </tr>
                <tr>
                    <td>Customer:</td>
                    <td colspan="2"> {!! $tran->customer_name !!} </td>
                </tr>
                <tr>
                    <td>Transaction #:</td>
                    <td>{!! $tran->transaction_no !!}</td>
                    <td>
                        Status: {!! getInvoiceStatus($tran->mode_of_payment_id) !!}

                    </td>
                </tr>
                <tr>
                    <td colspan="2">Payment Mode:{!! typeOfPaymentOnReceipt($tran->mode_of_payment_id) !!}</td>
                    <td> Date: {!! dateSplit($tran->tr_date) !!} </td>
                </tr>
                <tr>
                <td>
                    Invoice Prepare by :
                </td>
                <td colspan="2">
                    {{ Auth::user()->surname . ' ' . Auth::user()->firstname }} - {{ Auth::user()->designation }}
                </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
                            <thead>
                                <tr>
                                    <th width="5%">Qty</th>
                                    <th>Item Desc.</th>
                                    <th>Unit Price </th>
                                    {{--  <th>Qty</th>  --}}
                                    <th>Total </th>
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($sale as $sales)
                                    <tr>
                                        <td width="5%">{{  $sales->quantity_buy }}</td>
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
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <table>
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
                            <tr class="noprint">
                                <td colspan="3">
                                    <div class="row">
                                        <div class="col-md-6 float-left">
                                           
                                                
                                                    @can('remove-customer-transactions')
                                                    <a href="{{ route('sales.show', $tran->id) }}" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i> Edit Invoice</a>
                                                    @endcan
                                               
                                           
                                            <a href="{{ route('home') }}" class="btn btn-info btn-sm"><i class="fa fa-hand-o-left"></i> Back</a>
                                        </div>
                                        <div class="col-md-6 float-right">
                                            <button class="btn btn-success btn-sm" onClick="window.print();" > <i class="fa fa-print"></i> PRINT</button>
                                            {{--  <button class="btn btn-success print_id_card" name="print_id_card" id="print_id_card"><i class="fa fa-print"></i> Print(s)</button>  --}}
                                            <input type="hidden" name="trans" id="trans" value="{{ $tran->id }}">
                                            <a href="{{ route('sales.index') }}" class="btn btn-warning btn-sm"><i class="fa fa-hand-o-left"></i> New Sale</a>
                                        </div>
                                </div>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>




        </div>
        <div class="col-md-3"></div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('plugins/jQuery/jquery.min.js') }}" ></script>
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('../node_modules/sweetalert2/dist/sweetalert2.all.js') }}" ></script>

<script type='text/javascript'>

    function popID(URL) {
        day = new Date();
        id = day.getTime();
        eval("page" + id +  " = window.open(URL, id, 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=450,left = 240,top = 0');" );
    }

    $(function() {
            $(document).on('click', '.print_id_card', function() {
            // create the url and pass it to the popID
            var url = "{!! url('receipt') !!}/"+ {!! $tran->id !!}
            {{--  alert(url);  --}}
            popID(url);

        });
    });

    </script>

@endsection
