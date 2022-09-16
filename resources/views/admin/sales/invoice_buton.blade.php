<!DOCTYPE html>
<html>
<head>
  
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
 

       Transaction Successful 
              <div class="row no-print">
                <div class="col-12">
                   
                   <a href="{{ route('sales.show',$trans->id) }}"  class="btn btn-primary float-left" style="margin-right: 5px;"><i class="fa fa-pencil"></i> Edit Invoice</a>
                   <a href="{{ route('transactions.show',$trans->id) }}"  class="btn btn-success float-right" style="margin-right: 5px;"><i class="fa fa-eye"></i> View Invoice</a> 
                  
                  
                </div>
              </div>
          
        
    
</div>

</body>
</html>
