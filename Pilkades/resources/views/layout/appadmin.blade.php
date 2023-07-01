
@include('layout.top')
@include('layout.menu')

<div>
    <main>
        <div class="container-fluid px-4">
            @include('sweetalert::alert')
            @yield('content')
        </div>
    </main>
</div>


@include('layout.bottom')