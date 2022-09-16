<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header border-transparent">
                <h3 class="card-title">Product Re-Order Notification</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="table-responsive">
                    <table id="productsAlert" class="table table-sm table-responsive table-striped">
                        <thead>
                            <tr>
                                <th>Sn</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th>Re-Order Level</th>
                                <th>Current Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sn = 1; ?>
                            @foreach ($products as $product)
                            <tr>
                                <td><a href="">{{ $sn }}</a></td>
                                <td>{{ $product->product_name }}</td>

                                <td>{!! reOrderAlertFlag($product->id, $product->reorder_alert) !!}</td>
                                <td><span class="badge badge-pill badge-info">{{ $product->reorder_alert }}</span></td>
                                <td>
                                    <span class="badge badge-pill badge-primary">
                                        @foreach ($product->storeStock as $s)
                                            {{ $s->current_quantity }}
                                        @endforeach

                                    </span>
                                </td>
                            </tr>
                            <?php $sn++; ?>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer clearfix">
                <a href="javascript:void(0)" class="btn btn-sm btn-info float-left">Place New Order</a>
                <a href="javascript:void(0)" class="btn btn-sm btn-secondary float-right">View All Orders</a>
            </div>
        </div>
    </div>

</div>
<div class="row">

    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recently Added Products</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <table id="productsCreate" class="table table-sm table-responsive table-striped">
                    <thead>
                        <tr>
                            <th>Sn</th>
                            <th>Product</th>

                            <th colspan="2">Month Added</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $sn = 1; ?>
                        @foreach ($products as $product)
                        @if ($product->created_at->format('M') == \Carbon\Carbon::now()->format('M'))
                        <tr>
                            <td><a href="">{{ $sn }}</a></td>
                            <td>{{ $product->product_name }}</td>
                            <td></td>
                            <td>
                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                    @if ($product->created_at->format('M') == \Carbon\Carbon::now()->format('M'))
                                    <span
                                        class="badge badge-pill badge-dark">{{ $product->created_at->format('M Y') }}</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @else
                        <tr>
                            <td><a href="">{{ $sn }}</a></td>
                            <td>{{ $product->product_name }}</td>
                            <td></td>
                            <td>
                                <div class="sparkbar" data-color="#00a65a" data-height="20">
                                    @if ($product->created_at->format('M') != \Carbon\Carbon::now()->format('M'))
                                    <span class="badge badge-pill badge-danger">
                                        {{ $product->created_at->format('M Y') }}
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endif

                        <?php $sn++; ?>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer text-center">
                <a href="javascript:void(0)" class="uppercase">View All Products</a>
            </div>
            <!-- /.card-footer -->
        </div>
    </div>
</div>
