<nav class="bottom-mobile-nav">
    <a href="{{route('home')}}" class="bloc-icon">
        <i class="bi bi-house-door"></i>
    </a>
    <a href="{{route('categories')}}" class="bloc-icon">
        <i class="bi bi-menu-button-wide"></i>
    </a>

    <a href="{{route('products')}}" class="bloc-icon">
        <i class="bi bi-diagram-3-fill"></i>
    </a>
    <a href="{{route('checkout')}}" class="bloc-icon">
        <span class="cart-count badge rounded-pill bg-{{getSetting('theme_color')}}"></span>
        <i class="bi bi-basket mr-2"> </i>
    </a>
</nav>
