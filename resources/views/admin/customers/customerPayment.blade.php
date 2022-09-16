@extends('admin.layouts.receipt')

@section('title-content')
{{ $app->site_name . ' - ' . $trans->customer_name  }}
@endsection

@section('main-content')

<div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-offset-3 col-md-6">
        <br>
        <table class="table table-sm table-responsive table-sm table-responsive table-bordered">
            <!-- <caption>Owner</caption> -->
            <tr>
                <td colspan="3" class="text-center">
                    <h3>{!! $apps->site_name !!}</h3>
                </td>
            </tr>
            <tr>
                <td colspan="3">
                    {{--  <address>  --}}
                    Address:{!! $apps->contact_address !!}<br>
                    Phone: {!! $apps->contact_phones !!}
                    {{--  </address>  --}}

                </td>
            </tr>
            <tr>
                <td>Bill To:</td>
                <td> {!! $trans->customer_name !!} </td>
                <td> Date: {!! $trans->tr_date !!} </td>
            </tr>
            <tr>
                <td>Receipt #:</td>
                <td>{!! $trans->transaction_no !!}</td>
                <td>
                    Status:<b style="color:green"> Paid to Account</b>

                </td>
            </tr>
            <tr>
                <td>Mode of Payment:</td>
                <td colspan="2">{!! typeOfPaymentOnReceipt($trans->mode_of_payment_id) !!}</td>
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
                    <th colspan="3">Payment to Account</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Amount: </td>
                    <td colspan="3">{{ NAIRA_CODE . number_format($trans->total_amount) }}</td>

                </tr>
                <tr>
                    <td>Amount in Word: </td>
                    <td colspan="3" class="idTextHead"> {{ convert_number_to_words($trans->total_amount) }} Naira Only
                    </td>

                </tr>
                <tr>
                    <td>Total Credit Before: </td>
                    <td colspan="3" class="idTextExtHead">{{ NAIRA_CODE . number_format($trans->credit_b4) }}</td>
                </tr>

                <tr>
                    <td>Total Deposit Before: </td>
                    <td colspan="3" class="idTextExtHead">{{ NAIRA_CODE . number_format($trans->deposit_b4) }}</td>
                </tr>
                @if($trans->current_credit > 0)
                <tr>
                    <td>Total Current Credit: </td>
                    <td colspan="3" class="idTextExtHead">{{ NAIRA_CODE . number_format($trans->current_credit) }}</td>
                </tr>
                @endif

                @if($trans->current_deposit)
                <tr>
                    <td>Total Current Deposit: </td>
                    <td colspan="3" class="idTextExtHead">{{ NAIRA_CODE . number_format($trans->current_deposit) }}</td>
                </tr>
                @endif


                <tr>
                    <td class="pull-left">
                        <a href="{{ route('transactions.index') }}" class="btn btn-info"><i
                                class="fa fa-hand-o-left"></i> Back</a>
                    </td>
                    <td></td>
                    <td class="pull-right">
                        <button class="btn btn-success" onClick="window.print();"> <i class="fa fa-print"></i>
                            PRINT</button>
                    </td>
                </tr>
            </tbody>
        </table>


    </div>
    <div class="col-md-3"></div>
</div>

@endsection