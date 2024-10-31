<ul class="btns">
    <li @routeactive('categ*')><a href="{{ route('categories.index') }}">@lang('admin.plans_and_rules')</a></li>
    <li @routeactive('food*')><a href="{{ route('foods.index') }}">@lang('admin.foods')</a></li>
    <li @routeactive('child*')><a href="{{ route('childs.index') }}">@lang('admin.childs')</a></li>
</ul>