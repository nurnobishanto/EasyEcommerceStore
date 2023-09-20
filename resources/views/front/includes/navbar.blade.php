<div class="">
    <ul class="navbar-nav align-items-center ">
        @foreach(getMenus() as $memu)
            <li class="nav-item dropdown w-100 w-lg-auto">
                <a class="nav-link @if($memu->children->count()>0)dropdown-toggle @endif" href="{{$memu->url}}" @if($memu->children->count()>0) role="button" data-bs-toggle="dropdown" aria-expanded="false" @endif >{{$memu->title}}</a>
                @if($memu->children->count()>0)
                    @include('front.includes.sub_menu', ['menus' => $memu->children])
                @endif
            </li>
        @endforeach
    </ul>
</div>
