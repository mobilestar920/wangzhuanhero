<?php
/*
    $data = $menuel['elements']
*/

if (!function_exists('renderDropdown')) {
    function renderDropdown($data)
    {
        if (array_key_exists('slug', $data) && $data['slug'] === 'dropdown') {
            echo '<li class="c-sidebar-nav-dropdown">';
            echo '<a class="c-sidebar-nav-dropdown-toggle" href="#">';
            if ($data['hasIcon'] === true && $data['iconType'] === 'coreui') {
                echo '<i class="' . $data['icon'] . ' c-sidebar-nav-icon"></i>';
            }
            echo $data['name'] . '</a>';
            echo '<ul class="c-sidebar-nav-dropdown-items">';
            renderDropdown($data['elements']);
            echo '</ul></li>';
        } else {
            for ($i = 0; $i < count($data); $i++) {
                if ($data[$i]['slug'] === 'link') {
                    echo '<li class="c-sidebar-nav-item">';
                    echo '<a class="c-sidebar-nav-link" href="' . url($data[$i]['href']) . '">';
                    echo '<span class="c-sidebar-nav-icon"></span>' . $data[$i]['name'] . '</a></li>';
                } elseif ($data[$i]['slug'] === 'dropdown') {
                    renderDropdown($data[$i]);
                }
            }
        }
    }
}
?>


<div class="c-sidebar-brand">
    <img class="c-sidebar-brand-full" src="{{ url('/assets/brand/coreui-base-white.svg') }}" width="118" height="46" alt="CoreUI Logo">
    <img class="c-sidebar-brand-minimized" src="{{ url('assets/brand/coreui-signet-white.svg') }}" width="118" height="46" alt="CoreUI Logo">
</div>
<ul class="c-sidebar-nav">
    @if(Auth::user()->role == 0)
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/sellers') }}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-face"></use>
            </svg>
            销售管理
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/customers') }}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-people"></use>
            </svg>
            用户管理
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/apps') }}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-applications"></use>
            </svg>
            应用管理
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/scripts') }}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-description"></use>
            </svg>
            资源管理
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/sellings') }}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-chart-pie"></use>
            </svg>
            销售状态
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/me/apps') }}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-paw"></use>
            </svg>
            我的应用
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/news') }}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-envelope-open"></use>
            </svg>
            消息管理
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/logout') }}">
            <svg class="c-sidebar-nav-icon">
                <use xlink:href="/assets/icons/coreui/free-symbol-defs.svg#cui-exit-to-app"></use>
            </svg>
            退出
        </a>
    </li>
    @else
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/generation') }}">
            <i class="cib-opsgenie c-sidebar-nav-icon"></i>
            激活码
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/seller/sellings') }}">
            <i class="cib-opsgenie c-sidebar-nav-icon"></i>
            销售状态
        </a>
    </li>
    <li class="c-sidebar-nav-item">
        <a class="c-sidebar-nav-link" href="{{ url('/logout') }}">
            <i class="cib-opsgenie c-sidebar-nav-icon"></i>
            退出
        </a>
    </li>
    @endif
</ul>
<button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>