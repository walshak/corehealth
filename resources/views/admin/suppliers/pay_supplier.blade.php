@extends('admin.layouts.receipt')

@section('title-content')
{{ $app->site_name . ' - ' . $trans->company_name  }}
@endsection

@section('main-content')


<div id="customerNote" class="row">
    <div class="col-md-3"></div>
    <div class="col-md-offset-3 col-md-6">
        <table id="printHeader" class="border">
            <div id="site_name_font" class="supplynote">Suppliers Copy</div>
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
                <td colspan="2"> {!! $trans->company_name !!} </td>
            </tr>
            <tr>
                <td>Transaction #:</td>
                <td>{!! $trans->transaction_no !!}</td>
                <td>
                    {{-- Status: {!! getInvoiceStatus($trans->mode_of_payment_id) !!} --}}
                    Status:

                </td>
            </tr>
            <tr>
                {{-- <td colspan="2">Payment Mode: {!! typeOfPaymentOnReceipt($trans->mode_of_payment_id) !!}</td> --}}
                <td colspan="2">Payment Mode: </td>
                {{-- <td>Date: {!! dateSplit($trans->tr_date) !!}</td> --}}
                <td>Date: </td>
            </tr>
            <tr>
                <td>
                    Invoice Prepare by :
                </td>
                <td colspan="2">
                    {{-- {{ Auth::user()->surname . ' ' . Auth::user()->firstname }} - {{ Auth::user()->designation }}
                    --}}
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <table>
                        <thead class="thead-dark">
                            <tr>
                                <td> Amount: </td>
                                <td colspan="3">
                                    <b>{{ $trans->last_payment }}</b>

                                </td>
                            </tr>
                            <tr>
                                <td>Amount in Word: </td>
                                <td colspan="3" style="font-size:11px" height="9">
                                    {{ convert_number_to_words($trans->last_payment) }} Naira Only
                                </td>
                            </tr>
                            <tr>
                                <td>Total Credit B4: </td>
                                <td colspan="3">{{$trans->credit_b}}</td>
                            </tr>
                            <tr>
                                <td>Total Deposit B4: </td>
                                <td colspan="3">
                                    {{ $trans->deposit_b4 }}
                                </td>
                            </tr>
                            @if($trans->credit >0)
                            <tr>
                                <td>Total Current Credit: </td>
                                <td colspan="3">
                                    {{ $trans->credit}}
                                </td>

                            </tr>
                            @endif

                            @if($trans->deposit >0)
                            <tr>
                                <td>Total Current Deposit: </td>
                                <td colspan="3">
                                    {{ $trans->deposit}}
                                </td>

                            </tr>
                            @endif

                        </thead>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    <table>


                        <tr>
                            <td class="border border-top-0 border-left-0 border-right-0"
                                style="border: black 1px dotted;">

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


@endsection

@section('scripts')
<script src="{{ asset('plugins/jQuery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('../node_modules/sweetalert2/dist/sweetalert2.all.js') }}"></script>

<script type='text/javascript'>
    function popID(URL) {
        day = new Date();
        id = day.getTime();
        eval("page" + id +  " = window.open(URL, id, 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=450,left = 240,top = 0');" );
    }

    $(function() {
            $(document).on('click', '.print_id_card', function() {
            // create the url and pass it to the popID
            var url = "{!! url('receipt') !!}/"+ {!! $trans->id !!}
            {{--  alert(url);  --}}
            popID(url);

        });
    });

</script>

@endsection