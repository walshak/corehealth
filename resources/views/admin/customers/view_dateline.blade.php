@extends('admin.layouts.receipt')

@section('main-content')

  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-offset-3 col-md-6 ">
         
        <table class="table table-sm table-responsive table-sm table-responsive table-striped">

          <thead class="thead-dark">
              <tr>
                  <th></th>
                  <th> </th>
	              <th> TOTAL CREDIT AS {{ $now }} </th>
	              <th></th>
                  <th></th>
              </tr> 
               <tr>
                  <th>#</th>
                  <th> Name</th>
	              <th>Phone </th>
	              <th>Credit Amount</th>
                  <th>Date Line</th>
              </tr>
          </thead>
          <tbody>
              <?php $si=1;?>
              @foreach ($data as $sales) 
                <tr>
                  <td>{{  $si++ }}</td>
                  <td>{!!  $sales->fullname !!}</td>
                  <td>{{   $sales->phone }}</th>
                  <td>{{  '₦'. number_format($sales->creadit)}}</td>

			@if($sales->date_line == $lastDay) 
				<td><b style="color:Green">{{  $sales->date_line  }}</b></td>
			@elseif($sales->date_line == $lastDay1 )
				<td> <b style="color:yellow">{{  $sales->date_line  }}</b></td>
			@else
				<td> <b style="color:red">{{ $sales->date_line  }}</b></td>
			
			@endif
                
                </tr>
              @endforeach 
                <tr>
                  
                 <td colspan="2">Total Credit</td>
                  <td></td>
                  <td>{!! '₦'. number_format($credit)!!}</td>
                  <td></td>
                  
                </tr>
                <tr>
                  
                  <td colspan="2">Amount in Words</td>
                  <td colspan="3">{!! convert_number_to_words($credit)!!} Naira Only</td>
                </tr>
          </tbody>

        </table>

        <table class="table table-sm table-responsive table-sm table-responsive table-striped">
          
          <tr>
            <td class="noprint">
              <button class="btn btn-success" onClick="window.print();" > <i class="fa fa-print"></i> PRINT</button>
            </td>
            <td class="noprint" align="rigth">
            <a href="{{ route('sales.index') }}" class="btn btn-warning"><i class="fa fa-hand-o-left"></i> back</a>
            </td>
          </tr>
        </table>
    </div>
    <div class="col-md-3"></div>
  </div>

  

@endsection

@section('scripts')

@endsection