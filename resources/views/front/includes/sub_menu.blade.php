<ul class="dropdown-menu">
    @foreach($menus as $menu)
    <li>
        <a class="dropdown-item" href="{{$menu->url}}">{{$menu->title}}</a>
    </li>
    @endforeach
</ul>
