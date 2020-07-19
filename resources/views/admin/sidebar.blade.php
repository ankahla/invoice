<ul>

    @if ( App\Model\General::find(1)->first()->type == 1 )



        <li>

            <a href="<?php echo URL::to('dashboard');?>"
               <?php if (Request::segment(1) == 'dashboard') { ?> class="active" <?php } ?>>

                <i class="fa fa-home"></i> <span>{{ trans('invoice.dashboard') }}</span>

            </a>

        </li>



        <li>

            <a href="<?php echo URL::to('client');?>"
               <?php if (Request::segment(1) == 'client') { ?> class="active" <?php } ?>>

                <i class="fa fa-users"></i> <span>{{ trans('invoice.clients') }}</span>

            </a>

        </li>



        <li>

            <a href="<?php echo URL::to('product');?>"
               <?php if (Request::segment(1) == 'product') { ?> class="active" <?php } ?>>

                <i class="fa fa-puzzle-piece"></i> <span>{{ trans('invoice.products') }}</span>

            </a>

        </li>



        <li>

            <a href="<?php echo URL::to('invoice');?>"
               <?php if (Request::segment(1) == 'invoice') { ?> class="active" <?php } ?>>

                <i class="fa fa-file-pdf-o"></i> <span>{{ trans('invoice.invoices') }}</span>

            </a>

        </li>

        <li>

            <a href="<?php echo URL::to('quotation');?>"
               <?php if (Request::segment(1) == 'quotation') { ?> class="active" <?php } ?>>
                <i class="fa fa-file-text-o"></i> <span>{{ trans('invoice.quotations') }}</span>
            </a>
        </li>

        <li>

            <a href="<?php echo URL::to('report');?>"
               <?php if (Request::segment(1) == 'report') { ?> class="active" <?php } ?>>

                <i class="fa fa-line-chart"></i> <span>{{ trans('invoice.reports') }}</span>

            </a>

        </li>



    @endif



    @if ( App\Model\General::find(1)->first()->type == 2 )

        <li>

            <a href="<?php echo URL::to('admin');?>"
               <?php if (Request::segment(1) == 'admin') { ?> class="active" <?php } ?>>

                <i class="fa fa-home"></i> <span>{{ trans('invoice.dashboard') }}</span>

            </a>

        </li>


    @endif

    <li>

        <a href="<?php echo URL::to('user');?>"
           <?php if (Request::segment(1) == 'user') { ?> class="active" <?php } ?>>

            <i class="fa fa-users"></i> <span>{{ trans('invoice.users') }}</span>

        </a>

    </li>


    <li>

        <a href="<?php echo URL::to('language');?>"
           <?php if (Request::segment(1) == 'language' && !Request::segment(2)) { ?> class="active" <?php } ?>>

            <i class="fa fa-book"></i> <span>{{ trans('invoice.languages') }}</span>

        </a>

    </li>


    <li>

        <a href="<?php echo URL::to('setting');?>"
           <?php if (Request::segment(1) == 'setting') { ?> class="active" <?php } ?>>

            <i class="fa fa-cogs"></i> <span>{{ trans('invoice.settings') }}</span>

        </a>

    </li>


    <li>
		<form action="{{ url('/logout') }}" method="post" id="logout">
			@csrf
        <a href="#" onclick="document.getElementById('logout').submit();">

            <i class="fa fa-sign-out"></i> <span>{{ trans('invoice.logout') }}</span>

        </a>

		</form>

    </li>

</ul>