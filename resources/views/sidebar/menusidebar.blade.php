<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{ Request::is('home') ? 'active' : '' }}">
                    <a href="{{ route('home') }}"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
                </li>
                <li class="list-divider"></li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-boxes"></i> <span> Inventory </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a class="{{ Request::is('inventory') ? 'active' : '' }}" href="{{ route('inventory.index') }}"> View Inventory </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-cash-register"></i> <span> Sales </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a class="{{ Request::is('home') ? 'active' : '' }}" href="{{ route('home') }}"> View Sales </a></li>
                        <li><a class="{{ Request::is('home') ? 'active' : '' }}" href="{{ route('home') }}"> Edit Sales </a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-book"></i> <span> Payroll </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a href="salary.html">Employee Salary</a></li>
                        <li><a href="salary-veiw.html">Payslip</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#"><i class="fas fa-dollar-sign"></i> <span> Reimbursement </span> <span class="menu-arrow"></span></a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a class="{{ Request::is('reimbursements/list') ? 'active' : '' }}" href="{{ route('reimbursement.list') }}">Receipts</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-user-tag"></i>
                        <span> Manage Customers </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a class="{{ Request::is('customer') ? 'active' : '' }}" href="{{ route('customer.index') }}">View Customers</a></li>
                        <li><a class="{{ Request::is('customer/invoice') ? 'active' : '' }}" href="{{ route('customer.invoice') }}">Customer Invoice</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#">
                        <i class="fas fa-people-carry"></i>
                        <span> Manage Vendors </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a class="{{ Request::is('vendor') ? 'active' : '' }}" href="{{ route('vendor.index') }}">View Vendors</a></li>
                        <li><a class="{{ Request::is('home') ? 'active' : '' }}" href="{{ route('home') }}">Change Vendor Details</a></li>
                        <li><a class="{{ Request::is('billing') ? 'active' : '' }}" href="{{ route('billing.index') }}">Vendor Billing</a></li>
                    </ul>
                </li>
                <li class="submenu">
                    <a href="#">
                        <i class="fa fa-file-alt"></i>
                        <span> Financial Reports </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul class="submenu_class" style="display: none;">
                        <li><a class="{{ Request::is('financial-report') ? 'active' : '' }}" href="{{ route('financialreport.index') }}">Financial Statements</a></li>
                        <li><a class="{{ Request::is('financial-report/sales') ? 'active' : '' }}" href="{{ route('financialreport.salesreport') }}">Sales Report</a></li>
                        <li><a class="{{ Request::is('financial-report/vendor') ? 'active' : '' }}" href="{{ route('financialreport.vendorreport') }}">Vendor Report</a></li>
                        <li><a class="{{ Request::is('financial-report/inventory') ? 'active' : '' }}" href="{{ route('financialreport.inventoryreport') }}">Inventory Report</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>
