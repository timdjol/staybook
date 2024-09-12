<div class="sidebar">
    <ul>
        @admin
            <li @routeactive('bill*')><a href="{{ route('bills.index')}}"><i class="fas fa-gauge"></i>
            @lang('admin.information')</a></li>
            <li @routeactive('listbooks.index')><a href="{{route('listbooks.index')}}"><i class="fa-regular
            fa-bell-concierge"></i> @lang('admin.bookings')</a></li>
        @endadmin
    </ul>
</div>
